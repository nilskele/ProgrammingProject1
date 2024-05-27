<?php
include ('header.php');
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reglement</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/reglement.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        <h1 class="titel">Regelemnt</h1>
        <div class="reglementContainer">
            <ol>
                <li class="bold">Reservatiebeleid</li>
                    <ul>
                    <li>Studenten</li>
                        <ul>
                            <li>Kunnen maximaal 2 weken vooraf items reserveren.</li>
                        </ul>
                    <li>Docenten</li>
                        <ul>
                            <li>Kunnen onbeperkt vooruit reserveren.</li>
                        </ul>
                    <li>Algemeen</li>
                        <ul>
                            <li>Items kunnen ook zonder voorafgaande reservatie worden uitgeleend, mits beschikbaarheid.</li>
                        </ul>
                    </ul>
                <li class="bold">Uitleentermijnen</li>
                    <ul>
                        <li>Studenten</li>
                            <ul>
                                <li>Standaard uitleentermijn van 1 week.</li>
                                <li>Eerder terugbrengen is toegestaan.</li>
                                <li>Verlengen met 1 week is mogelijk, mits het item beschikbaar is.</li>
                            </ul>
                        <li>Docenten</li>
                            <ul>
                                <li>Geen beperking op de uitleentermijn.</li>
                            </ul>
                        <li><span class="red">Strafmaatregelen bij overtredingen</span> </li>
                            <ul>
                                <li>Bij de tweede keer niet afhalen of te laat terugbrengen, wordt de gebruiker voor 3 maanden op de blacklist geplaatst.</li>
                            </ul>
                    </ul>
                <li class="bold">Afhalen en Terugbrengen</li>
                    <ul>
                        <li>Afhalen: Alleen op maandag mogelijk.</li>
                        <li>Terugbrengen: Alleen op vrijdag mogelijk.</li>
                    </ul>
            </ol>
        </div>
        
    </div>
</body>