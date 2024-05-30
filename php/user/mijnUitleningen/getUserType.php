<?php
include("../../../database.php");

session_start();

$usertype = $_SESSION['user_type'];

echo json_encode(['user_type' => $usertype]);
?>
