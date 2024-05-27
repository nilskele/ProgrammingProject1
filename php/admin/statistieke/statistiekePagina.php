<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sta</title>
    <link rel="stylesheet" href="/ProgrammingProject1/php/admin/statistieke/statistiekePagina.css">
    <li<link rel="stylesheet" href="css/styles.css">

</head>
<body>
<?php 
include("../admin.header.php");
?>

<div class="container">
        <a href="javascript:history.back()" class="terugLink" >&#8592 Terug</a>

    <div class="statistiek">
        <h1>Statistiek</h1>
    </div>
    
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Zoek met group id..." oninput="filterProducts()">
    </div>
    <div class="table-container">
        <table id="productTable">
            <tr>
                <th>Groep_id</th>
                <th>Product naam</th>
                <th>Aantal keer gereserveerd</th>
                <th>Aantal defecten gemeld</th>
            </tr>
            <!-- Rijen worden hier dynamisch toegevoegd met js -->
        </table>
    </div>
</div>
<script src="/ProgrammingProject1/php/admin/statistieke/statistiekePagina.js"></script>
</body>
</html>
