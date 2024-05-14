<?php
// Include database connection file
include('../../../database.php');

// Check if the selected date is provided
if (isset($_POST['selectedDate'])) {
    // Sanitize the input to prevent SQL injection
    $selectedDate = mysqli_real_escape_string($conn, $_POST['selectedDate']);

    // Initialize an empty array to store the results
    $combinedRows = array();

    // Query to retrieve rows from MIJN_LENINGEN table with user information
    // Filter by Uitleendatum and in_bezit
    $query1 = "SELECT l.*, 'Uitleendatum' AS queryType, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
               FROM MIJN_LENINGEN l 
               INNER JOIN USER u ON l.user_id_fk = u.user_id
               INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
               INNER JOIN GROEP g ON p.groep_id = g.groep_id
               WHERE l.Uitleendatum = '$selectedDate' AND l.in_bezit = False";

    // Query to retrieve rows from MIJN_LENINGEN table with user information
    // Filter by terugbrengDatum and isTerugGebracht
    $query2 = "SELECT l.*, 'terugbrengDatum' AS queryType, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
               FROM MIJN_LENINGEN l 
               INNER JOIN USER u ON l.user_id_fk = u.user_id
               INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
               INNER JOIN GROEP g ON p.groep_id = g.groep_id
               WHERE l.terugbrengDatum = '$selectedDate' AND l.isTerugGebracht = 'False'";

    // Execute the first query
    $result1 = $conn->query($query1);

    // Check if there are any results from the first query
    if ($result1->num_rows > 0) {
        // Fetch all rows and store them in the combined array
        while ($row = $result1->fetch_assoc()) {
            $combinedRows[] = $row;
        }
    }

    // Execute the second query
    $result2 = $conn->query($query2);

    // Check if there are any results from the second query
    if ($result2->num_rows > 0) {
        // Fetch all rows and store them in the combined array
        while ($row = $result2->fetch_assoc()) {
            $combinedRows[] = $row;
        }
    }

    // Output the combined array as JSON
    echo json_encode($combinedRows);
} else {
    // If the selected date is not provided, return an error message
    echo json_encode(array("error" => "Selected date not provided"));
}

// Close the database connection
$conn->close();
?>
