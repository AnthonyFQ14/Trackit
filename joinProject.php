<?php

    session_start();

    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "INSERT INTO user_projects (userId, projectId) VALUES (?,?)";

    $stmt = $mysqli->stmt_init();

    if (! $stmt->prepare($sql)){
        die("SQL error: " + $mysqli->error);
    }

    $stmt-> bind_param("ss", $_SESSION["user_id"], $_POST["projectId"]);

    try{

        if ($stmt->execute()){
            
            $_SESSION['projectId'] = $_POST['projectId'];
            header("Location: mainPage.php");
            exit;

        }

    }
    catch (mysqli_sql_exception $e) {

        die($e->getMessage() . " " . $e->getCode());

    }