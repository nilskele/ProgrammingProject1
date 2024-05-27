<?php

include('../../../database.php');

if (isset($_POST['user_id'])) {

    // user_id ophalen
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // query om de blacklist_fk en blacklistDatum aan te passen afahankelijk van de huidige blacklist_fk
    $query = "UPDATE USER 
        SET blacklist_fk = CASE 
                            WHEN blacklist_fk = 2 THEN 1 
                            WHEN blacklist_fk = 3 THEN 2 
                            END,
            blacklistDatum = CASE 
                                WHEN blacklist_fk = 2 THEN NOW()
                                ELSE blacklistDatum 
                            END
        WHERE user_id = '$user_id'";



    if ($conn->query($query) === TRUE) {
        echo "success";
    } else {
        echo "error3";
    }
} else {
    echo "erro4r";
}

$conn->close();

?>