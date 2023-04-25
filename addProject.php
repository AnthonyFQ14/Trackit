<?php
    session_start();

    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "INSERT INTO projects (projectName, description) VALUES (?,?)";

    $stmt = $mysqli->stmt_init();

    if (! $stmt->prepare($sql)){
        die("SQL error: " + $mysqli->error);
    }

    $stmt-> bind_param("ss", $_POST["projectName"], $_POST["projectDescription"]);
    
    
    try {
        if ($stmt->execute()) {
            
            $projectId = $mysqli->insert_id;
            
            $_SESSION["projectId"] = $projectId;
            
            $sql2 = "INSERT INTO user_projects (userId, projectId) VALUES (?,?)";

            $stmt2 = $mysqli->stmt_init();

            if (! $stmt2->prepare($sql2)){
                die("SQL error: " + $mysqli->error);
            }

            $stmt2-> bind_param("ss", $_SESSION["user_id"], $projectId);
            
            try{
                
                if ($stmt2->execute()){
                    
                    header("Location: mainPage.php");
                    exit;
                    
                }
                
            }
            catch (mysqli_sql_exception $e) {
        
                die($e->getMessage() . " " . $e->getCode());

            }
            
        }
    } 
    catch (mysqli_sql_exception $e) {
        
        die($e->getMessage() . " " . $e->getCode());
        
    }
    