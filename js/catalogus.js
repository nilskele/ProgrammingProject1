$(document).ready(function () {
  let resultatenDiv = document.querySelector(".resultaten");
  let aantalResultaten = 0;

  function toonResultaten(data) {
    if (data.error) {
      resultatenDiv.innerHTML = data.error;
      return;
    }

    let resultHtml = "";
    aantalResultaten = 0; 

    $.each(data, function (index, item) {
      resultHtml += `
        <div class="product">
          <div class="container">
            <div class="card mb-3">
              <div class="row">
                <div class="col-md-4 img-container">
                  <img src="../images/img1.jpg" class="img-fluid">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <p class="merk">${item.merk_naam}></p>
                    <div class="card-title">
                      <h2>${item.groep_naam}</h2>
                      <p> Beschikbaar vanaf: ${item.datumBeschikbaar}</p>
                    </div>
                    <p class="card-text">
                      Beschrijving: ${item.beschrijving_naam || "Geen beschrijving"}
                      <br>
                      Opmerking: ${item.opmerkingen || "Geen opmerkingen"}
                    </p>
                  </div>
                  <div class="icon">
                    <h6 class="aantal">Aantal aanwezig: ${item.aantal_beschikbare_producten}</h6>
                    <select class="available">
                    ${(() => {
                      let optionsHtml = "";
                      for (let i = 1; i <= item.aantal_beschikbare_producten; i++) {
                        optionsHtml += `<option value="${i}">${i}</option>`;
                      }
                      return optionsHtml;
                    })()}
                    </select>
                    <a class="btn btn-secondary" href="reserveren.php">+<i class="fas fa-shopping-cart"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;

      aantalResultaten++;
    });

    resultatenDiv.innerHTML = resultHtml;
    $(".aantalResultaten").text(aantalResultaten);
  }

  $.ajax({
    url: "../php/zoek.php",
    type: "GET",
    dataType: "json",
    data: {
      zoekbalk: "",
    },
    success: toonResultaten,
    error: function () {
      alert("Er is een fout opgetreden bij het ophalen van de producten.");
    },
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
          aantalResultaten = 0;
          $(".aantalResultaten").text(aantalResultaten);
          resultatenDiv.innerHTML = "Er zijn geen producten gevonden met de zoekterm: " + zoekterm + ".";

        },
      });
    }
  });

  $("#zoekbalk").keydown(function (e) {
    if (e.keyCode === 13) { 
      var zoekterm = $("#zoekbalk").val().trim();
      if (zoekterm === "") {
        aantalResultaten = 0;
        $.ajax({
          url: "../php/zoek.php",
          type: "GET",
          dataType: "json",
          data: {
            zoekbalk: "",
          },
          dataType: "json",
          success: function (data) {
            toonResultaten(data);
          },
          error: function () {
            alert("Er is een fout opgetreden bij het zoeken.(zoekbalk)");
          },
        });
      }
    }
  });

  $("#categorie").change(function () {
    var selectedCategorie = $(this).val();
    if (selectedCategorie !== "All") {
      aantalResultaten = 0;
      $.ajax({
        url: "../php/filter_producten.php",
        type: "GET",
        data: {
          categorie: selectedCategorie,
        },
        dataType: "json",
        success: function (data) {
          toonResultaten(data);
        },
        error: function () {
          alert("Er is een fout opgetreden bij het zoeken.(categorie1)");
        },
      });
    } else if (selectedCategorie === "All"){
      aantalResultaten = 0;
      $.ajax({
        url: "../php/filter_producten_category_all.php",
        type: "GET",
        data: {
          categorie: "All",
        },
        dataType: "json",
        success: function (data) {
          toonResultaten(data);
        },
        error: function () {
          alert("Er is een fout opgetreden bij het zoeken.(categorie2)");
        },
      });
      
    }
  });
});
