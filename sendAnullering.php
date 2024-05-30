<?php

include ('database.php');
require ('vendor/autoload.php');
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;
use Dotenv\Dotenv;

session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$smtpUsername = $_ENV['SMTP_USERNAME'];
$smtpPassword = $_ENV['SMTP_PASSWORD'];

if (!$smtpUsername || !$smtpPassword) {
    error_log("SMTP-gegevens ontbreken");
    echo json_encode(array("success" => false, "error" => "SMTP-gegevens ontbreken in environment variables"));
    exit;
}

$itemId = $_POST['itemId'];
$lening_id = $_POST['lening_id'];

// Fetch user and loan details
$query = "SELECT email, GROEP.naam, Uitleendatum, terugbrengDatum
          FROM MIJN_LENINGEN
          JOIN USER ON MIJN_LENINGEN.user_id_fk = USER.user_id
          JOIN PRODUCT ON MIJN_LENINGEN.product_id_fk = PRODUCT.product_id
          JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
          WHERE lening_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $lening_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $Email = $row['email'];
    $groepNaam = $row['naam'];
    $startDatum = $row['Uitleendatum'];
    $eindDatum = $row['terugbrengDatum'];
    error_log("Groep: " . $groepNaam);

    $transport = (new EsmtpTransport('mail.smtp2go.com', 2525))
                    ->setUsername($smtpUsername)
                    ->setPassword($smtpPassword);

    $mailer = new Mailer($transport);

    $email = (new Email())
        ->from($smtpUsername)
        ->to($Email)
        ->subject('Annulering van je reservering')
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
                <p>Je reservering is geannuleerd.</p>
                <h2>Details:</h2>
                <ul>
                    <li><strong>Startdatum:</strong> $startDatum</li>
                    <li><strong>Einddatum:</strong> $eindDatum</li>
                    <li><strong>Product:</strong> $groepNaam</li>
                </ul>
                <p>Sorry voor dit ongemak.</p>
                <p>Met vriendelijke groet,<br>EHB</p>
                <a class='a_img' href='https://ibb.co/GQ4ptZj'><img class='ehb_img' src='https://i.ibb.co/hFJ9ZGv/Eh-B-logo-transparant.png' alt='Eh-B-logo-transparant' border='0'></a>
            </div>
        </body>
        </html>
        ");

    try {
        // Email versturen
        $mailer->send($email);
        error_log("Email sent");
        echo json_encode(array("success" => true));
    } catch (Exception $e) {
        error_log("Email not sent: " . $e->getMessage());
        echo json_encode(array("success" => false, "error" => "Fout bij het verzenden van de bevestigingsmail: " . $e->getMessage()));
    }
} else {
    error_log("Fout bij het uitvoeren van de query: " . $conn->error);
    echo json_encode(array("success" => false, "error" => "Fout bij het ophalen van de gebruikersgegevens"));
}

$conn->close();

?>
