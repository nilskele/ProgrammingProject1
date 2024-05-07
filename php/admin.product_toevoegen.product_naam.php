<?php
include('../database.php');

function valideren($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['productName'])) {
    $productName = valideren($_POST['productName']);

    $sql = "SELECT DISTINCT naam FROM GROEP WHERE naam = ?"; // Using = for exact match
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $productName); // Bind the parameter directly without wildcards

    $stmt->execute();

    $result = $stmt->get_result();

    $suggestions = array();
    while($row = $result->fetch_assoc()) {
        $suggestions[] = $row['naam'];
    }

    echo json_encode($suggestions); // Return suggestions as JSON array
} else {
    echo 'Error: Product name not received.';
}

$conn->close();
?>
