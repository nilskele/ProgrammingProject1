<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/inandout.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<?php 
include("admin.header.php");
include('../database.php');
?>
<div class="terug">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        
</div>

<div class="inAndOut">

    <h1>Te laat ingebracht. </h1>
    <div class="searchbar">
        <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar producten" class="inputZoekbalk5">
    </div>
    <div id="InOut3" class="inOutCatalagus overflow-auto">
    </div>
</div>

<script src="../js/telaat.js"></script>