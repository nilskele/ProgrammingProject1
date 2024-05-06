<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/blacklist.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<?php include("admin.header.php");
include("admin.blacklist.backend.php")
?>

<div class="containerBlacklist">
    <div class="titelheader">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        <h1 class="titel">Blacklist</h1>
        <button class="btn btn-primary waarschuwenBtn" onclick="OpenPersoonWaarschuwen()">
            Persoon waarschuwen
        </button>
        <div class="waarschuwenPersoonPopUP" id="waarschuwenPersoonPopUPDiv">
            <form action="admin.ToevoegenPersoonBlacklist.php" class="waarschuwenPersoonContainer" id="waarschuwenPersoonForm" method="POST">
                <h1>Persoon waarschuwen</h1>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" name="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary inloggen">Waarschuwen</button>
                <button type="button" class="btn btn-light" class="btn" onclick="ClosePersoonWaarschuwen()">Terug</button>
            </form>
        </div>
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