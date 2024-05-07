<?php
include("../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['email'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $updateBlacklistQuery = "UPDATE USER SET blacklist_fk = blacklist_fk + 1, blacklistDatum = NOW() WHERE email = '$email'";
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

