<?php

$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "hotelbooking";

try {
    $connect = mysqli_connect($hostname, $username, $password, $dbname);
    // echo "connected";
} catch (Exception $e) {
    echo "error" . mysqli_connect_error();
}

function var_dump_pretty($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}
