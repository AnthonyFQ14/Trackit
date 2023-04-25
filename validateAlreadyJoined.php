<?php

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user_projects
                    WHERE userId = '%s'
                    AND projectId = '%s'",
                    $mysqli->real_escape_string($_GET["userId"]),
                    $mysqli->real_escape_string($_GET["projectId"]));

    $result = $mysqli->query($sql);

    $is_Joined = $result->num_rows === 1;
    
    header("Content-Type: application/json");

    echo json_encode(["isJoined" => $is_Joined]);