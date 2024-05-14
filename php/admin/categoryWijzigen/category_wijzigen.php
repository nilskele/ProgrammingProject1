<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="css/category_wijzigen.css">

<?php include("../admin.header.php");
      include("categorieën_ophalen.php");
?>


<div class="container">
    <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
    <h1 class="titel">Categorieën</h1>

    <div class="formContainer">
        <form action="">
            <div class="form-group">
                <label for="categoryName">Categorie naam selecteren:</label>
                <select type="text" class="form-control" id="categoryName" name="categoryName">
                    <?php echo $options; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nieuweNaam">Naam wijzigen:</label>
                <input type="text" class="form-control" id="nieuweNaam" name="nieuweNaam">
            </div>
            <button type="button" id="wijzigButton" class="btn btn-primary">Categorie wijzigen</button>
            <button type="button" id="verwijderButton" class="btn btn-primary">Categorie verwijderen</button>
        </form>
        <hr>
        <div class="nieuweCategoryPopUp">
            <form action="">
                <div class="form-group">
                    <label for="categoryName">Categorie naam:</label>
                    <input type="text" class="form-control" id="categoryNameInput" name="categoryName">
                </div>
                <button type="button" class="nieuweCategory btn btn-primary" id="toevoegenCategory">Nieuwe categorie toevoegen:</button>
        </div>
    </div>
</div>

<script src="js/category_wijzigen.js"></script>