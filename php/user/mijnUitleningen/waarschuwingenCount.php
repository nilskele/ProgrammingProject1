<?php
include "../../../database.php";

session_start();

$user_id = $_SESSION['user_id'];

// query om de blacklist_fk op te halen
$query = "SELECT blacklist_fk FROM USER WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($blacklist_id_fk);
$stmt->fetch();
$stmt->close();

echo json_encode($blacklist_id_fk);

?>