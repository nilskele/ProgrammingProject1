<?php

include("../../../database.php");

$sql = "SELECT cat_id, naam FROM CATEGORY";
$result = $conn->query($sql);

$options = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['cat_id'] . "'>" . $row['naam'] . "</option>";
    }
}

?>