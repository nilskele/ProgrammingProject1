<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include ('../database.php');

// Ontvang formuliergegevens
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$passwoord = $_POST['passwoord']; // Let op de juiste naam van het wachtwoordveld

// Controleren op e-maildomein
if (substr($email, -15) !== '@student.ehb.be') {
    die("Je kunt je alleen registreren met een e-mail van de school (student.ehb.be)");
}

// Controleren op bestaande e-mail in de database
$stmt = $conn->prepare("SELECT * FROM USER WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Deze e-mail is al gekoppeld aan een account");
}

// Hash wachtwoord
$hashed_passwoord = password_hash($passwoord, PASSWORD_DEFAULT);

// UserType_fk voor studenten is 3
$userType_fk = 3;

// Gegevens invoegen in de database
$stmt = $conn->prepare("INSERT INTO USER (voornaam, achternaam, email, passwoord, userType_fk) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $voornaam, $achternaam, $email, $hashed_passwoord, $userType_fk);
if ($stmt->execute()) {
    // Account is succesvol aangemaakt, redirect to accountAanmaken.php with success parameter
    header("Location: accountAanmaken.php?success=true");
    exit();
} else {
    die("Error bij uitvoeren van de query: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>