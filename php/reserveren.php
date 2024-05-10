<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserveren</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/reserveren.css">
  <title>Reserveren</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/reserveren.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <style>
    /* Added custom CSS */
    .main-container {
      padding-left: 50px;
      /* Increased left padding */
      padding-right: 50px;
      /* Increased right padding */
    }

    .card {
      border-color: transparent;
      /* Removed border color */
    }

    .card-body {
      padding: 20px 40px;
      /* Added padding (20px top and bottom, 40px left) */
    }
    .card-text{
      text-decoration: underline;
     color: grey;
    }
    .num {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .input-group {
      display: flex;
      align-items: center; 
    }

    .aantal {
      margin-right: 10px; 
      padding-left: 0px;
      color: gray;
    }

    .custom-input {
      width: 100px;
    }

    .maxAantal {
      margin-top: 5px; 
    }
  </style>
  <style>
    /* Added custom CSS */
    .main-container {
      padding-left: 50px;
      /* Increased left padding */
      padding-right: 50px;
      /* Increased right padding */
    }

    .card {
      border-color: transparent;
      /* Removed border color */
    }

    .card-body {
      padding: 20px 40px;
      /* Added padding (20px top and bottom, 40px left) */
    }
    .card-text{
      text-decoration: underline;
     color: grey;
    }
    .num {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .input-group {
      display: flex;
      align-items: center; 
    }

    .aantal {
      margin-right: 10px; 
      padding-left: 0px;
      color: gray;
    }

    .custom-input {
      width: 100px;
    }

    .maxAantal {
      margin-top: 5px; 
    }
  </style>
  <style>
    /* Added custom CSS */
    .main-container {
      padding-left: 50px;
      /* Increased left padding */
      padding-right: 50px;
      /* Increased right padding */
    }

    .card {
      border-color: transparent;
      /* Removed border color */
    }

    .card-body {
      padding: 20px 40px;
      /* Added padding (20px top and bottom, 40px left) */
    }
    .card-text{
      text-decoration: underline;
     color: grey;
    }
    .num {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .input-group {
      display: flex;
      align-items: center; 
    }

    .aantal {
      margin-right: 10px; 
      padding-left: 0px;
      color: gray;
    }

    .custom-input {
      width: 100px;
    }

    .maxAantal {
      margin-top: 5px; 
    }
  </style>
</head>

<body>
<?php
    // Include PHP files
    include("filter_productReserveren.php");
    include("zoek.php");
    include("header.php"); // Assuming header.php contains the header content
  ?>

<div id="container">
  <?php include ('header.php'); ?>
  <section class="up row mb-5">
    <div class="col-md-1">
<?php
include("filter_productReserveren.php");

?>
<div id="container">
  <?php include ('header.php'); ?>
  <section class="up row mb-5">
    <div class="col-md-1">
      <a href="javascript:history.back()" class="terug">&#8592 Terug</a>
    </div>
    <div class="col-md-11">
      <h1 id="title" class="text-center">Reserveren</h1>
    </div>
  </section>
    </div>
    <div class="col-md-11">
      <h1 id="title" class="text-center">Reserveren</h1>
    </div>
  </section>
    </div>
    <div class="col-md-11">
      <h1 id="title" class="text-center">Reserveren</h1>
    </div>
  </section>

  <div class="container main-container">
    <div class="card">
      <div class="row">
        <div class="col-md-4">
          <img src="data:image/jpg;base64,<?php echo($product['image_data']); ?>" class="card-img-top img-fluid" alt="Main Image">
  <div class="container main-container">
    <div class="card">
      <div class="row">
        <div class="col-md-4">
          <img src="data:image/jpg;base64,<?php echo($product['image_data']); ?>" class="card-img-top img-fluid" alt="Main Image">
  <div class="container main-container">
    <div class="card">
      <div class="row">
        <div class="col-md-4">
          <img src="data:image/jpg;base64,<?php echo($product['image_data']); ?>" class="card-img-top img-fluid" alt="Main Image">
          <div class="small-img-group">
            <div class="small-img-col">
              <img src="../images/small1.jpeg" class="small-img img-fluid" alt="Small Image 1">
              <img src="../images/small1.jpeg" class="small-img img-fluid" alt="Small Image 1">
              <img src="../images/small1.jpeg" class="small-img img-fluid" alt="Small Image 1">
            </div>
            <div class="small-img-col">
              <img src="../images/small2.jpeg" class="small-img img-fluid" alt="Small Image 2">
              <img src="../images/small2.jpeg" class="small-img img-fluid" alt="Small Image 2">
              <img src="../images/small2.jpeg" class="small-img img-fluid" alt="Small Image 2">
            </div>
            <div class="small-img-col">
              <img src="../images/small3.jpeg" class="small-img img-fluid" alt="Small Image 3">
              <img src="../images/small3.jpeg" class="small-img img-fluid" alt="Small Image 3">
              <img src="../images/small3.jpeg" class="small-img img-fluid" alt="Small Image 3">
            </div>
            <div class="small-img-col">
              <img src="../images/small4.jpeg" class="small-img img-fluid" alt="Small Image 4">
              <img src="../images/small4.jpeg" class="small-img img-fluid" alt="Small Image 4">
              <img src="../images/small4.jpeg" class="small-img img-fluid" alt="Small Image 4">
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h3 class="card-title"><?php echo htmlspecialchars($product['groep_naam']); ?></h3>
            <p class="card-text"><?php echo htmlspecialchars($product['merk_naam']); ?>></p>
        <div class="col-md-8">
          <div class="card-body">
            <h3 class="card-title"><?php echo htmlspecialchars($product['groep_naam']); ?></h3>
            <p class="card-text"><?php echo htmlspecialchars($product['merk_naam']); ?>></p>

            <select class="reden form-control mb-2">
              <option>Reden</option>
              <option>Project</option>
              <option>Eindproject</option>
              <option>School</option>
              <option>Vrije tijd</option>
              <option>Andere</option>
            </select>
            <!-- Available date display -->
            <div class="beschikbaar">
              <h6>Beschikbaar vanaf: <?php echo htmlspecialchars($product['datumBeschikbaar']); ?></h6>
            </div>
            <!-- Date range input for reservation -->
            <div id="calendarContainer">
              <input type="text" name="daterange" class="datumZoekbalk inputZoekbalk"/>
            </div>

            <!-- Quantity selection -->
            <div class="num mb-2">
  <div class="input-group">
    <p class="aantal">Aantal:</p>
    <select class="custom-input available">
      <?php
       // Create options dynamically based on available quantity
      for ($i = 1; $i <= $product['aantal_beschikbare_producten']; $i++) {
        echo '<option value="' . $i . '">' . $i . '</option>';
      }
      ?>
    </select>
  </div>
  <h5 class="maxAantal">Max aantal: <?php echo htmlspecialchars($product['aantal_beschikbare_producten']); ?></h5>
</div>
        <div class="col-md-8">
          <div class="card-body">
            <h3 class="card-title"><?php echo htmlspecialchars($product['groep_naam']); ?></h3>
            <p class="card-text"><?php echo htmlspecialchars($product['merk_naam']); ?>></p>

            <select class="reden form-control mb-2">
              <option>Reden</option>
              <option>Project</option>
              <option>Eindproject</option>
              <option>School</option>
              <option>Vrije tijd</option>
              <option>Andere</option>
            </select>
            <div class="beschikbaar">
              <h6>Beschikbaar vanaf: <?php echo htmlspecialchars($product['datumBeschikbaar']); ?></h6>
            </div>
            <div id="calendarContainer">
              <input type="text" name="daterange" class="datumZoekbalk inputZoekbalk"/>
            </div>
            <div class="num mb-2">
              <div class="input-group">
                <p class="aantal">Aantal:</p>
                <input type="number" value="1" class="custom-input">
              </div>
              <h5 class="maxAantal">Max aantal:4</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
      </div>
    </div>
  </div>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  //Datum
$(document).ready(function() {
  let usertype = "3";

  let dateRangeOptions = {
    opens: "center",
    minDate: moment().toDate(),
    startDate: moment().toDate(),
    isInvalidDate: function(date) {
      if (date.day() === 6 || date.day() === 0) {
        return true;
      }
      return false;
    },
  };

  if (usertype == "3") {
    dateRangeOptions.maxDate = moment().add(3, "week").toDate();
  }

  $('input[name="daterange"]').daterangepicker(dateRangeOptions, function(start, end, label) {
    let startDatum = start.format("YYYY-MM-DD");
    let eindDatum = end.format("YYYY-MM-DD");

    if (start.day() !== 1 || end.day() !== 5) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je kunt alleen van maandag tot en met vrijdag selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    if (usertype == "3" && end.diff(start, "days") !== 4) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je kunt maximum 5 dagen selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    $.ajax({
      url: "../php/datePicker.php",
      type: "GET",
      dataType: "json",
      data: {
        startDatum: startDatum,
        eindDatum: eindDatum,
      },
      success: function(data) {
        console.log("Ontvangen data:", data);
       
      },
      error: function(xhr, status, error) {
        console.error("Error fetching data:", error);
      }
    });
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  //Datum
$(document).ready(function() {
  let usertype = "3";

  let dateRangeOptions = {
    opens: "center",
    minDate: moment().toDate(),
    startDate: moment().toDate(),
    isInvalidDate: function(date) {
      if (date.day() === 6 || date.day() === 0) {
        return true;
      }
      return false;
    },
  };

  if (usertype == "3") {
    dateRangeOptions.maxDate = moment().add(3, "week").toDate();
  }

  $('input[name="daterange"]').daterangepicker(dateRangeOptions, function(start, end, label) {
    let startDatum = start.format("YYYY-MM-DD");
    let eindDatum = end.format("YYYY-MM-DD");

    if (start.day() !== 1 || end.day() !== 5) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je kunt alleen van maandag tot en met vrijdag selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    if (usertype == "3" && end.diff(start, "days") !== 4) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je kunt maximum 5 dagen selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    $.ajax({
      url: "../php/datePicker.php",
      type: "GET",
      dataType: "json",
      data: {
        startDatum: startDatum,
        eindDatum: eindDatum,
      },
      success: function(data) {
        console.log("Ontvangen data:", data);
       
      },
      error: function(xhr, status, error) {
        console.error("Error fetching data:", error);
      }
    });
  });
});
</script>
</body>
</html>