<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "127.0.0.1";
    $user = "root";
    $pword = "12345678";
    $dbase = "Trackit";

    // Create connection
    $mysqli = new mysqli($servername, $user, $pword, $dbase);

    if ($mysqli->connect_error) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    return $mysqli;
?>