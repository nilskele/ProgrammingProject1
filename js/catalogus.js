$(document).ready(function () {
    $("#zoekForm").submit(function (e) {
      e.preventDefault();
  
      var zoekterm = $("#zoekbalk").val();
      if (zoekterm !== "") {
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
                resultHtml += "<strong>Groep naam:</strong> " + item.groep_naam + "<br>";
                resultHtml += "<strong>Merk naam:</strong> " + item.merk_naam + "<br>";
                resultHtml += "<strong>Opmerkingen:</strong> " + (item.opmerkingen || 'Geen opmerkingen') + "<br>";
                resultHtml += "<strong>Beschrijving:</strong> " + item.beschrijving_naam + "<br>";
                resultHtml += "<strong>Datum beschikbaar:</strong> " + item.datumBeschikbaar + "<br>";
                resultHtml += "-------------------------<br>";

                $(".groep_naam").text(item.groep_naam);
                $(".merk_naam").text(item.merk_naam);
                $(".datumBeschikbaar").text(item.datumBeschikbaar);
                $(".opmerkingItem").text(item.opmerkingen);
                $(".beschrijvingItem").text(item.beschrijving_naam);
              });
              $(".resultaten").html(resultHtml);
            }
          },
          error: function () {
            alert("Er is een fout opgetreden bij het zoeken.");
          },
        });
      }
    });
  });
  