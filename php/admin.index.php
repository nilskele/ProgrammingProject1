<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/admin.css">
<link rel="stylesheet" href="../css/catalogus.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include your custom JavaScript file -->
<script src="../js/inandout.js"></script>
<style>
    /* Style the overlay */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    /* Style the popup */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
        z-index: 10000;
    }

    /* Style the close button */
    .close {
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
        
    }
    .acceptPopup{
      
        
        cursor: pointer;
        background-color: red;
        color: white;
        padding: 0.5em 2em 0.5em 2em;
        border-radius: 1em;
        text-decoration: none;
        border: 2px solid red;
    }
</style>


<?php include("admin.header.php");
include('../database.php');
?>
<div id="overlay" class="overlay"></div>

<!-- Popup -->
<div id="popup" class="popup"></div>


<div id="adminDashboard">
  <div id="container1">
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Product Nr.</h1>
        <input type="text" class="form-control grey-input" id="productNrInput" placeholder="product nr" />
      </div>
      <div class="knoppen">
        <a href="accepteren.php" class="accepterenBtn">
          accepteren
        </a>
        <a class="defectBtn" id="defectBtn">
          defect
        </a>
        <button class="reserverenBtn" id="reserverenButtonProduct">
          reserveren
        </button>

      </div>
    </div>
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Kit Nr.</h1>
        <input type="text" class="form-control" id="inputName3" placeholder="product nr" />
      </div>
      <div class="knoppen">
        <a href="accepteren.php" class="accepterenBtn">
          accepteren
        </a>
        <a href="defect.php" class="defectBtnAccepteren">
          defect
        </a>
        <a href="reserveren.php" class="reserverenBtn">
          reserveren
        </a>

      </div>
    </div>
  </div>
</div>
<div id="smallInOutDiv">
  <div id="title-kalender-In-Out">
    <h1>In and Out</h1>
    <input type="text" name="selectedDate" id="selectedDate" readonly />
  </div>
  <div class="inOutTitels">
    <h1>Vandaag Geleend</h1>
    <h1>Vandaag Terug</h1>
  </div>
  <div class="inOutTitels">
  <input type="text" id="zoekbalka" name="zoekbalk" placeholder="Zoek naar producten" class="inputZoekbalk3">

  <input type="text" id="zoekbalkb" name="zoekbalk" placeholder="Zoek naar producten" class="inputZoekbalk4">

  </div>

  <div class="inoutdiv">
    <div id="smallInOut1" class="productContainer overflow-auto">

    </div>
    <div id="smallInOut2" class="productContainer overflow-auto "></div>
  </div>
</div>





      <script src="../js/inandout.js"></script>

    </div>
    <div class="toTopAnker">
      <button onclick="topFunction()" id="topBtn">Top &#8593;</button>
    </div>
    <script src="../js/inandout.js"></script>
    <script src="../js/admin.index.js"></script>

   

    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="buttons_kalender">
    <form action="/zoeken" method="GET">
      <input type="text" name="Zoeken" placeholder="Zoeken...">
    </form>
    <div class="buttons-container">
      <a href="admin.kit_toevoegen.php"><button>Kit toevoegen</button></a>
      <a href="admin.product_toevoegen.php"><button>Product toevoegen</button></a>
    </div>
  </div>
  <h1 class="titel">Calendar</h1>
  <div class="calendar">
    <header>
      <h3></h3>
      <nav>
        <button id="prev"></button>
        <button id="next"></button>
      </nav>
    </header>
    <section>
      <ul class="days">
        <li>Items <span class="date"></span></li>
        <li>Zo <span class="date"></span></li>
        <li>Ma <span class="date"></span></li>
        <li>Di <span class="date"></span></li>
        <li>Wo <span class="date"></span></li>
        <li>Do <span class="date"></span></li>
        <li>Vr <span class="date"></span></li>
        <li class="new-row"><span class="date"></span></li> 
      </ul>
      <ul class="dates"></ul>
    </section>
  </div>
  <script src="script.js" defer></script>
</body>
</html>
<script src="../js/admin.agenda.js"></script>

<?php 

// Your database query here
$sql = "SELECT Uitleendatum, terugbrengDatum FROM `MIJN_LENINGEN` WHERE 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row as JSON
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "0 results";
}

$conn->close();
?>

