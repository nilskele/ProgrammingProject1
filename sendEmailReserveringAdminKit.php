<?php

include ('database.php');
require ('vendor/autoload.php'); 
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;

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
$KitNr = $_GET['KitNr'];
$Email = $_GET['email'];

// kitnaam ophalen
$query = "SELECT kit_naam
FROM KIT
WHERE kit_id = ?";
$stmt = $conn->prepare($query); 
$stmt->bind_param("s", $KitNr); 
$stmt->execute(); 
$result = $stmt->get_result(); 


if ($result) {
    $row = $result->fetch_assoc();
    $groepNaam = $row['naam']; 
    error_log("Groep: " . $groepNaam); 
} else {
    error_log("Fout bij het uitvoeren van de query: " . $conn->error);
}

// reden ophalen
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

// smtp transport instellen
$transport = (new Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport
('mail.smtp2go.com', 2525))
                ->setUsername($smtpUsername)
                ->setPassword($smtpPassword);

$mailer = new Mailer($transport);

// email opstellen voor kit
$email = (new Email())
    ->from($smtpUsername)
    ->to($Email)
    ->subject('Bevestiging van je reservering')
    ->html("
<!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Bevestiging van je reservering</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        p {
            color: #666;
        }

        .a_img {
            width: 30px;
        }
    </style>
    </head>
    <body>
        <div class='container'>
            <h1>Beste gebruiker,</h1>
            <p>Je reservering is succesvol gemaakt.</p>
            <h2>Details:</h2>
            <ul>
                <li><strong>Startdatum:</strong> $startDatum</li>
                <li><strong>Einddatum:</strong> $eindDatum</li>
                <li><strong>Reden:</strong> $reden</li>
                <li><strong>Aantal:</strong> $aantal</li>
                <li><strong>Kit:</strong> $KitNr</li>
            </ul>
            <p>Bedankt voor je reservering.</p>
            <p>Met vriendelijke groet,
            <br>EHB</p>
            <a class='a_img' href='https://ibb.co/GQ4ptZj'><img class='ehb_img' src='https://i.ibb.co/hFJ9ZGv/Eh-B-logo-transparant.png' alt='Eh-B-logo-transparant' border='0'></a>
        </div>
    </body>
    </html>
    ");


try {
    // email verzenden
    $mailer->send($email);
    error_log("Email sent");   
    echo json_encode(array("success" => true));
} catch (Exception $e) {
    error_log("Email not sent: " . $e->getMessage());
    echo json_encode(array("success" => false, "error" => "Reservering succesvol, maar fout bij het verzenden van de bevestigingsmail: " . $e->getMessage()));
}

?>
