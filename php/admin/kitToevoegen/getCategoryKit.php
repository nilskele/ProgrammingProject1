<?php

include("../../../database.php");

// fetch van alle categorieën
$sql = "SELECT cat_id, naam FROM CATEGORY ORDER BY naam";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = array("cat_id" => $row["cat_id"], "naam" => $row["naam"]);
    }
    echo json_encode($categories);
} else {
    echo json_encode(array("error" => "No categories found"));
}

?>