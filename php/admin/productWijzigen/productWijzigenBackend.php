<?php
include('../../../database.php');

// Ensure all required fields are present
$merk = isset($_POST["merk"]) ? $_POST["merk"] : null;
$productNaam = isset($_POST["productName"]) ? $_POST["productName"] : null;
$category = isset($_POST["category"]) ? $_POST["category"] : null;
$beschrijving = isset($_POST["beschrijving"]) ? $_POST["beschrijving"] : null;
$productId = isset($_POST["product_id"]) ? $_POST["product_id"] : null;

if (is_null($merk) || is_null($productNaam) || is_null($category) || is_null($beschrijving) || is_null($productId)) {
    $response['status'] = 'error';
    $response['message'] = 'Missing required fields.';
    echo json_encode($response);
    exit();
}

$conn->begin_transaction();

try {
    // Check if the brand exists, if not insert it
    $stmt = $conn->prepare("SELECT merk_id FROM MERK WHERE naam = ?");
    $stmt->bind_param("s", $merk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $insertMerkQuery = "INSERT INTO MERK (naam) VALUES (?)";
        $stmt = $conn->prepare($insertMerkQuery);
        $stmt->bind_param("s", $merk);
        $stmt->execute();
        $merkId = $stmt->insert_id;
    } else {
        $merkId = $result->fetch_assoc()['merk_id'];
    }

    // Check if the category exists, if not insert it
    $stmt = $conn->prepare("SELECT cat_id FROM CATEGORY WHERE naam = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $insertCategoryQuery = "INSERT INTO CATEGORY (naam) VALUES (?)";
        $stmt = $conn->prepare($insertCategoryQuery);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $categoryId = $stmt->insert_id;
    } else {
        $categoryId = $result->fetch_assoc()['cat_id'];
    }

    // Check if the description exists, if not insert it
    $stmt = $conn->prepare("SELECT besch_id FROM BESCHRIJVING WHERE naam = ?");
    $stmt->bind_param("s", $beschrijving);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $insertBeschrijvingQuery = "INSERT INTO BESCHRIJVING (naam) VALUES (?)";
        $stmt = $conn->prepare($insertBeschrijvingQuery);
        $stmt->bind_param("s", $beschrijving);
        $stmt->execute();
        $beschrijvingId = $stmt->insert_id;
    } else {
        $beschrijvingId = $result->fetch_assoc()['besch_id'];
    }

    // Check if the group exists
    $stmt = $conn->prepare("SELECT groep_id FROM GROEP WHERE naam = ? AND beschrijving_id_fk = ? AND merk_id_fk = ? AND category_id_fk = ?");
    $stmt->bind_param("siii", $productNaam, $beschrijvingId, $merkId, $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert new group if it doesn't exist
        $insertGroupQuery = "INSERT INTO GROEP (naam, beschrijving_id_fk, merk_id_fk, category_id_fk) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertGroupQuery);
        $stmt->bind_param("siii", $productNaam, $beschrijvingId, $merkId, $categoryId);
        $stmt->execute();
        $newGroupId = $stmt->insert_id;
    } else {
        // Use the existing group ID
        $newGroupId = $result->fetch_assoc()['groep_id'];
    }

    // Update product with the new group id
    $updateProductQuery = "UPDATE PRODUCT SET groep_id = ?, opmerkingen = ? WHERE product_id = ?";
    $stmt = $conn->prepare($updateProductQuery);
    $stmt->bind_param("isi", $newGroupId, $_POST['opmerkingen'], $productId);
    $stmt->execute();

    $conn->commit();

    $response['status'] = 'success';
    $response['message'] = 'Product updated successfully.';
    echo json_encode($response);
} catch (Exception $e) {
    $conn->rollback();
    $response['status'] = 'error';
    $response['message'] = 'An error occurred while updating the product: ' . $e->getMessage();
    echo json_encode($response);
}

$conn->close();
?>
