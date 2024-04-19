<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$zoekterm = isset($_GET['zoekbalk']) ? '%' . $_GET['zoekbalk'] . '%' : '%';
if ($zoekterm !== '%') {
    $stmt = $conn->prepare("SELECT naam FROM GROEP WHERE naam LIKE ?");
    $stmt->bind_param("s", $zoekterm);

    $stmt->execute();

    $resultaten = $stmt->get_result();

    $response = [];

    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row['naam'];
        }
    } else {
        $response['error'] = "Geen resultaten gevonden";
    }

    $stmt->close();

    $json = json_encode($response);
    echo $json;
}
