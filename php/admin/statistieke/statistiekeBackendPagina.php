<?php
include('../../../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$groupID = isset($_GET['groupID']) ? $_GET['groupID'] : '';

// SQL query without filtering
$sql = "SELECT 
    g.groep_id, 
    g.naam, 
    COUNT(ml.product_id_fk) AS reserve_count,
    COUNT(d.defect_id) AS defect_count,
    (
        SELECT r.naam 
        FROM MIJN_LENINGEN ml2
        JOIN REDEN r ON ml2.reden_id_fk = r.reden_id
        JOIN PRODUCT p2 ON ml2.product_id_fk = p2.product_id
        WHERE p2.groep_id = g.groep_id
        GROUP BY r.naam
        ORDER BY COUNT(ml2.reden_id_fk) DESC
        LIMIT 1
    ) AS most_common_reason
FROM GROEP g
JOIN PRODUCT p ON g.groep_id = p.groep_id
JOIN MIJN_LENINGEN ml ON p.product_id = ml.product_id_fk
LEFT JOIN DEFECT d ON ml.lening_id = d.lening_id_fk";

if ($groupID ) {
    // SQL query with filtering
    $sql .= " WHERE g.groep_id = ?";
}

$sql .= " GROUP BY g.groep_id, g.naam
ORDER BY reserve_count DESC";

$stmt = $conn->prepare($sql);

if ($groupID ) {
    $stmt->bind_param('s', $groupID);
}

$stmt->execute();
$result = $stmt->get_result();

$rows = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
$conn->close();

echo json_encode($rows);
?>
