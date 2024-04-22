$(document).ready(function () {
  let aantalResultaten = 0;
  $("#zoekForm").submit(function (e) {
    e.preventDefault();

    var zoekterm = $("#zoekbalk").val();
    if (true) {
      aantalResultaten = 0;
      $.ajax({
        url: "../php/zoek.php",
        type: "GET",
        data: {
          zoekbalk: zoekterm,
        },
        dataType: "json",
        success: function (data) {
          if (data.error) {
            $(".resultaten").html(data.error);
          } else {
            var resultHtml = "";
            $.each(data, function (index, item) {
              resultHtml +=
                "<strong>Groep naam:</strong> " + item.groep_naam + "<br>";
              resultHtml +=
                "<strong>Merk naam:</strong> " + item.merk_naam + "<br>";
              resultHtml +=
                "<strong>Opmerkingen:</strong> " +
                (item.opmerkingen || "Geen opmerkingen") +
                "<br>";
              resultHtml +=
                "<strong>Beschrijving:</strong> " +
                item.beschrijving_naam +
                "<br>";
              resultHtml +=
                "<strong>Datum beschikbaar:</strong> " +
                item.datumBeschikbaar +
                "<br>";
              resultHtml += "-------------------------<br>";
              aantalResultaten++;

              $(".groep_naam").text(item.groep_naam);
              $(".merk_naam").text(item.merk_naam);
              $(".datumBeschikbaar").text(item.datumBeschikbaar);
              $(".opmerkingItem").text(item.opmerkingen);
              $(".beschrijvingItem").text(item.beschrijving_naam);
            });
            $(".resultaten").html(resultHtml);
            $(".aantalResultaten").text(aantalResultaten);
          }
        },
        error: function () {
          alert("Er is een fout opgetreden bij het zoeken.");
        },
      });
    }
  });

  $("#categorie").change(function () {
    var selectedCategorie = $(this).val();
    aantalResultaten = 0;
    if (selectedCategorie !== "all") {
      $.ajax({
        url: "../php/filter_producten.php",
        type: "GET",
        data: {
          categorie: selectedCategorie,
        },
        dataType: "json",
        success: function (data) {
          if (data.error) {
            $(".resultaten").html(data.error);
          } else {
            var resultHtml = "";
            $.each(data, function (index, item) {
              resultHtml +=
                "<strong>Groep naam:</strong> " + item.groep_naam + "<br>";
              resultHtml +=
                "<strong>Merk naam:</strong> " + item.merk_naam + "<br>";
              resultHtml +=
                "<strong>Opmerkingen:</strong> " +
                (item.opmerkingen || "Geen opmerkingen") +
                "<br>";
              resultHtml +=
                "<strong>Beschrijving:</strong> " +
                item.beschrijving_naam +
                "<br>";
              resultHtml +=
                "<strong>Datum beschikbaar:</strong> " +
                item.datumBeschikbaar +
                "<br>";
              resultHtml += "-------------------------<br>";
              aantalResultaten++;

              $(".groep_naam").text(item.groep_naam);
              $(".merk_naam").text(item.merk_naam);
              $(".datumBeschikbaar").text(item.datumBeschikbaar);
              $(".opmerkingItem").text(item.opmerkingen);
              $(".beschrijvingItem").text(item.beschrijving_naam);
            });
            $(".resultaten").html(resultHtml);
            $(".aantalResultaten").text(aantalResultaten);
            console.log(aantalResultaten);
          }
        },
        error: function () {
          alert("Er is een fout opgetreden bij het filteren van de producten.");
        },
      });
    } else {
      $(".resultaten").empty();
    }
  });
});
