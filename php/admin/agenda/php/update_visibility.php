<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start(); // Start output buffering

include("../../../../database.php");

$response = array();

if ($conn->connect_error) {
    $response['error'] = 'Connection failed: ' . $conn->connect_error;
    echo json_encode($response);
    ob_end_clean();
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$itemId = intval($data['itemId']);
$lening_id = intval($data['lening_id']);
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
            $response['success'] = true;
        } catch (Exception $e) {
            $conn->rollback();
            $response['error'] = $e->getMessage();
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
            $response['success'] = true;
        } catch (Exception $e) {
            $conn->rollback();
            $response['error'] = $e->getMessage();
        }
    }
} elseif ($action === 'annuleer') {
    $conn->begin_transaction();
    try {
        // SQL query to check for matching records
        $checkenDefect = "SELECT d.*
        FROM DEFECT d
        JOIN MIJN_LENINGEN mu ON d.lening_id_fk = mu.lening_id
        WHERE mu.product_id_fk = ?;";
        $stmt = $conn->prepare($checkenDefect);
        if (!$stmt) {
            throw new Exception('Error preparing select statement: ' . $conn->error);
        }
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the query has a result
        if ($result->num_rows > 0) {
            $response['error'] = 'Er is een defect gemeld voor dit product';
        } else {
            // Update the PRODUCT table
            $veranderIsUitgeleend = "UPDATE PRODUCT 
                                     SET isUitgeleend = 0, 
                                         datumBeschikbaar = CURDATE() 
                                     WHERE product_id = ?";
            $stmt1 = $conn->prepare($veranderIsUitgeleend);
            if (!$stmt1) {
                throw new Exception('Error preparing update statement: ' . $conn->error);
            }
            $stmt1->bind_param("i",$itemId);
            if (!$stmt1->execute()) {
                throw new Exception('Error updating PRODUCT: ' . $stmt1->error);
            }
            $stmt1->close();

            // Delete from MIJN_LENINGEN
            $annuleerReservatie = "DELETE FROM MIJN_LENINGEN WHERE lening_id = ?";
            $stmt2 = $conn->prepare($annuleerReservatie);
            if (!$stmt2) {
                throw new Exception('Error preparing delete statement: ' . $conn->error);
            }
            $stmt2->bind_param("i",$lening_id);
            if (!$stmt2->execute()) {
                throw new Exception('Error deleting from MIJN_LENINGEN: ' . $stmt2->error);
            }
            $stmt2->close();

            $conn->commit();
            $response['success'] = true;
        }
        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        $response['error'] = $e->getMessage();
    }
} else {
    $visibility = intval($data['visibility']);
    if ($soort == "kit") {
        $updateZichtbaarheid = "UPDATE KIT SET zichtbaar = {$visibility} WHERE kit_id = {$itemId}";
    } else {
        $updateZichtbaarheid = "UPDATE PRODUCT SET zichtbaar = {$visibility} WHERE product_id = {$itemId}";
    }
    if ($conn->query($updateZichtbaarheid) === TRUE) {
        $response['visibility'] = $visibility;
    } else {
        $response['error'] = 'Error updating record: ' . $conn->error;
    }
}

$conn->close();

ob_end_clean(); // Clean the buffer and end buffering
echo json_encode($response);
?>
