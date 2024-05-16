<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserveren</title>
  <!-- External CSS -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/reserveren.css">
  <!-- External JavaScript -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
<?php
    // Include PHP files
    include("filter_productReserveren.php");
    include("header.php"); // Assuming header.php contains the header content
?>
<div id="container">
  <section class="up row mb-5">
    <div class="col-md-1">
      <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
    </div>
    <div>
      <h1 id="title" class="text-center">Reserveren</h1>
    </div>
  </section>
  <div class="container main-container">
    <div class="card">
      <div class="row">
        <div class="col-md-4">
          <!-- Image -->
          <img src="data:image/jpg;base64,<?php echo($product['image_data']); ?>" class="card-img-top img-fluid" alt="Main Image">
        </div>
        <div class="col-md-8">
          <!-- Product details -->
          <div class="card-body">
            <p class="card-text"><?php echo htmlspecialchars($product['merk_naam']); ?></p>
            <h3 class="card-title"><?php echo htmlspecialchars($product['groep_naam']); ?></h3>
            <!-- Reden selection -->
            <select class="reden form-control mb-2">
              <option value="0" >Reden</option>
              <option value="1">Project</option>
              <option value="2" >Eindproject</option>
              <option value="3" >School</option>
              <option value="4" >Vrije tijd</option>
              <option value="5" >Andere</option>
            </select>
            <!-- Beschikbaar display -->
            <div class="beschikbaar">
              <h6>Beschikbaar vanaf: <?php echo htmlspecialchars($product['datumBeschikbaar']); ?></h6>
            </div>
            <!-- Date range input -->
            <div id="calendarContainer">
              <input type="text" name="daterange" class="datumZoekbalk inputZoekbalk"/>
            </div>
            <div class="num mb-2">
              <div class="input-group">
                <p class="aantal">Aantal:</p>
                <select class="custom-input available form-control" style="max-width: 80px;" id="available">
                  <?php
                   // Create options dynamically based on available quantity
                  for ($i = 1; $i <= $product['aantal_beschikbare_producten']; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                  }
                  ?>
                </select>
              </div>
              <h5 class="maxAantal">Aantal beschikbaar: <span id="aantalBeschikbaar"><?php echo htmlspecialchars($product['aantal_beschikbare_producten']); ?></span> </h5>
            </div>
          </div>
        </div>
      </div>
      <!-- Quantity selection, action buttons, and script -->
      <div class="row">
        <div class="col-md-12">
          <div class="card-body text-center">
            <!-- Quantity selection and available count -->
            
            <!-- Action buttons section -->
            <div class="container-fluid">
              <div class="row justify-content-center mt-3">
                <div class="col-md-12 text-center mb-2">
                  <button class="reserveren-btn btn btn-primary btn-block">Nu reserveren</button>
                </div>
                <div class="col-md-12 text-center">
                  <a class="verder btn btn-secondary btn-block" href="catalogus.php"> Verder zoeken </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Script for date range picker -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/datumBeschikbaar-reserveren.js"></script>
</body>
</html>
