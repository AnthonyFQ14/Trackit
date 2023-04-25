<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

 <style>
        body {
            font-family: Arial, sans-serif;
            color: #444444;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
            line-height: 1.5;
            text-align: center;
        }

        a {
            color: #0077FF;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0044BB;
        }
    </style>
<body>
    <div>
        <h1>Please</h1>
        <p><a href="loginPage.php">Log in</a> or <a href="signUpPage.php" >sign up</a></p>
    </div>
    
    
    
</body>
</html>