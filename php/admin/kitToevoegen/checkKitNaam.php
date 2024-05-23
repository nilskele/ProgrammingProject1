<?php
include("../../../database.php");


$response = array();

if (isset($_GET["kitNaam"])) {
    $kitNaam = $_GET["kitNaam"];
    
    $sql = "SELECT kit_naam FROM KIT WHERE kit_naam = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $kitNaam);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response["exists"] = true;
        } else {
            $response["exists"] = false;
        }

        $stmt->close();
    } else {
        $response["error"] = "Database query error: " . $conn->error;
    }
} else {
    $response["error"] = "kitNaam parameter not set";
}

$conn->close();
echo json_encode($response);
?>
