$(document).ready(function() {
    let usertype = "3";
  
    let dateRangeOptions = {
      opens: "center",
      minDate: moment().toDate(),
      startDate: moment().toDate(),
      isInvalidDate: function(date) {
        if (date.day() === 6 || date.day() === 0) {
          return true;
        }
        return false;
      },
    };
  
    if (usertype == "3") {
      dateRangeOptions.maxDate = moment().add(3, "week").toDate();
    }
  
    $('input[name="daterange"]').daterangepicker(dateRangeOptions, function(start, end, label) {
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
        success: function(data) {
          console.log("Ontvangen data:", data);
        },
        error: function(xhr, status, error) {
          console.error("Error fetching data:", error);
        }
      });
    });
  });
  