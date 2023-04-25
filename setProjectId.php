<?php
session_start();

if (isset($_GET['id'])) {
  $_SESSION['projectId'] = $_GET['id'];
}

header('Location: mainPage.php');
exit;
?>