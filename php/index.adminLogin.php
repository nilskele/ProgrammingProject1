<?php
session_start();

include '../database.php';
include('validation_functions.php');

if (isset($_POST['inputEmail3']) && isset($_POST['inputPassword3'])) {
    $email = valideren($_POST['inputEmail3']);
    $plain_password = valideren($_POST['inputPassword3']);

    $stmt = $conn->prepare("SELECT * FROM USER WHERE email=? And userType_fk = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if(hash('sha256', $plain_password) === $row['passwoord']) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['isIngelogd'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['userType_fk'];
            header("Location: admin/admin.index.php");
            exit();
        } else {
            header("Location: index.php?error=Invalide email of wachtwoord");
            exit();
        }
    } else {
        header("Location: index.php?error=Invalide email of wachtwoord");
        exit();
    }
}
?>
