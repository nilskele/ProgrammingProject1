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
                  <img src="data:image/jpeg;base64,${item.image_data}" class="img-fluid">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <p class="merk">${item.merk_naam}></p>
                    <div class="card-title">
                      <h2>${item.groep_naam || item.kit_naam}</h2>
                      <p> Beschikbaar vanaf: ${item.datumBeschikbaar}</p>
                    </div>
                    <p class="card-text">
                      Beschrijving: ${
                        item.beschrijving_naam || "Geen beschrijving"
                      }
                      <br>
                      Opmerking: ${item.opmerkingen || "Geen opmerkingen"}
                    </p>
                  </div>
                  <div class="icon">
                    <h6 class="aantal">Aantal aanwezig: ${
                      item.aantal_beschikbare_producten
                    }</h6>
                    <select class="available">
                    ${(() => {
                      let optionsHtml = "";
                      for (
                        let i = 1;
                        i <= item.aantal_beschikbare_producten;
                        i++
                      ) {
                        optionsHtml += `<option value="${i}">${i}</option>`;
                      }
                      return optionsHtml;
                    })()}
                    </select>
                    <a class="btn btn-secondary reserveren-btn" href="reserveren.php" data-groep_id="${item.groep_id}">+<i class="fas fa-shopping-cart"></i></a>
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
  $(document).on('click', '.reserveren-btn', function (e) {
    e.preventDefault(); // Stop the default link behavior
    var groepID = $(this).data('groep_id');
    var baseUrl = $(this).attr('href');
    var newUrl = baseUrl + '?groep_id=' + groepID;
    // Redirect to the newly constructed URL
    window.location.href = newUrl;
  });

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
          resultatenDiv.innerHTML =
            "Er zijn geen producten gevonden met de zoekterm: " +
            zoekterm +
            ".";
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
    } else if (selectedCategorie === "All") {
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

  let dateRangeOptions = {
    opens: "center",
    minDate: moment().toDate(),
    startDate: moment().toDate(),
    isInvalidDate: function (date) {
      if (date.day() === 6 || date.day() === 0) {
        return true;
      }
      return false;
    },
  };

  if (usertype == "3") {
    dateRangeOptions.maxDate = moment().add(3, "week").toDate();
  }

  $('input[name="daterange"]').daterangepicker(
    dateRangeOptions,
    function (start, end, label) {
      let startDatum = start.format("YYYY-MM-DD");
      let eindDatum = end.format("YYYY-MM-DD");

      if (start.day() !== 1 || end.day() !== 5) {
        Swal.fire({
          icon: "warning",
          title: "Ongeldige selectie",
          text: "Je kunt alleen van maandag tot en met vrijdag selecteren.",
          confirmButtonText: "Ok",
        });
        return;
      }

      if (usertype == "3" && end.diff(start, "days") !== 4) {
        Swal.fire({
          icon: "warning",
          title: "Ongeldige selectie",
          text: "Je kunt maximum 5 dagen selecteren.",
          confirmButtonText: "Ok",
        });
        return;
      }

      $.ajax({
        url: "../php/datePicker.php",
        type: "GET",
        dataType: "json",
        data: {
          startDatum: startDatum,
          eindDatum: eindDatum,
        },
        success: function (data) {
          toonResultaten(data);
        },
        error: function () {
          alert("Er is een fout opgetreden bij het zoeken.(date)");
        },
      });
    }
  );

  $("#kit").change(function () {
    if ($(this).is(":checked")) {
      
      aantalResultaten = 0;
      $.ajax({
        url: "../php/filter_kits.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
          toonResultaten(data);
        },
        error: function () {
          alert("Er is een fout opgetreden bij het zoeken naar kits.");
        },
      });
    } else {
      // Als de checkbox niet is aangevinkt, voer dan een standaard AJAX-oproep uit om alle producten te tonen
      aantalResultaten = 0;
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
    }}
  );
});


let topBtn = document.getElementById("topBtn");

window.onscroll = function () {
  scrollFunction();
}

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    topBtn.style.display = "block";
  } else {
    topBtn.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
