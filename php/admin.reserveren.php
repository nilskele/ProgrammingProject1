<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/admin.css">
<link rel="stylesheet" href="../css/admin.reserveren.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php include("admin.header.php");?>

<div class="container">
    <div class="reserverenHeader">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        <h1 class="titel">Reserveren: <span id="productNrSpan"></span></h1>
    </div>

    <div class="Reserveren">
        <form action="reserveren.php" method="post" class="reserverenForm">
            <div class="form-group">
                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="periode" class="col-sm-2 col-form-label">Periode:</label>
                <input type="text" name="daterange" class="datumZoekbalk inputZoekbalk form-control" />
            </div>
            <div class="form-group">
                <label for="reden" class="col-sm-2 col-form-label">Reden:</label>
                <select class="form-control select" id="reden" name="reden">
                    <option value="Project">Project</option>
                    <option value="Eindproject">Eindproject</option>
                    <option value="School">School</option>
                    <option value="Vrije_tijd">Vrije tijd</option>
                    <option value="Andere">Andere</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hoeveel" class="col-sm-2 col-form-label">Hoeveel:</label>
                <input type="number" class="form-control" id="hoeveel" name="hoeveel" required>
                <p class="aantalAanwezig">Aantal aanwezig: <span id="aantalProductenAanwezig"></span></p>
            </div>
            <button type="submit" class="btn btn-primary">Reserveren</button>
        </form>
    </div>
</div>


<script src="../js/admin.reserveren.js"></script>