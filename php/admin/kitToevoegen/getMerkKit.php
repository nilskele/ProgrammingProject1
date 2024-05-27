<?php

include('../../../database.php');

// fetch van alle merken
$sql = "SELECT merk_id, naam FROM MERK ORDER BY naam";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $merken = array();
    while ($row = $result->fetch_assoc()) {
        $merken[] = array("merk_id" => $row["merk_id"], "naam" => $row["naam"]);
    }
    echo json_encode($merken);
} else {
    echo json_encode(array("error" => "No merken found"));
}