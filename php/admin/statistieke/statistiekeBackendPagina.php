<?php
include('../../../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$groupID = isset($_GET['groupID']) ? $_GET['groupID'] : '';

if ($groupID ) {
    // SQL query with filtering
    $sql = "SELECT 
    g.groep_id, 
    g.naam, 
    COUNT(ml.product_id_fk) AS reserve_count,
    COUNT(d.defect_id) AS defect_count,
    (
        SELECT r.naam 
        FROM MIJN_LENINGEN ml
        JOIN REDEN r ON ml.reden_id_fk = r.reden_id
        WHERE ml.product_id_fk = ml.product_id_fk
        GROUP BY r.naam
        ORDER BY COUNT(ml.reden_id_fk) DESC
        LIMIT 1
    ) AS most_common_reason
FROM GROEP g
JOIN PRODUCT p ON g.groep_id = p.groep_id
JOIN MIJN_LENINGEN ml ON p.product_id = ml.product_id_fk
LEFT JOIN DEFECT d ON ml.lening_id = d.lening_id_fk
WHERE g.groep_id = ?
GROUP BY g.groep_id, g.naam
ORDER BY reserve_count DESC";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $groupID);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // SQL query without filtering
    $sql = "SELECT 
    g.groep_id, 
    g.naam, 
    COUNT(ml.product_id_fk) AS reserve_count,
    COUNT(d.defect_id) AS defect_count,
    (
        SELECT r.naam 
        FROM MIJN_LENINGEN ml
        JOIN REDEN r ON ml.reden_id_fk = r.reden_id
        WHERE ml.product_id_fk = ml.product_id_fk
        GROUP BY r.naam
        ORDER BY COUNT(ml.reden_id_fk) DESC
        LIMIT 1
    ) AS most_common_reason
FROM GROEP g
JOIN PRODUCT p ON g.groep_id = p.groep_id
JOIN MIJN_LENINGEN ml ON p.product_id = ml.product_id_fk
LEFT JOIN DEFECT d ON ml.lening_id = d.lening_id_fk
WHERE g.groep_id = ?
GROUP BY g.groep_id, g.naam
ORDER BY reserve_count DESC";

$result = $conn->query($sql);
}

$rows = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
$conn->close();

echo json_encode($rows);
?> 
