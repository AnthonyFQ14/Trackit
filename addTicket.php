<?php

    session_start();

    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "INSERT INTO tickets (ticketName, category, description, projectId) VALUES (?,?,?,?)";

    $stmt = $mysqli->stmt_init();

    if (! $stmt->prepare($sql)){
        die("SQL error: " + $mysqli->error);
    }

    $stmt-> bind_param("ssss", $_POST["ticketName"], $_POST["category"], $_POST["bugDescription"], $_SESSION["projectId"]);

    try {
        if ($stmt->execute()) {
            header('Location: mainPage.php');
            exit;
        }
        
    }
    catch (mysqli_sql_exception $e) {
        
        die($e->getMessage() . " " . $e->getCode());
        
    }