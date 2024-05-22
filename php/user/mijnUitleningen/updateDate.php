<?php
// Include your database connection file
include('../../../database.php');

// Retrieve parameters from AJAX request
$lening_id = $_POST['lening_id'];
$action = $_POST['action'];

// Fetch the original terugbrengDatum and isVerlenged from the database
$query_select = "SELECT terugbrengDatum, isVerlenged FROM MIJN_LENINGEN WHERE lening_id = ?";
$stmt_select = $conn->prepare($query_select);
$stmt_select->bind_param('i', $lening_id);
$stmt_select->execute();
$stmt_select->bind_result($original_date, $isVerlenged);
$stmt_select->fetch();
$stmt_select->close();

// Convert the original date to a Unix timestamp
$timestamp = strtotime($original_date);

// Check if we're adding or subtracting days
if ($action === 'verlengen') {
    // Add 7 days
    $new_timestamp = $timestamp + (7 * 24 * 60 * 60);
    // Update isVerlenged to true
    $new_isVerlenged = 1;
} else {
    // Subtract 7 days
    $new_timestamp = $timestamp - (7 * 24 * 60 * 60);
    // Update isVerlenged to false
    $new_isVerlenged = 0;
}

// Convert the new timestamp back to a date string
$new_date = date('Y-m-d', $new_timestamp);

// Prepare the SQL query
$query_update = "UPDATE MIJN_LENINGEN SET terugbrengDatum = ?, isVerlenged = ? WHERE lening_id = ?";
$stmt_update = $conn->prepare($query_update);
$stmt_update->bind_param('sii', $new_date, $new_isVerlenged, $lening_id);

// Execute the query to update the date and isVerlenged
if ($stmt_update->execute()) {
    // Send a response back to the client
    echo json_encode(["success" => true, "message" => "Date updated successfully"]);
} else {
    // If an error occurs, send an error response
    echo json_encode(["success" => false, "message" => "Error updating date"]);
}

// Close the statement and database connection
$stmt_update->close();
$conn->close();
?>
