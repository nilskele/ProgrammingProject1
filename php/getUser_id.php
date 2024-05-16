<?php
session_start();

$response = array();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $response['user_id'] = $user_id;
} else {
    $response['error'] = "Gebruiker is niet ingelogd.";
}


header('Content-Type: application/json');
echo json_encode($response);
?>
