<?php
session_start();

session_unset();
session_destroy(); // kullanıcının çıkış işlemini yapıyoruz

header("Location: login.php");
