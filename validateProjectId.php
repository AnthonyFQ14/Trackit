<?php

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM projects
                    WHERE id = '%s'",
                    $mysqli->real_escape_string($_GET["projectId"]));

    $result = $mysqli->query($sql);

    $is_valid = $result->num_rows === 1;

    header("Content-Type: application/json");

    echo json_encode(["valid" => $is_valid]);