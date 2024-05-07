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

    $sql = "SELECT DISTINCT naam FROM GROEP WHERE naam LIKE ?"; // Modified SQL query to use LIKE for partial matches
    
    $stmt = $conn->prepare($sql);

    $productNameParam = "%$productName%"; // Add wildcards to search for partial matches
    $stmt->bind_param('s', $productNameParam);

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
