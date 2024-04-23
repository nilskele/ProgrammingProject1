<?php
include('../database.php'); // Include your database connection code here

// Check if the POST request contains the necessary data
if (isset($_POST['id']) && isset($_POST['action']) && isset($_POST['daysToAdd'])) {
    // Get the item ID, action, and daysToAdd from the POST request
    $id = $_POST['id'];
    $action = $_POST['action'];
    $daysToAdd = $_POST['daysToAdd'];

    // Perform the database update based on the action
    $query = "UPDATE MIJN_LENINGEN SET terugbrengDatum = DATE_ADD(terugbrengDatum, INTERVAL $daysToAdd DAY) WHERE id = $id";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result) {
        // Send a success response
        echo json_encode(['success' => true]);
    } else {
        // Send an error response
        echo json_encode(['success' => false, 'message' => 'Error updating database']);
    }
} else {
    // Send an error response if required data is missing
    echo json_encode(['success' => false, 'message' => 'Missing data']);
}
?>
