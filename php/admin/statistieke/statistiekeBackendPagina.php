<?php
include('../../../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$groupID = isset($_GET['groupID']) ? $_GET['groupID'] : '';

if ($groupID) {
    // SQL query met filtering
    $sql = "SELECT 
    GROEP.groep_id, naam, COUNT(MIJN_LENINGEN.product_id_fk) AS reserve_count,
    COUNT(DEFECT.defect_id) AS defect_count
    FROM GROEP
    JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
    JOIN MIJN_LENINGEN ON PRODUCT.product_id = MIJN_LENINGEN.product_id_fk
    LEFT JOIN DEFECT ON MIJN_LENINGEN.lening_id = DEFECT.lening_id_fk
    WHERE GROEP.groep_id = ?
    GROUP BY GROEP.groep_id, naam
    ORDER BY reserve_count DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $groupID);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // SQL query zonder filtering
    $sql = "SELECT 
    GROEP.groep_id, naam, COUNT(MIJN_LENINGEN.product_id_fk) AS reserve_count,
    COUNT(DEFECT.defect_id) AS defect_count
    FROM GROEP
    JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
    JOIN MIJN_LENINGEN ON PRODUCT.product_id = MIJN_LENINGEN.product_id_fk
    LEFT JOIN DEFECT ON MIJN_LENINGEN.lening_id = DEFECT.lening_id_fk
    GROUP BY GROEP.groep_id, naam
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
