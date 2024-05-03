<?php

include('../database.php');

if (isset($_POST['user_id'])) {

    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    $query = "UPDATE USER 
          SET blacklist_fk = CASE 
                                WHEN blacklist_fk = 2 THEN 1 
                                WHEN blacklist_fk = 3 THEN 2 
                              END 
          WHERE user_id = '$user_id'";


    if ($conn->query($query) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();

?>
