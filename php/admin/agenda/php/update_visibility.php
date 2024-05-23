<?php
include("../../../../database.php");

if ($conn->connect_error) {
    echo json_encode(array('error' => 'Connection failed: ' . $conn->connect_error));
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$itemId = intval($data['itemId']);
$action = isset($data['action']) ? $data['action'] : '';

if ($action === 'delete') {
    $conn->begin_transaction();
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
} else {
    $visibility = intval($data['visibility']);
    $updateZichtbaarheid = "UPDATE PRODUCT SET zichtbaar = {$visibility} WHERE product_id = {$itemId}";
    if ($conn->query($updateZichtbaarheid) === TRUE) {
        echo json_encode(array('visibility' => $visibility));
    } else {
        echo json_encode(array('error' => 'Error updating record: ' . $conn->error));
    }
}

$conn->close();
?>
