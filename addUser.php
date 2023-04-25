<?php
    
    if(empty ($_POST["username"])){
        die("Name is Required");
    }

    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters");
    }

    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }

    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }

    if($_POST["password"] !== $_POST["passwordConfirm"]){
        die("Passwords Must Match");
    }

    $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "INSERT INTO users (username, password) VALUES (?,?)";

    $stmt = $mysqli->stmt_init();

    if (! $stmt->prepare($sql)){
        die("SQL error: " + $mysqli->error);
    }

    $stmt-> bind_param("ss", $_POST["username"], $passwordHash);

    try {
        if ($stmt->execute()) {
            header("Location: loginPage.php");
            exit;
            
        }
    } 
    catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            die("Username Already Taken");
        } 
        else {
            die($e->getMessage() . " " . $e->getCode());
        }
    }

    
//    print_r($_POST);
//    var_dump($passwordHash);