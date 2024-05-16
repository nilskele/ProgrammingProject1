<?php
include('index.header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Info Page</title>
<!-- Bootstrap CSS -->

<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/info.css">

   <!-- External JavaScript -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<style></style>


</head>

<body>
 
<div class="container">

    <div class="row">

        <div class="col-lg-6">

            <div class="section">

                <h4 class="red-title">LOCATIE</h4>

                <hr class="red-line">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">CAMPUS KAAI, 1STE VERDIEPING </h5>

                        <div class="iframe-container">

                        <div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Nijverheidskaai%20170,%201070%20Anderlecht+(campus%20kaai)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/">gps trackers</a></iframe></div>

                        </div>

                        <!-- Map of the location -->
<br>
                        <p class="card-text1">Nijverheidskaai 170, 1070 Anderlecht</p>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="section">

                <h4 class="red-title">OPENINGSTIJDEN</h4>

                <hr class="red-line">

                <div class="card">

                    <div class="card-body opening-hours">

                        <p class="card-text">

                        Maandag: 12:30 - 17:00<br>

                        Dinsdag: 09:30 - 12:00  12:30 - 17:00<br>

                        Woensdag: 09:30 - 12:00   12:30 - 17:00<br>

                        Donderdag: 9:30 - 12:30<br>

                        Vrijdag: 9:03 - 12:30<br>

                        Zaterdag: Gesloten<br>

                        Zondag: Gesloten<br>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-6">

            <div class="section">

                <h4 class="red-title">CONTACT ONS</h4>

                <hr class="red-line">
            <div class="card" id="cardForm">

                <form >

                    <div class="form-group">

                        <label for="firstName">Voornaam</label>

                        <input type="text" class="form-control" id="firstName" name="firstName">

                    </div>

                    <div class="form-group">

                        <label for="lastName">Achternaam</label>

                        <input type="text" class="form-control" id="lastName" name="lastName">

                    </div>

                    <div class="form-group">

                        <label for="email"> Mailadres </label>

                        <input type="email" class="form-control" id="email" name="email">

                    </div>

                    <div class="form-group">

                        <label for="phone"> Telefoonnummer </label>

                        <input type="tel" class="form-control" id="phone" name="phone">

                    </div>

                    <div class="form-group">

                        <label for="question">Vraag</label>

                        <textarea class="form-control" id="question" name="question"></textarea>

                    </div>

                    <button type="submit" class="btn custom-red-btn">Indienen</button>

                </form>

            </div>
        

        </div>
    </div>

        <div class="col-lg-6 " >

            <div class="section">

                <h4 class="red-title">EMAIL</h4>

                <hr class="red-line">

                <div class="card" id="email1">

                    <div class="card-body">

                        <p>medialab@ehb.be</p>

                    </div>

                </div>

            </div>

            <div class="section">

                <h4 class="red-title">TEL</h4>

                <hr class="red-line">

                <div class="card" id="bel">

                    <div class="card-body">

                        <p>0496878920</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
 
<!-- Bootstrap JS -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
