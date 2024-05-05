<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/admin.css">
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
        <a href="defect.php" class="defectBtn">
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
        <a href="defect.php" class="defectBtn">
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
  <div class="inoutdiv">
    <div id="smallInOut1" class="productContainer overflow-auto">

    </div>
    <div id="smallInOut2" class="productContainer overflow-auto "></div>
  </div>
</div>


<!-- container voor kalender -->
<div class="container3">
  <div class="hoofd_kalender">
    <div class="titel_kalender">
      <h1>Catalogus</h1>

    </div>
  </div>
  <div class="buttons_kalender">
    <form action="/zoeken" method="GET">
      <input type="text" name="Zoeken" placeholder="Zoeken...">
    </form>
    <div class="buttons-container">
      <a href="admin.kit_toevoegen.php"><button>Kit toevoegen</button></a>
      <a href="admin.product_toevoegen.php"><button>Product toevoegen</button></a>
    </div>
  </div>

  <div class="calender">
    <div class="header_kalender">
      <button class="arrow_prev" onclick="aanpassenWeek(-1)"><img src="../images/black_arrow_l.png" alt="Previous"></button>
      <h2>WEEK DATUM HIER</h2>
      <button class="arrow_next" onclick="aanpassenWeek(1)"><img src="../images/black_arrow_r.png" alt="Next"></button>
    </div>
    <div class="container_kalender">



      <script src="../js/inandout.js"></script>

    </div>
    <div class="toTopAnker">
      <button onclick="topFunction()" id="topBtn">Top &#8593;</button>
    </div>
    <script src="../js/inandout.js"></script>
    <script src="../js/admin.index.js"></script>

    <?php

//sql naam van item verkrijgen
$query_naamItem = "SELECT naam FROM GROEP";
$result_naamItem = $conn->query($query_naamItem);

//zoekopdracht op basis van naam
$query_selectNaam = "SELECT * FROM `GROEP` WHERE naam = 'Ronin S'";
$result_selectNaam = $conn->query($query_selectNaam);



$year = isset($_GET['year']) ? $_GET['year'] : 2024;
$week = isset($_GET['week']) ? $_GET['week'] : 26;


// Calculate the start and end date of the week
$start_date = date("Y-m-d", strtotime($year."W".$week));
$end_date = date("Y-m-d", strtotime($year."W".$week."+6 days"));

//start datum en eind datum zonder jaar
$startDateMaand = date("d/m", strtotime($year."W".$week));
$endDateMaand = date("d/m", strtotime($year."W".$week."+6 days"));


// Start the table and center it
echo '<div style="text-align:center;">';
echo '<table border="1" style="table-layout: fixed; width: 80%; margin: 0 auto; border-collapse: collapse;">';

// Print header row for days of the week
echo '<tr>';
echo '<th style="width: 12%; border: 1px solid black;">'.$startDateMaand.' - '.$endDateMaand.'</th>';  // New column for product names
for ($day = strtotime($start_date); $day <= strtotime($end_date); $day = strtotime("+1 day", $day)) {
    echo '<td style="width: 12%; padding: 10px; border: 1px solid black;">'; // Add border to the cell
    echo date("D j/n", $day);
    echo '</td>';
}
echo '</tr>';

// Loop through each day of the week
for ($day = strtotime($start_date); $day <= strtotime($end_date); $day = strtotime("+1 day", $day)) {
    // Start a new row
    echo '<tr style="border: 1px solid black;">'; // Add border to the row

    // Print the product name in the first column
    echo '<td style="border: 1px solid black;">Product Name</td>';

    // Print the days of the week
    for ($i = 1; $i <= 7; $i++) {
        echo '<td style="width: 12%; padding: 10px; ">'; // Add border to the cell
        if (date("N", $day) == $i) {
            echo ''; // Here we will check if the product is borrowed until this day and adjust the color accordingly
            $day = strtotime("+1 day", $day);
        }
        echo '</td>';
    }

    echo '</tr>';


$query_lengteProduct = "SELECT COUNT(naam) FROM GROEP WHERE naam = 'RONIN S'";
$result_lengteproduct = $conn->query($query_lengteProduct);
    
    
$row = $result_lengteproduct->fetch_row();

$lengteproduct = $row[0];

$nu = 1;
    while($nu < $lengteproduct) {
        
        
        if ($result_selectNaam->num_rows > 0) {
          while($row_naamItem = $result_selectNaam->fetch_assoc()) {
            // Start a new row
            echo '<tr style="border: 1px solid black; height: 12%;">'; 
            // Print the product name in the first column
            echo '<td style="border: 1px solid black;">';
            echo $row_naamItem["naam"] . "<br>";
            echo '</td>';
          }
        } else {
          echo "Geen resultaten gevonden";
        }

        
        
        // Print the empty cells for the days of the week
        for ($i = 1; $i <= 7; $i++) {
            echo '<td></td>';
        }
        // End the row
        echo '</tr>';
        $nu = $nu +1;
    }
}

// End the table and the centered div
echo '</table>';
echo '</div>';
?>


<script> 
//functie aanmaken 
function aanpassenWeek(wissel){
  var currentYear = <?php echo $year; ?>;
    var currentWeek = <?php echo $week; ?>;
    
    // Calculate the new week
    var newWeek = currentWeek + wissel;
    var newYear = currentYear;

    if (newWeek > 52) {
      newWeek = 1;
      newYear++;
    } else if (newWeek < 1) {
      newWeek = 52;
      newYear--;
    }

    // Redirect to the new week
    window.location.href = "admin.index.php?year=" + newYear + "&week=" + newWeek; // Change "your_page.php" to your actual page
  }



</script>