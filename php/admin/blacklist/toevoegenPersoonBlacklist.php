<?php
include("../../../database.php");

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $checkQuery = "SELECT * FROM USER WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkStmt->close();

    if ($checkResult->num_rows > 0) {
        $query = "UPDATE USER SET blacklist_fk = blacklist_fk + 1, blacklistDatum = DATE_ADD(NOW(), INTERVAL 3 MONTH) WHERE email = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();
            echo "geupdate";
        } else {
            echo "error2";
        }
    } else {
        echo "error: email not found";
    }

    $conn->close();
}
?>