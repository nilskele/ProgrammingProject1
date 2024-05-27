<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.css">
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.kalender.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<!-- Include your custom JavaScript file -->
<style>
  .statusImage{
    width: 7em!important;
    margin-bottom:1em;
    
    
  }
</style>
<?php 
include("admin.header.php");
include('../../database.php');
?>




<div id="overlay" class="overlay"></div>

<!-- Popup -->
<div id="popup" class="popup"></div>


<div id="adminDashboard">
<a class="btn btn-primary aanmaken" href="../accountAanmaken.php">
  Account aanmaken
</a>
  <div id="container1">
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Product Nr.</h1>
        <input type="text" class="form-control grey-input" id="productNrInput" placeholder="product nr" />
      </div>
      <div class="knoppen">
        <a id="acceptBtn" class="accepterenBtn">
          accepteren
        </a>
        <a class="defectBtn" id="defectBtn">
          defect
        </a>
        <a>
          <button class="reserverenBtn" id="reserverenButtonProduct">
            reserveren
          </button>
        </a>
      </div>
    </div>
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Kit Nr.</h1>
        <input type="text" class="form-control" id="KitNrInput" placeholder="kit nr" />
      </div>
      <div class="knoppen">
        <a id="acceptBtnKit" class="accepterenBtnKit">
          accepteren
        </a>
        <a class="defectBtnAccepteren" id="defectBtnKit">
          defect
        </a>
        <a class="reserverenBtn" id="reserverenBtnKit">
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

<script src="../admin/inAndOut/js/inandout.js"></script>



</div>
<div class="toTopAnker">
  <button onclick="topFunction()" id="topBtn">Top &#8593;</button>
</div>

<script src="/ProgrammingProject1/js/admin.index.js"></script>


  
  <script src="catalogus/getData.php"></script> 
    <script src="catalogus/kalender.backend.js"></script> 

    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Admin Calendar</title>
</head>
<body>
  <div class="buttons_kalender">

  <form action="" method="GET" onsubmit="scrollToResults()">
  <div class="form_zoek">
    <div class="search-input-container">
      <label for="searchInput">Zoeken:</label>
      <input type="text" id="searchInput" name="Zoeken" placeholder="Zoeken...">
    </div>
    <div class="toggle-container">
      <span id="labelID" class="toggle-label active">ID</span>
      <label class="switch">
        <input type="checkbox" id="searchToggle" onclick="updateSearchType()">
        <span class="slider round"></span>
      </label>
      <span id="labelNaam" class="toggle-label">Naam</span>
    </div>
    <input type="hidden" id="searchType" name="searchType" value="naam">
    <button class="button_zoeken" type="submit">Zoek</button>
  </div>
</form>




    <div class="buttons-container">
      <a href="/ProgrammingProject1/php/admin/kitToevoegen/kit_toevoegen.php"><button>Kit toevoegen</button></a>
      <a href="/ProgrammingProject1/php/admin/productToevoegen/product_toevoegen.php"><button>Product toevoegen</button></a>
      <a href="/ProgrammingProject1/php/admin/categoryWijzigen/category_wijzigen.php"><button>Categorie wijzigen</button></a>
    </div>
  </div>
  <h1 class="titel">Calendar</h1>
  <div class="calendar" id="results">
    <header>
      <h3>Catalogus</h3>
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
        <li>Za <span class="date"></span></li>
      </ul>
      <ul class="dates"></ul>
    </section>
  </div>
  <?php 
    // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$loanDetails = array(); // Initialize the array

if (isset($_GET['Zoeken'])) {
  $zoekTerm = $_GET['Zoeken'];
  $searchType = $_GET['searchType'];

  // Sanitize the input to prevent XSS
  $zoekTerm = htmlspecialchars($zoekTerm);
  

  // Determine the SQL query based on the search type
  if ($searchType === 'id') {
      $sql = "SELECT p.product_id, g.naam AS product_name, p.zichtbaar, l.Uitleendatum, l.terugbrengDatum
              FROM PRODUCT p
              JOIN GROEP g ON p.groep_id = g.groep_id
              LEFT JOIN MIJN_LENINGEN l ON p.product_id = l.product_id_fk
              WHERE p.product_id LIKE ?";
  } else {
    $zoekTerm = "%" . $zoekTerm . "%";
      $sql = "SELECT p.product_id, g.naam AS product_name, p.zichtbaar, l.Uitleendatum, l.terugbrengDatum
              FROM PRODUCT p
              JOIN GROEP g ON p.groep_id = g.groep_id
              LEFT JOIN MIJN_LENINGEN l ON p.product_id = l.product_id_fk
              WHERE g.naam LIKE ?";
  }

  // Prepare the statement
  $stmt = $conn->prepare($sql);
  if ($stmt === false) {
      die("Prepare failed: " . $conn->error);
  }

  // Bind the parameter
  $stmt->bind_param("s", $zoekTerm);

  // Execute the statement
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Check if there are results
  if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
          // Store the results in an array
          $loanDetails[] = array(
              "product_id" => $row["product_id"],
              "product_name" => $row["product_name"],
              "Uitleendatum" => $row["Uitleendatum"],
              "terugbrengDatum" => $row["terugbrengDatum"],
              "zichtbaar" => $row["zichtbaar"]
          );
      }
  } else {
      echo "Geen resultaten gevonden";
  }

  // Close the statement
  $stmt->close();
} else {
  // Prepare the SQL query to retrieve all items
  $sql_all = "SELECT g.naam AS product_name, p.product_id, p.zichtbaar, l.Uitleendatum, l.terugbrengDatum
              FROM PRODUCT p
              JOIN GROEP g ON p.groep_id = g.groep_id
              LEFT JOIN MIJN_LENINGEN l ON p.product_id = l.product_id_fk";
  
  // Execute the query
  $result_all = $conn->query($sql_all);

  // Check if there are results
  if ($result_all->num_rows > 0) {
      // Output data of each row
      while ($row = $result_all->fetch_assoc()) {
          // Store the results in an array
          $loanDetails[] = array(
              "product_id" => $row["product_id"],
              "product_name" => $row["product_name"],
              "Uitleendatum" => $row["Uitleendatum"],
              "terugbrengDatum" => $row["terugbrengDatum"],
              "zichtbaar" => $row["zichtbaar"]
          );
      }
  } else {
      echo "Geen resultaten gevonden";
  }
}



// Close the connection
$conn->close();

// Convert loanDetails to JSON
$loanDetailsJSON = json_encode($loanDetails);
  ?>
   <script>
    function scrollToResults() {
      // Scroll to the results section after form submission
      setTimeout(function() {
        document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
      }, 100); 
    }

    window.addEventListener('DOMContentLoaded', (event) => {
      <?php if (isset($_GET['Zoeken'])): ?>
        scrollToResults();
      <?php endif; ?>
    });
  </script>
  <script>
    const loanDetails = <?php echo $loanDetailsJSON; ?>;
    //console.log(loanDetails);
  </script>
  <script src="agenda/js/admin.agenda.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="agenda/js/admin.agenda.search.js"></script>
</body>
</html>
