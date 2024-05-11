<?php
include('../../../database.php');
include('../../validation_functions.php');

// Check if the Beschrijving field is received via POST request
if(isset($_POST['beschrijving'])) {
    // Sanitize the Beschrijving input using validation function if necessary
    $beschrijving = $_POST['beschrijving'];

    // Query to select distinct besch_id from the database based on beschrijving
    $sql = "SELECT besch_id FROM BESCHRIJVING WHERE naam = ?";
    
    // Prepare the query
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param('s', $beschrijving);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // If besch_id exists for the beschrijving, return it as JSON
            $row = $result->fetch_assoc();
            echo json_encode(array('besch_id' => $row['besch_id']));
        } else {
            // If besch_id does not exist for the beschrijving, return false as JSON
            echo json_encode(array('exists' => false));
        }
    } else {
        // If query execution fails, return an error message
        echo json_encode(array('error' => 'Query execution failed'));
    }
} else {
    // If Beschrijving field is not received, return an error message
    echo json_encode(array('error' => 'Beschrijving field not received'));
}

// Close database connection
$conn->close();
?>