<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "./vendor/autoload.php";
include "database.php";

// kullanıcı giriş yapmış mı kontrol ediyoruz
if (isset($_SESSION["id"]) && isset($_SESSION["username"]) && isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["re_password"])) {
    // verideki özel karakterleri temizler
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // benzersiz, 6 haneli sayılardan oluşan doğrulama kodu oluşturur
    function generateVCode($length = 6)
    {
        $chars = '0123456789';
        $charsLength = strlen($chars);
        $vcode = '';
        for ($i = 0; $i < $length; $i++) {
            $vcode .= $chars[mt_rand(0, $charsLength - 1)];
        }
        return $vcode;
    }

    // doğrulama linki oluşturur
    function generateLink($email)
    {
        include "database.php";
        $config = include "./mail-config.php";

        $vcode = generateVCode();

        $query = "INSERT INTO mails(id, email, vcode) VALUES ('', '$email', '$vcode')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $link = $config["base_url"] . "verify.php?email=" . $email . "&vcode=" . $vcode;
            // $link = "https://" . $_SERVER["HTTP_HOST"] . "/" . basename(__DIR__) . "/verify.php?email=" . $email . "&vcode=" . $vcode;
            return $link;
        } else {
            return false;
        }
    }

    // kullanıcıya mail gönderir
    // doğrulama maili gönderebilmek için 'mail-config.php' dosyası içerisindeki ayarları
    // kendi sunucunuza göre değiştirin
    function sendMail($username, $email)
    {
        $mail = new PHPMailer(true);

        $config = include "./mail-config.php";

        try {
            // sunucu ayarları
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = $config["host"];
            $mail->SMTPAuth = true;
            $mail->Username = $config["username"];
            $mail->Password = $config["password"];
            $mail->SMTPSecure = "ssl";
            $mail->Port = $config["port"];
            $mail->CharSet = "UTF-8";

            // alıcılar
            $mail->setFrom($config["username"], "Admin");
            $mail->addAddress($email, $username);
            // $mail->addAddress('ellen@example.com');
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // Ekler
            // $mail->addAttachment('/var/tmp/file.tar.gz');
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            $link = generateLink($email);

            // içerik
            $mail->isHTML(true);
            $mail->Subject = "Doğrulama Linki";
            $mail->Body    = 'Aşağıdaki linke tıklayarak hesabınızı doğrulayabilirsiniz.</br></br><a href="' . $link . '" target="_blank">' . $link . "</a>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            header("Location: signup.php?error=" . $mail->ErrorInfo);
            return false;
        }
    }

    // verilerdeki özel karakterleri temizliyoruz
    $username = validate($_POST["username"]);
    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);
    $re_password = validate($_POST["re_password"]);

    // şifreyi ham haliyle alıp işlem yapmak istiyorsanız buradaki '$password' değişkenini kullanabilirsiniz

    // veri boşluk kontrolü yapıyoruz
    if (empty($username)) {
        header("Location: signup.php?error=username_empty");
        exit();
    } else if (empty($email)) {
        header("Location: signup.php?error=email_empty");
        exit();
    } else if (empty($password)) {
        header("Location: signup.php?error=password_empty");
        exit();
    } else if (empty($re_password)) {
        header("Location: signup.php?error=re_password_empty");
        exit();
    } else if ($password != $re_password) {
        header("Location: signup.php?error=passwords_not_matched");
        exit();
    } else {
        $password = md5($password); // şifreyi 'md5()' fonksiyonu ile şifreliyoruz

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            header("Location: signup.php?error=email_already_taken");
            exit();
        } else {
            $query = "INSERT INTO users(id, username, email, password, verified) VALUES ('', '$username', '$email', '$password', '0')";
            $result = mysqli_query($conn, $query); // veritabanına kullanıcıyı ekliyoruz

            if ($result) {
                // doğrulama maili gönderiyoruz
                if (sendMail($username, $email)) {
                    header("Location: signup.php?success=account_created_mail_sended");
                    exit();
                } else {
                    // header("Location: signup.php?error=mail_not_sended");
                    exit();
                }
            } else {
                header("Location: signup.php?error=account_could_not_be_created");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" type="text/css" href="./css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <form action="./signup.php" method="POST">
        <h3>Kayıt Ol</h3>
        <?php if (isset($_GET["success"]) && !empty($_GET["success"])) { ?>
            <div class="success"><?php echo $_GET["success"]; ?></div>
        <?php } ?>
        <?php if (isset($_GET["error"]) && !empty($_GET["error"])) { ?>
            <div class="error"><?php echo $_GET["error"]; ?></div>
        <?php } ?>
        <label for="username">Kullanıcı Adı</label>
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email" required>
        <label for="password">Şifre</label>
        <input type="password" name="password" placeholder="Şifre" required>
        <label for="re_password">Şifre Tekrar</label>
        <input type="password" name="re_password" placeholder="Şifre Tekrar" required>
        <button>Kayıt Ol</button>
        <p>Zaten hesabın var mı? <a href="./login.php">Giriş Yap</a></p>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
</body>

</html>