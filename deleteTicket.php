<?php

    session_start();

    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "DELETE FROM tickets WHERE id = ?";

    $stmt = $mysqli->stmt_init();

    if (! $stmt->prepare($sql)){
        die("SQL error: " + $mysqli->error);
    }

    $stmt-> bind_param("i", $_GET["id"]);

    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        try {
            if ($stmt->execute()) {
                header('Location: mainPage.php');
                exit;
            }    
        }
        catch (mysqli_sql_exception $e) {
            die($e->getMessage() . " " . $e->getCode());
        }
    } else {
        echo "Ticket ID is missing!";
    }
?>