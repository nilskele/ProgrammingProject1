<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel="stylesheet" href="../mijnUitleningen/mijnUitleningen.css" />
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
  <?php 
  include('../php/header.php');
  include('defectMelden.php');
  ?>

  <div class="waarshcuwingenDiv">
    <p class="waarschuwingen">Aantal waarschuwingen: <span class="waarschuwingenCount"></span></p>
  </div>

  <div class='uitleningenTitle'>
    <div class="uitleningenTitle-col-1"><a href="javascript:history.back()" class="terugLink">&#8592 Terug</a></div>
    <div class="uitleningenTitle-col-2">
      <h1>Mijn uitleningen</h1>
      <div class="meldenPopUp" id="meldenPopUp">
        <div class="meldenPopUp-content">
          <span class="close" onclick="sluitMMeldenPopUp()">&times;</span>
          <h2>Defect melden</h2>
          <form id="defectMeldenForm" action="defectMelden.php" method="post">
            <label for="watDefect">Wat is er defect?</label>
            <input type="field" id="watDefect" name="watDefect" class="form-control" required> <br>
            <label for="defectReden">Reden Defect:</label>
            <input type="hidden" id="lening_id" name="lening_id" value="">
            <textarea name="redenDefect" id="redenDefect" cols="70" rows="4" class="form-control" required></textarea> <br>
            <input type="submit" value="Melden" class="btn btn-primary submitButton">
            <br>
          </form>
        </div>
      </div>
    </div>
    <div class="uitleningenTitle-col-3"></div>
  </div>
  <div class="table">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Uitleendatum</th>
          <th>Terugbrengdatum</th>
          <th>Defect</th>
          <th>Reservering</th>
        </tr>
        <thead>
        <tbody></tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="mandjeOphalen.js"></script>
</body>

</html>