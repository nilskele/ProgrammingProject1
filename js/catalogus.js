$(document).ready(function () {
  let aantalResultaten = 0;

  function toonResultaten(data) {
      var resultHtml = "";
      if (data.error) {
          $(".resultaten").html(data.error);
      } else {
          $.each(data, function (index, item) {
              resultHtml +=
                  "<strong>Groep naam:</strong> " + item.groep_naam + "<br>" +
                  "<strong>Merk naam:</strong> " + item.merk_naam + "<br>" +
                  "<strong>Opmerkingen:</strong> " + (item.opmerkingen || "Geen opmerkingen") + "<br>" +
                  "<strong>Beschrijving:</strong> " + item.beschrijving_naam + "<br>" +
                  "<strong>Datum beschikbaar:</strong> " + item.datumBeschikbaar + "<br>" +
                  "-------------------------<br>";
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
  }

  $.ajax({
      url: '../php/zoek.php',
      type: 'GET',
      dataType: 'json',
      data: {
          zoekbalk: ''
      },
      success: toonResultaten,
      error: function () {
          alert('Er is een fout opgetreden bij het ophalen van de producten.(toonresultaten)'); 
      }
  });

  $("#zoekForm").submit(function (e) {
      e.preventDefault();

      var zoekterm = $("#zoekbalk").val().trim();
      if (zoekterm !== "") {
          aantalResultaten = 0;
          $.ajax({
              url: "../php/zoek.php",
              type: "GET",
              data: {
                  zoekbalk: zoekterm,
              },
              dataType: "json",
              success: toonResultaten,
              error: function () {
                  alert("Er is een fout opgetreden bij het zoeken.(zoekbalk)");
              },
          });
       }
  });

  $("#categorie").change(function () {
    var selectedCategorie = $(this).val();
    if (selectedCategorie !== "all") {
        aantalResultaten = 0;
        $.ajax({
            url: "../php/filter_producten.php",
            type: "GET",
            data: {
                categorie: selectedCategorie
            },
            dataType: "json",
            success: function (data) {
                toonResultaten(data);
            },
            error: function () {
                alert("Er is een fout opgetreden bij het zoeken.(categorie)");
            }
        });
    } else {
        $(".resultaten").empty();
    }
});

});
