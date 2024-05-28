<?php


include('../../../database.php');

$query1 = "SELECT  DISTINCT d.*, p.product_id, g.*,u.voornaam, u.achternaam, u.email, i.image_data
           FROM DEFECT d
           INNER JOIN MIJN_LENINGEN l ON d.lening_id_fk = l.lening_id
           INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
           INNER JOIN USER u ON l.user_id_fk = u.user_id
           INNER JOIN GROEP g ON p.groep_id = g.groep_id
           INNER JOIN IMAGE i ON g.image_id_fk =  i.image_id
           ";

$result1 = $conn->query($query1);

// Check if the query executed successfully


// Initialize an empty array to store the results
$rows = array();
while ($row = $result1->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

$conn->close();
?>
