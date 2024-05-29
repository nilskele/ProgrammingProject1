<?php
include("../../../database.php");

session_start();

// Fetch the user type from the session
$usertype = $_SESSION['user_type'];

// Return the user type
echo json_encode(['user_type' => $usertype]);
?>
