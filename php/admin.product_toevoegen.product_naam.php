<?php
include('../database.php');

include('validation_functions.php');

if(isset($_POST['productName'])) {
    $productName = valideren($_POST['productName']);

    $sql = "SELECT DISTINCT groep_id FROM GROEP WHERE naam = ?"; // Using = for exact match
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $productName);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(array('groep_id' => $row['groep_id'])); // Product exists, return ID
    } else {
        echo json_encode(array('exists' => false)); // Brand does not exist
    }
}

$conn->close();
?>