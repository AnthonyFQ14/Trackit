<?php

// Connect to the database
$mysqli = require __DIR__ . "/database.php";

// Get all tickets from the database
$sql = "SELECT * FROM tickets WHERE projectId = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_SESSION["projectId"]);
$stmt->execute();
$result = $stmt->get_result();

// Loop through the tickets and create HTML for each one
$html = '';
while ($ticket = $result->fetch_assoc()) {
    $html .= '<a id="ticket' . $ticket['id'] . '" class="ticket" data-ticketid="' . $ticket['id'] . '" data-ticketname="' . $ticket['ticketName'] . '" data-ticketcategory="' . $ticket['category'] . '" data-ticketdescription="' . $ticket['description'] . '" data-ticketstatus="' . $ticket['status'] . '">' . $ticket['ticketName'] . '</a><br>';
}

// Return the HTML
return $html;
