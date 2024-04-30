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
  <?php include('../php/header.php');
  include('defectMelden.php');
  ?>

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
            <input type="field" id="watDefect" name="watDefect" required> <br>
            <label for="defectReden">Reden Defect:</label>
            <input type="hidden" id="lening_id" name="lening_id" value="">
            <textarea name="redenDefect" id="redenDefect" cols="30" rows="3" required></textarea> <br>
            <input type="submit" value="Melden" class="submitButton">
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

  <script src="mandjeOphalen.js"></script>
</body>

</html>