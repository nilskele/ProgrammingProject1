<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include ('../database.php');

// Ontvang formuliergegevens
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$passwoord = $_POST['passwoord']; // Let op de juiste naam van het wachtwoordveld
$userType_fk = $_POST['userType'];

// Controleren op e-maildomein
if (!preg_match('/@student\.ehb\.be$/', $email) && !preg_match('/@ehb\.be$/', $email)) {
    die("Je kunt je alleen registreren met een e-mail van de school (student.ehb.be of ehb.be)");
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

// Gegevens invoegen in de database
$stmt = $conn->prepare("INSERT INTO USER (voornaam, achternaam, email, passwoord, userType_fk) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $voornaam, $achternaam, $email, $hashed_passwoord, $userType_fk);
if ($stmt->execute()) {
    // Account is succesvol aangemaakt, redirect to accountAanmaken.php with success parameter
    header("Location: index.accountAanmaken.php?success=true");
    exit();
} else {
    die("Error bij uitvoeren van de query: " . $stmt->error);
};

$stmt->close();
$conn->close();
?>
