<?php
include('../../../database.php');

$sql = "SELECT naam FROM CATEGORY";
$result = $conn->query($sql);

$options = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['naam'] . "'>" . $row['naam'] . "</option>";
    }
}
?>