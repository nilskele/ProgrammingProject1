<link rel="stylesheet" href="css/reserverenKit.css">

<?php include("../admin.header.php");?>

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
                <option value="0" >Reden</option>
                <option value="1">Project</option>
                <option value="2" >Eindproject</option>
                <option value="3" >School</option>
                <option value="4" >Vrije tijd</option>
                <option value="5" >Andere</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hoeveel" class="col-sm-2 col-form-label">Hoeveel:</label>
                <select class="form-control" id="hoeveel" name="hoeveel" required></select> <br>
                <p class="aantalAanwezig">Aantal aanwezig: <span id="aantalProductenAanwezig"></span></p>
            </div>
            <button type="button" class="btn btn-primary" id="reserverenBtn">Reserveren</button>
        </form>
    </div>
</div>


<script src="js/reserverenKit.js"></script>