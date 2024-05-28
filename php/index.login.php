<?php
session_start();

include '../database.php';
include '../ChromePhp.php';
include('validation_functions.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['inputEmail3']) && isset($_POST['inputPassword3'])) {
        $email = valideren($_POST['inputEmail3']);
        $plain_password = valideren($_POST['inputPassword3']);

        // check of de gebruiker bestaat
        $stmt = $conn->prepare("SELECT user_id, email, passwoord, userType_fk FROM USER WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // check of het wachtwoord klopt
            if (password_verify($plain_password, $row['passwoord'])) {
                // zet variabelen in de sessie
                $_SESSION['email'] = $row['email'];
                $_SESSION['isIngelogd'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_type'] = $row['userType_fk'];
                $response['status'] = 'success';
                $response['redirect'] = ($_SESSION['user_type'] == 1) ? 'admin/admin.index.php?Zoeken=&searchType=naam' : 'user/catalogus/catalogus.php';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalide email of wachtwoord';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalide email of wachtwoord';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Alle velden zijn verplicht';
    }
    echo json_encode($response);
    exit();
}
?>
