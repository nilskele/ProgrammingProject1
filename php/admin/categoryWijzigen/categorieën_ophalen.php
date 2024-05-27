<?php

include("../../../database.php");

// fetch van alle categorieën
$sql = "SELECT cat_id, naam FROM CATEGORY ORDER BY naam";
$result = $conn->query($sql);

$options = '';

// als er categorieën zijn, zet elke categorie in een option van de select
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['cat_id'] . "'>" . $row['naam'] . "</option>";
    }
}

?>