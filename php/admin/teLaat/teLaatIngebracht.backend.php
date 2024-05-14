<?php
// Include database connection file
include('../../../database.php');

// Check if the selected date is provided

    // Sanitize the input to prevent SQL injection
    $currentDate = date("Y-m-d");

    // Query to retrieve rows from MIJN_LENINGEN table with user information
    // First query: filter by Uitleendatum and in_bezit
    $query1 = "SELECT l.*, 'Uitleendatum' AS queryType, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
               FROM MIJN_LENINGEN l 
               INNER JOIN USER u ON l.user_id_fk = u.user_id
               INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
               INNER JOIN GROEP g ON p.groep_id = g.groep_id
               WHERE l.terugbrengDatum < '$currentDate' AND l.isTerugGebracht = False";


    // Execute the first query
    $result1 = $conn->query($query1);
    $rows3 = array();

    // Check if there are any results from the first query
    if ($result1->num_rows > 0) {
        // Fetch all rows and store them in the array
        while ($row = $result1->fetch_assoc()) {
            $rows3[] = $row;
        }
    }
    echo json_encode($rows3);


// Close the database connection
$conn->close();
?>