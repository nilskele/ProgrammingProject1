<?php
include ('header.php');
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


</head>

<body>
  <div class="terug">
    <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
  </div>

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
                <div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no"
                    marginheight="0" marginwidth="0"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1059.2858829550748!2d4.321638326091922!3d50.84189487567301!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3c5c00a0304c5%3A0x8eb9da4b7a309a1c!2smedialab.brussel!5e0!3m2!1snl!2sbe!4v1716198361865!5m2!1snl!2sbe"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"><a href="https://www.gps.ie/">gps trackers</a></iframe>
                </div>
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
                Dinsdag: 09:30 - 12:00 12:30 - 17:00<br>
                Woensdag: 09:30 - 12:00 12:30 - 17:00<br>
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
            <form id="questionForm" action="https://formsubmit.co/samo971sa@gmail.com" method="POST">

              <div class="form-group">
                <label for="firstName">Voornaam</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
              </div>

              <div class="form-group">
                <label for="lastName">Achternaam</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
              </div>

              <div class="form-group">
                <label for="email">Mailadres</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="form-group">
                <label for="phone">Telefoonnummer</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
              </div>

              <div class="form-group">
                <label for="question">Vraag</label>
                <textarea class="form-control" id="question" name="question" required></textarea>
              </div>

              <!-- Verborgen invoerveld voor de volgende URL na succesvol verzenden -->
              <input type="hidden" name="_next" value="http://127.0.0.1/ProgrammingProject1/php/thanks.php">
              <button type="submit" class="btn custom-red-btn">Indienen</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6 ">
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

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>