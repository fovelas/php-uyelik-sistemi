<?php
include "database.php";

if (isset($_GET["email"]) && isset($_GET["vcode"])) {
    $email = $_GET["email"];
    $vcode = $_GET["vcode"];

    // veri boşluk kontrolü
    if (empty($email)) {
        header("Location: login.php?error=email_empty");
        exit();
    } else if (empty($vcode)) {
        header("Location: login.php?error=vcode_empty");
        exit();
    }

    $query = "SELECT * FROM mails WHERE email = '$email' AND vcode = '$vcode'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $mail_id = $row["id"];

        $query = "UPDATE users SET verified = '1' WHERE email = '$email'";
        $result = mysqli_query($conn, $query); // kullanıcıyı onaylıyoruz artık giriş yapabilir

        if ($result) {
            $query = "DELETE FROM mails WHERE id = '$mail_id'";
            $result = mysqli_query($conn, $query); // mail doğrulama kodunu veritabanından siliyoruz

            if ($result) {
                header("Location: login.php?success=account_verified");
                exit();
            } else {
                header("Location: login.php?error=link_invalid");
                exit();
            }
        } else {
            header("Location: login.php?error=link_invalid");
            exit();
        }
    } else {
        header("Location: login.php?error=link_invalid");
        exit();
    }
} else {
    echo "link invalid";
}
