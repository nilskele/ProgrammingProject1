let resultatenDiv = document.querySelector(".resultaten");

$(document).ready(function () {
  let aantalResultaten = 0;

  function toonResultaten(data) {
      if (data.error) {
          resultatenDiv.innerHTML = data.error;
      } else {
          resultHtml = "";
          $.each(data, function (index, item) {
              resultHtml += `
              <div class="product2">
        <div class="container">
            <div class="card mb-3"> <!-- Voeg mb-3 toe voor margin-bottom -->
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
                                Beschrijving: ${item.beschrijving_naam}
                                <br>
                                Opmerking: ${item.opmerkingen}
                            </p>
                        </div>
                        <div class="icon">
                            <h6 class="aantal">Aantal aanwezig: 5</h6>
                            <select class="available">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
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
