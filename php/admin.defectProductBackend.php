<?php
include("../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['email']) && isset($_POST['wat']) && isset($_POST['reden']) && isset($_POST['productNr'])) {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $watdefect = mysqli_real_escape_string($conn, $_POST['wat']);
        $redenDefect = mysqli_real_escape_string($conn, $_POST['reden']);
        $productNr = mysqli_real_escape_string($conn, $_POST['productNr']);

        $query = "INSERT INTO DEFECT (watdefect, redenDefect, lening_id_fk)
        SELECT
            '$watdefect' AS watdefect,
            '$redenDefect' AS redenDefect,
            ml.lening_id AS lening_id_fk
        FROM
            USER u
                INNER JOIN
            MIJN_LENINGEN ml ON u.user_id = ml.user_id_fk
        WHERE
            u.email = '$email'
          AND ml.product_id_fk = '$productNr'
        ORDER BY
            ml.lening_id DESC
        LIMIT 1";

        // Execute query and handle errors
        if ($conn->query($query) === TRUE) {
            echo "Defect succesvol gemeld.";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Niet alle vereiste velden zijn ingevuld.";
    }
}
?>
