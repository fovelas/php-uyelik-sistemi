<?php
session_start();
include "database.php";

// kullanıcı giriş yapmış mı kontrol ediyoruz
if (isset($_SESSION["id"]) && isset($_SESSION["username"]) && isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);

    // şifreyi ham haliyle alıp işlem yapmak istiyorsanız buradaki '$password' değişkenini kullanabilirsiniz

    if (empty($email)) {
        header("Location: login.php?error=email_empty");
        exit();
    } else if (empty($password)) {
        header("Location: login.php?error=password_empty");
        exit();
    } else {
        $password = md5($password); // şifreyi 'md5()' fonksiyonu ile şifreliyoruz

        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if ($row["verified"] == "0") {
                header("Location: login.php?error=account_not_verified");
                exit();
            }

            if ($row["email"] == $email && $row["password"] == $password) {
                // kullanıcı giriş yapıyor
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];
                header("Location: index.php");
                exit();
            } else {
                header("Location: login.php?error=email_or_password_wrong");
                exit();
            }
        } else {
            header("Location: login.php?error=email_or_password_wrong");
            exit();
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
    <title>Giriş Yap</title>
    <link rel="stylesheet" type="text/css" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <form action="./login.php" method="POST">
        <h3>Giriş Yap</h3>
        <?php if (isset($_GET["success"]) && !empty($_GET["success"])) { ?>
            <div class="success"><?php echo $_GET["success"]; ?></div>
        <?php } ?>
        <?php if (isset($_GET["error"]) && !empty($_GET["error"])) { ?>
            <div class="error"><?php echo $_GET["error"]; ?></div>
        <?php } ?>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email" required>
        <label for="password">Şifre</label>
        <input type="password" name="password" placeholder="Şifre" required>
        <button>Giriş Yap</button>
        <p><a href="./signup.php">Hesap Oluştur</a></p>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
</body>

</html>