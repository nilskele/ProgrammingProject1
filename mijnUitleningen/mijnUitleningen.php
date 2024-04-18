<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel = "stylesheet" href = "../mijnUitleningen/mijnUitleningen.css" />
  <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
  <?php include('../php/header.php')?>
  
  <br>
  <br>
  <br>
  
  <div class='uitleningenTitle'>
    <h1>Mijn uitleningen</h1>
  </div>
  <div classe="recent">
    <p>Recente uitleningen: </p> 
  </div>
  <div class="table">
    <table>
      <tr>
        <th>Product</th>
        <th>Uitleendatum</th>
        <th>Terugbrengdatum</th>
        <th>Defect</th>
        <th>Reservering</th>
      </tr>
      <tr>
        <td>Canon M50</td>
        <td>16/05/2024</td>
        <td>16/06/2024</td>
        <td><button>Melden</button></td>
        <td><button id="nietInBezit" style="background-color: red; color: white;">Annuleren</button></td>
      </tr>
      <tr>
        <td>Canon EOS</td>
        <td>16/05/2024</td>
        <td>16/06/2024</td>
        <td><button>Melden</button></td>
        <td><button id="welInBezit" style="background-color: green; color: white;">Verlengen</button></td>
      </tr>
    </table>
  </div>

  <script src="mijnUitleningen.js"></script>
</body>
</html>