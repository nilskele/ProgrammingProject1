<link rel="stylesheet" href="../css/admin.defectProduct.css" />

<?php include("admin.header.php");?>

<div class="container">
    <div class="defectHeader">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        <h1 class="titel">Defect product: <span id="productNrSpan"></span></h1>
    </div>

    <div class="DefectProduct">
        <form action="placeholder.php" method="post" class="defectProductForm">
            <div class="form-group">
                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="wat" class="col-sm-2 col-form-label">Wat is er defect:</label>
                <textarea class="form-control" id="wat" name="wat" cols="20" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="reden" class="col-sm-2 col-form-label">Reden:</label>
                <textarea class="form-control" id="reden" name="reden" cols="20" rows="3"></textarea>
            </div>
            <input type="hidden" id="productNr" name="productNr">

            <div class="allButtons">
                <button type="submit" class="btn btn-primary">Opslaan</button>
                <button type="button" id="removeFromCatalogBtn" class="btn btn-primary">Uit catalogus halen</button>
                <button type="button" id="blacklistPersonBtn" class="btn btn-primary">Persoon waarschuwen</button>

            </div>
        </form>
    </div>
</div>

<script src="../js/admin.defectProduct.js"></script>