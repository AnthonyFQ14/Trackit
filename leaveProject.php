<?php

    session_start();

    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "DELETE FROM user_projects WHERE userId = ? AND projectId = ?";

    $stmt = $mysqli->stmt_init();

    if (! $stmt->prepare($sql)){
        die("SQL error: " + $mysqli->error);
    }

    $stmt-> bind_param("ii", $_SESSION['user_id'] , $_SESSION['projectId']);

    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        try {
            if ($stmt->execute()) {
                header('Location: landingPage.php');
                exit;
            }    
        }
        catch (mysqli_sql_exception $e) {
            die($e->getMessage() . " " . $e->getCode());
        }
    } else {
        echo "Not a member of project!";
    }
?>