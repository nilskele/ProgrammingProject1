<?php
include('../database.php');

if (isset($_POST['leningId'])) {
    $leningId = mysqli_real_escape_string($conn, $_POST['leningId']);

    $query = "UPDATE MIJN_LENINGEN SET Uitleendatum = NULL WHERE lening_id = '$leningId'";
    $query = "UPDATE MIJN_LENINGEN SET in_bezit = True WHERE lening_id = '$leningId'";
    
    if ($conn->query($query) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Lening ID not provided";
}

$conn->close();
?>