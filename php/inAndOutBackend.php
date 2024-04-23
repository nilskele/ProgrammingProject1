<?php
// Include database connection file
include('../database.php');

// Check if the selected date is provided
if (isset($_POST['selectedDate'])) {
    // Sanitize the input to prevent SQL injection
    $selectedDate = mysqli_real_escape_string($conn, $_POST['selectedDate']);

    // Query to retrieve rows from MIJN_LENINGEN table with user information
    $query = "SELECT l.*, u.voornaam, u.achternaam 
              FROM MIJN_LENINGEN l 
              INNER JOIN USER u ON l.user_id_fk = u.user_id
              WHERE l.Uitleendatum = '$selectedDate' OR l.terugbrengDatum = '$selectedDate'";
    
    $result = $conn->query($query);

    $rows = array();

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch all rows and store them in the array
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    // Output the array as JSON
    echo json_encode($rows);
} else {
    // If the selected date is not provided, return an error message
    echo "Selected date not provided";
}

// Close the database connection
$conn->close();
?>
