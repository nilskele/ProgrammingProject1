<?php

include ('database.php');
require ('vendor/autoload.php'); 
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/');
$dotenv->load();

$smtpUsername = $_ENV['SMTP_USERNAME'];
$smtpPassword = $_ENV['SMTP_PASSWORD'];


if (!$smtpUsername || !$smtpPassword) {
    error_log("SMTP-gegevens ontbreken");
    echo json_encode(array("success" => false, "error" => "SMTP-gegevens ontbreken in environment variables"));
    exit;
}

$reden = $_GET['reden'];
$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];
$aantal = $_GET['aantal'];
$groep_id = $_GET['groep_id'];

error_log("Reden: " . $reden);
error_log("Startdatum: " . $startDatum);
error_log("Einddatum: " . $eindDatum);
error_log("Aantal: " . $aantal);
error_log("Groep_id: " . $groep_id);


$query = "SELECT naam FROM GROEP WHERE groep_id = ?";
$stmt = $conn->prepare($query); 
$stmt->bind_param("s", $groep_id); 
$stmt->execute(); 
$result = $stmt->get_result(); 


if ($result) {
    $row = $result->fetch_assoc();
    $groepNaam = $row['naam']; 
    error_log("Groep: " . $groepNaam); 
} else {
    error_log("Fout bij het uitvoeren van de query: " . $conn->error);
}

$query2 = "SELECT naam
FROM REDEN
WHERE reden_id = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("s", $reden);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2) {
    $row2 = $result2->fetch_assoc();
    $reden = $row2['naam'];
    error_log("Reden: " . $reden);
} else {
    error_log("Fout bij het uitvoeren van de query: " . $conn->error);
}

$Email = $_SESSION['email'];


$transport = (new Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport
('mail.smtp2go.com', 2525))
                ->setUsername($smtpUsername)
                ->setPassword($smtpPassword);

$mailer = new Mailer($transport);

$email = (new Email())
    ->from($smtpUsername)
    ->to($Email)
    ->subject('Bevestiging van je reservering')
    ->text("
Beste gebruiker,

Je reservering is succesvol gemaakt.

Details:
Startdatum: $startDatum
Einddatum: $eindDatum
Reden: $reden
Aantal: $aantal
Product: $groepNaam

Bedankt voor je reservering.

Met vriendelijke groet, 
EHB
");

try {
    $mailer->send($email);
    error_log("Email sent");   
    echo json_encode(array("success" => true));
} catch (Exception $e) {
    error_log("Email not sent: " . $e->getMessage());
    echo json_encode(array("success" => false, "error" => "Reservering succesvol, maar fout bij het verzenden van de bevestigingsmail: " . $e->getMessage()));
}

?>
