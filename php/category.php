<?php
$sql = "SELECT cat_id, naam FROM CATEGORY ORDER BY naam";
$result = $conn->query($sql);

$options = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['naam'] . "'>" . $row['naam'] . "</option>";
    }
}

?>