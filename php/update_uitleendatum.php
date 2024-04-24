<?php
// Include database connection file
include('../database.php');

// Check if leningId is provided
if (isset($_POST['leningId'])) {
    // Sanitize the input to prevent SQL injection
    $leningId = mysqli_real_escape_string($conn, $_POST['leningId']);

    // Query to update the Uitleendatum to NULL in the database
    $query = "UPDATE MIJN_LENINGEN SET Uitleendatum = NULL WHERE lening_id = '$leningId'";
    $query = "UPDATE MIJN_LENINGEN SET in_bezit = True WHERE lening_id = '$leningId'";
    
    if ($conn->query($query) === TRUE) {
        // If update is successful, return success message
        echo "success";
    } else {
        // If update fails, return error message
        echo "error";
    }
} else {
    // If leningId is not provided, return error message
    echo "Lening ID not provided";
}

// Close the database connection
$conn->close();
?>
