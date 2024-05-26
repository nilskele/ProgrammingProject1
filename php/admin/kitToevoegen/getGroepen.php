<?php
include("../../../database.php");

header('Content-Type: application/json');

$response = array();

// fetch van alle groepen
$sql = "SELECT naam FROM GROEP";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    $groepen = array();
    while ($row = $result->fetch_assoc()) {
        $groepen[] = $row["naam"];
    }

    $response["groepen"] = $groepen;

    $stmt->close();
} else {
    $response["error"] = "Database query error: " . $conn->error;
}

echo json_encode($response);
?>
