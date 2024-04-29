<?php
session_start();

include '../database.php';

function valideren($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['inputEmail3']) && isset($_POST['inputPassword3'])) {
    $email = valideren($_POST['inputEmail3']);
    $passwoord = valideren($_POST['inputPassword3']);

    $sql = "SELECT * FROM USER WHERE email='$email' AND passwoord='$passwoord' AND userType_fk = 1";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if($row['email'] === $email && $row['passwoord'] === $passwoord) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['voornaam'] = $row['voornaam'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_type'] = $row['userType_fk'];
                header("Location: admin.index.php");
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
