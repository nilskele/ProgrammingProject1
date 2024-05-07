<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/product_toevoegen.css">

<?php include("admin.header.php")?>
<?php include("admin.product_toevoegen.category.php")?>
<?php include("admin.product_toevoegen.product_naam.php")?>
<?php include("admin.product_toevoegen.merk.php")?>
<?php include("admin.product_toevoegen.beschrijving.php")?>

<br>
<br>
<form action="../add_product">
  <div class="container">
    <h1>Product Toevoegen</h1>
    <div class="product_toevoegen">
      <label for="productNaam">Product naam:</label>
      <input type="text" id="productName" name="productName">
      <br>
      <br>
      <label for="merk">Merk:</label>
      <input type="text" id="merk" name="merk">
      <br>
      <br>
      <label for="categorie">Categorie:</label>
      <select name="categorie" id="categorie" class="categorieZoekbalk">
        <option value="All" id="categoryOptions">Categorie</option>
        <?php echo $options; ?>
      </select>
      <br>
      <br>
      <label for="quantity">Quantity:</label>
      <input type="number" id="quantity" name="quantity" min="1" value="1">
      <br>
      <br>
      <label for="beschrijving">Beschrijving:</label>
      <input type="text" id="beschrijving" name="beschrijving">
      <br>
      <br>
      <label for="opmerkingen">Opmerkingen:</label>
      <input type="text" id="opmerkingen" name="opmerkingen">
      <br>
      <br>

      <!-- <label for="fotos">Upload foto's:</label>
      <input type="file" id="fotos" name="fotos" accept="image/*" multiple>
      <button type="submit">Submit</button>  -->
    </div>

    <button type="submit">Product toevoegen</button>
  </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/admin.product_toevoegen.category.js"></script>
<script src="../js/admin.product_toevoegen.merk.js"></script>
<script src="../js/admin.product_toevoegen.checkProductNaam.js"></script>
<script src="../js/admin.product_toevoegen.checkBeschrijving.js"></script>
