<?php
// Include your database connection file
include 'db_connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['Zoeken'])) {
    $naamItem = $_GET['Zoeken'];

    // Sanitize the input to prevent XSS
    $naamItem = htmlspecialchars($naamItem);

    // SQL query using a placeholder
    $sql = "SELECT ML.Uitleendatum, ML.terugbrengDatum, G.naam AS product_naam, P.product_id, P.zichtbaar
    FROM MIJN_LENINGEN ML
    JOIN PRODUCT P ON ML.product_id_fk = P.product_id
    JOIN GROEP G ON P.groep_id = G.groep_id
    WHERE G.naam = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameter
    $stmt->bind_param("s", $naamItem);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Array to store the results
    $loanDetails = array();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Store the results in an array
            $loanDetails[] = array(
                "product_id" => $row["product_id"],
                "product_naam" => $row["product_naam"],
                "Uitleendatum" => $row["Uitleendatum"],
                "terugbrengDatum" => $row["terugbrengDatum"],
                "zichtbaar" => $row["zichtbaar"]
            );
        }
    } else {
        echo "Geen resultaten gevonden";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Output the array contents
echo json_encode($loanDetails);
?>
