<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoekbalk</title>
    <link rel="stylesheet" href="../zoekbalk/zoekbalkStyle.css" />

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>

<body>
    <div class="zoekbalkContainer">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        <form class="zoekbalkForm">
        <button class="buttonZoekbalk">
                <svg viewBox="0 0 1024 1024">
                    <path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path>
                </svg>
            </button>
            <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar producten" class="inputZoekbalk">
            <select name="categorie" id="categorie" class="categorieZoekbalk">
                <option value="" disabled selected>&#11167</option>
                <option value="audio">Audio</option>
                <option value="foto">Foto</option>
                <option value="media">Media</option>
                <option value="video">Video</option>
            </select>

            <p class="gevondenItems"><span id="#hoeveelheid gevonden items">( 3 )</span></p>
            <div class="vl"></div>
            <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" class="datumZoekbalk inputZoekbalk"/>
            <div class="vl"></div>
            <input type="checkbox" id="kit" name="kit" value="kit" class="inputZoekbalk">
            <label for="kit" class="kitLabel">Kit</label>
            <div class="vl"></div>
            <button id="changeLayout" class="buttonZoekbalk"><img class="imagelayoutwijzigen" src="../images/layoutChange.png"></button>
        </form>
    </div>
    <script src="../zoekbalk/zoekbalkScript.js"></script>
</body>