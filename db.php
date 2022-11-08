<?php

$sname = "localhost";
$unmae = "root";
$password = "";

$db_name = "db_name";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    echo "connection error";
}