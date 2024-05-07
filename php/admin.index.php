<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/admin.css">
<link rel="stylesheet" href="../css/admin.kalender.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<!-- Include your custom JavaScript file -->
<script src="../js/inandout.js"></script>



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
        <a id="acceptBtn" href="accepteren.php" class="accepterenBtn">
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
  <input type="text" id="zoekbalka" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk3">

  <input type="text" id="zoekbalkb" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk4">

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
</body>
<script src="../js/admin.agenda.js"></script>
<?php 

// SQL-query
$sql = "SELECT ML.Uitleendatum, ML.terugbrengDatum, G.naam AS product_naam
        FROM MIJN_LENINGEN ML
        JOIN PRODUCT P ON ML.product_id_fk = P.product_id
        JOIN GROEP G ON P.groep_id = G.groep_id
        WHERE G.naam = 'CANON M50'";

// Voer de query uit
$result = $conn->query($sql);

// Array om de resultaten op te slaan
$loanDetails = array();

// Controleer of er resultaten zijn
if ($result->num_rows > 0) {
    // Output gegevens van elke rij
    while($row = $result->fetch_assoc()) {
        // Sla de resultaten op in een array
        $loanDetails[] = array(
            "product_naam" => $row["product_naam"],
            "Uitleendatum" => $row["Uitleendatum"],
            "terugbrengDatum" => $row["terugbrengDatum"]
        );
    }
} else {
    echo "Geen resultaten gevonden";
}

// Sluit de verbinding
$conn->close();

// Output the array contents
echo "<pre>";
//print_r($loanDetails);
echo "</pre>";

// Convert loanDetails to JSON
$loanDetailsJSON = json_encode($loanDetails);


?>
<script>
    // Pass PHP array to JavaScript
    const loanDetails = <?php echo json_encode($loanDetails); ?>;
  </script>
  <script src="../js/admin.agenda.js"></script>
<script>
// Pass PHP array to JavaScript
const loanDetails = <?php echo $loanDetailsJSON; ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
