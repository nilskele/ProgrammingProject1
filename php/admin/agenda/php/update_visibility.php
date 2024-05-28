<?php
include("../../../../database.php");

if ($conn->connect_error) {
    echo json_encode(array('error' => 'Connection failed: ' . $conn->connect_error));
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$itemId = intval($data['itemId']);
$action = isset($data['action']) ? $data['action'] : '';
$soort = $data['soort'];

if ($action === 'delete') {
    $conn->begin_transaction();
    if ($soort == "kit") {
        try {
            $deleteKitProductQuery = "DELETE FROM KIT_PRODUCT WHERE kit_id_fk = {$itemId}";
            if (!$conn->query($deleteKitProductQuery)) {
                throw new Exception('Error deleting from KIT_PRODUCT: ' . $conn->error);
            }

            $deleteKitQuery = "DELETE FROM KIT WHERE kit_id = {$itemId}";
            if (!$conn->query($deleteKitQuery)) {
                throw new Exception('Error deleting from KIT: ' . $conn->error);
            }

            $conn->commit();
            echo json_encode(array('success' => true));
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(array('error' => $e->getMessage()));
        }
    } else {
        try {
            // Delete from MIJN_LENINGEN table first
            $deleteLendingQuery = "DELETE FROM MIJN_LENINGEN WHERE product_id_fk = {$itemId}";
            if (!$conn->query($deleteLendingQuery)) {
                throw new Exception('Error deleting from MIJN_LENINGEN: ' . $conn->error);
            }

            // Delete from PRODUCT table
            $deleteProductQuery = "DELETE FROM PRODUCT WHERE product_id = {$itemId}";
            if (!$conn->query($deleteProductQuery)) {
                throw new Exception('Error deleting from PRODUCT: ' . $conn->error);
            }

            $conn->commit();
            echo json_encode(array('success' => true));
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
} 

elseif ($action === 'annuleer') {
    $conn->begin_transaction();
    try {
        // SQL query to check for matching records
        $checkenDefect = "SELECT d.*
                          FROM DEFECT d
                          JOIN MIJN_LENINGEN mu ON d.lening_id_fk = mu.lening_id
                          WHERE mu.product_id_fk = {$itemId}";

        // Execute the query
        $result = $conn->query($checkenDefect);

        // Check if the query has a result
        if ($result->num_rows > 0) {
            echo json_encode(array('error' => 'Er is een defect gemeld voor dit product'));
        } else {
            // Update the PRODUCT table
            $veranderIsUitgeleend = "UPDATE PRODUCT SET isUitgeleend = 0 WHERE product_id = {$itemId}";
            if (!$conn->query($veranderIsUitgeleend)) {
                throw new Exception('Error updating PRODUCT: ' . $conn->error);
            }

            // Delete from MIJN_LENINGEN
            $annuleerReservatie = "DELETE FROM MIJN_LENINGEN WHERE product_id_fk = {$itemId}";
            if (!$conn->query($annuleerReservatie)) {
                throw new Exception('Error deleting from MIJN_LENINGEN: ' . $conn->error);
            }

            $conn->commit();
            echo json_encode(array('success' => true));
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(array('error' => $e->getMessage()));
    }
}

else {
    $visibility = intval($data['visibility']);
    if ($soort == "kit") {
        $updateZichtbaarheid = "UPDATE KIT SET zichtbaar = {$visibility} WHERE kit_id = {$itemId}";
    } else {
        $updateZichtbaarheid = "UPDATE PRODUCT SET zichtbaar = {$visibility} WHERE product_id = {$itemId}";
    }
    if ($conn->query($updateZichtbaarheid) === TRUE) {
        echo json_encode(array('visibility' => $visibility));
    } else {
        echo json_encode(array('error' => 'Error updating record: ' . $conn->error));
    }
}

$conn->close();
?>
