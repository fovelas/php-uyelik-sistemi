<?php
// veritabanı ayarları

$sname = "localhost"; // sunucu
$unmae = "root"; // kullanıcı adı
$password = "secret"; // şifre

$db_name = "uyelik_sistemi"; // veritabanı adı

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    echo "connection error";
}
