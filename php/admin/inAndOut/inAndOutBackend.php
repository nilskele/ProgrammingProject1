<?php
// Include database connection file
include('../../../database.php');

// Check if the selected date is provided
if (isset($_POST['selectedDate'])) {
    // Sanitize the input to prevent SQL injection
    $selectedDate = mysqli_real_escape_string($conn, $_POST['selectedDate']);

    // Initialize an empty array to store the results
    $combinedRows = array();

    // Query 1: Products with No Other Leasings Still Open
    $query1 = "SELECT DISTINCT l.lening_id, i.image_data, l.Uitleendatum, l.terugbrengDatum, d.watDefect, d.redenDefect, 
               'Uitleendatum' AS queryType, 'query1' AS source, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
               FROM MIJN_LENINGEN l
               INNER JOIN USER u ON l.user_id_fk = u.user_id
               INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
               INNER JOIN GROEP g ON p.groep_id = g.groep_id
               LEFT JOIN DEFECT d ON l.lening_id = d.lening_id_fk
               INNER JOIN IMAGE i ON g.image_id_fk = i.image_id
               WHERE l.Uitleendatum = '$selectedDate' 
               AND l.in_bezit = False AND l.isTerugGebracht = False";

    // Query 2: Products That Haven't Been Brought Back Yet
    $query2 = "SELECT DISTINCT l.lening_id, i.image_data, l.Uitleendatum, l.terugbrengDatum, d.watDefect, d.redenDefect, 
               'terugbrengDatum' AS queryType, 'query2' AS source, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
               FROM MIJN_LENINGEN l
               INNER JOIN USER u ON l.user_id_fk = u.user_id
               INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
               INNER JOIN GROEP g ON p.groep_id = g.groep_id
               LEFT JOIN DEFECT d ON l.lening_id = d.lening_id_fk
               INNER JOIN IMAGE i ON g.image_id_fk = i.image_id
               WHERE l.terugbrengDatum = '$selectedDate' 
               AND l.isTerugGebracht = False";

    // Query 3: Products That Have No Other Leasings Still Open
    $query3 = "SELECT DISTINCT l.lening_id, i.image_data, l.Uitleendatum, l.terugbrengDatum, d.watDefect, d.redenDefect, 
               'Uitleendatum' AS queryType, 'query3' AS source, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
               FROM MIJN_LENINGEN l
               INNER JOIN USER u ON l.user_id_fk = u.user_id
               INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
               INNER JOIN GROEP g ON p.groep_id = g.groep_id
               LEFT JOIN DEFECT d ON l.lening_id = d.lening_id_fk
               INNER JOIN IMAGE i ON g.image_id_fk = i.image_id
               WHERE l.Uitleendatum = '$selectedDate' 
               AND l.in_bezit = False
               AND NOT EXISTS (
                   SELECT 1 
                   FROM MIJN_LENINGEN l2 
                   WHERE l2.product_id_fk = l.product_id_fk 
                   AND l2.in_bezit = True
               )";

    // Execute the first query
    $result1 = $conn->query($query1);
    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $combinedRows[] = $row;
        }
    }

    // Execute the second query
    $result2 = $conn->query($query2);
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $combinedRows[] = $row;
        }
    }

    // Execute the third query
    $result3 = $conn->query($query3);
    if ($result3->num_rows > 0) {
        while ($row = $result3->fetch_assoc()) {
            $combinedRows[] = $row;
        }
    }

    // Output the combined array as JSON
    echo json_encode($combinedRows);
} else {
    echo json_encode(array("error" => "Selected date not provided"));
}

// Close the database connection
$conn->close();

?>
