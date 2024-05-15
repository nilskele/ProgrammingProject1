let aantalBeschikbaarSpan = document.getElementById("aantalBeschikbaar");
let available = document.getElementById("available");
let group_id = localStorage.getItem("groep_id");
let usertype = localStorage.getItem("usertype");

$(document).ready(function() {
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
        url: "../php/datePickerReserveren.php",
        type: "GET",
        dataType: "json",
        data: {
          group_id: group_id,
          startDatum: startDatum,
          eindDatum: eindDatum,
        },
        success: function (data) {
          aantalBeschikbaarSpan.innerHTML = data[0].aantalBeschikbaar;
          let optionsHTML = "";
          for (let i = 1; i <= data[0].aantalBeschikbaar; i++) {
              optionsHTML += `<option value="${i}">${i}</option>`;
          }
          available.innerHTML = optionsHTML;
      },
      
        error: function (data) {
          alert("Er is een fout opgetreden bij het zoeken.(date)");
        },
      });
    }
  );
});