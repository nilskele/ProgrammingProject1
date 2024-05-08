$(function () {
  let aantalResultaten = 0;

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
          console.log("Ontvangen data:", data);

          let resultHtml = "";

          if (data.error) {
            $(".resultaten").html(data.error);
          } else {
            $.each(data, function (index, item) {
              resultHtml += `
                            <?php  include '../php/countAantalBeschikbaar.php' ?>
                            <div class="product">
                                <div class="container">
                                    <div class="card mb-3">
                                        <div class="row">
                                            <div class="col-md-4 img-container">
                                              <img src="data:image/jpeg;base64,${item.image_data}" class="img-fluid">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p class="merk">${
                                                      item.merk_naam
                                                    }></p>
                                                    <div class="card-title">
                                                        <h2>${
                                                          item.groep_naam
                                                        }</h2>
                                                        <p> Beschikbaar vanaf: ${
                                                          item.datumBeschikbaar
                                                        }</p>
                                                    </div>
                                                    <p class="card-text">
                                                        Beschrijving: ${
                                                          item.beschrijving_naam ||
                                                          "Geen beschrijving"
                                                        }
                                                        <br>
                                                        Opmerking: ${
                                                          item.opmerkingen ||
                                                          "Geen opmerkingen"
                                                        }
                                                    </p>
                                                </div>
                                                <div class="icon">
                                                    <h6 class="aantal">Aantal aanwezig: ${
                                                      item.aantal_beschikbare_producten
                                                    }</h6>
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

            $(".resultaten").html(resultHtml);
            $(".aantalResultaten").text(aantalResultaten);
          }
        },

        error: function (error) {
          console.log("Fout bij het ophalen van de data:", error);
        },
      });
    }
  );
});
