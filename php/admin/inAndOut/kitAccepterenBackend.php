<?php
include('../../../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['kit_id_fk'])) {
    $Kit_id = $_GET['kit_id_fk'];

    // update kit wanneer deze wordt geaccepteerd
    $query = "UPDATE KIT
              SET isUitgeleend = false
              WHERE kit_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $Kit_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Kit successfully updated"]);
    } else {
        echo json_encode(["error" => "Failed to update kit"]);
    }

    $stmt->close();
}

$conn->close();
?>
