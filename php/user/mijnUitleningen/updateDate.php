<?php
include ('../../../database.php');

$lening_id = $_POST['lening_id'];
$action = $_POST['action'];

$query_select = "SELECT terugbrengDatum, isVerlenged FROM MIJN_LENINGEN WHERE lening_id = ?";
$stmt_select = $conn->prepare($query_select);
$stmt_select->bind_param('i', $lening_id);
$stmt_select->execute();
$stmt_select->bind_result($original_date, $isVerlenged);
$stmt_select->fetch();
$stmt_select->close();

$timestamp = strtotime($original_date);

if ($action === 'verlengen') {
  $new_timestamp = $timestamp + (7 * 24 * 60 * 60);
  $new_isVerlenged = 1;
} else {
  $new_timestamp = $timestamp - (7 * 24 * 60 * 60);
  $new_isVerlenged = 0;
}

$new_date = date('Y-m-d', $new_timestamp);

$query_update = "UPDATE MIJN_LENINGEN SET terugbrengDatum = ?, isVerlenged = ? WHERE lening_id = ?";
$stmt_update = $conn->prepare($query_update);
$stmt_update->bind_param('sii', $new_date, $new_isVerlenged, $lening_id);

if ($stmt_update->execute()) {
  echo json_encode(["success" => true, "message" => "Date updated successfully"]);
} else {
  echo json_encode(["success" => false, "message" => "Error updating date"]);
}

$stmt_update->close();
$conn->close();
?>