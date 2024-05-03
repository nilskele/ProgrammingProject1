<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/blacklist.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<?php include("admin.header.php");
    include("admin.blacklist.backend.php")
?>

<div class="containerBlacklist">
    <div class="titelheader">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        <h1 class="titel">Blacklist</h1>
    </div>

    <div class="blacklistContainer">
        <div class="blacklistContainerHeader">
        <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar producten" class="inputZoekbalk1">
            <h3>Blacklists</h3>
        </div>
        <div class="blacklistLijst overflow-auto" id="lijst1">
        </div>
    </div>


    <div class="waarschuwingContainer">
        <div class="waarschuwingContainerHeader">
        <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar producten" class="inputZoekbalk2">
            <h3>Waarschuwingen</h3>
        </div>
        <div class="waarschuwingLijst overflow-auto" id="lijst2">

        </div>
    </div>
</div>

<script src="../js/blacklist.js"></script>