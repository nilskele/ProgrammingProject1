<?php
include("../../../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['email'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // persoon waarschuwen die het product heeft geretourneerd en het product defect is
        $updateBlacklistQuery = "UPDATE USER SET blacklist_fk = blacklist_fk + 1, blacklistDatum = DATE_ADD(NOW(), INTERVAL 3 MONTH) WHERE email = '$email'";
        if ($conn->query($updateBlacklistQuery) === TRUE) {
            echo "Persoon is toegevoegd aan de blacklist.";
        } else {
            echo "Error: " . $updateBlacklistQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Geen e-mailadres ontvangen.";
    }
}
?>