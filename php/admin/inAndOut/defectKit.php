<link rel="stylesheet" href="css/accepterenKit.css" />

<?php 
include("../admin.header.php");
?>

<div class="container">
    <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
    <div class="accepterenKitContainer">
        <div class="titelContainer">
            <div class="inforPersoonDiv">
                <p><strong> Geleend door: </strong> <span id="naamPersoon"></span></p>
                <p><strong> Email: </strong> <span id="emailPersoon"></span></p>
            </div>
            <div class="naamKit">
                <h1 class="naamKKitTitel"><span id="naamKit"></span>,</h1>
                <h1 class="idKitTitel"><span id="idKit"></span></h1>
            </div>
        </div>
        <div class="accepterenContainer">
            <div class="productenLijst" id="productenLijstDiv">
            </div>
        </div>
    </div> 
</div>

<script src="js/defectkit.js"></script>