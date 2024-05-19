let aantalBeschikbaarSpan = document.getElementById("aantalBeschikbaar");
let available = document.getElementById("available");
let groep_id = localStorage.getItem("groep_id");
let isKit = localStorage.getItem("isKit");



$(document).ready(function() {

  fetch("../mijnUitleningen/waarschuwingenCount.php")
    .then((response) => response.json())
    .then((data) => {
      let waarschuwingenCountPhp = data;
      if (waarschuwingenCountPhp == 3) {
        Swal.fire({
          icon: "warning",
          title: "Waarschuwing",
          text: "Je hebt 2 waarschuwingen, je kan niet meer reserveren.",
          confirmButtonText: "Ok",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "catalogus.php";
          }
        });
      }
    })
    .catch((error) => console.error("Error fetching data:", error));


  $(".reserveren-btn").click(function() {
    let reden = $(".reden").val();
    let startDatum = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let eindDatum = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
    let aantal = $(".available").val();
    
    if (reden == 0) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je moet een reden invullen.",
        confirmButtonText: "Ok",
      });
      return;
    }

    if (usertype == 3 && moment(eindDatum).diff(startDatum, 'days') !== 4) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je kunt maximum 5 dagen selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    if (aantal == null) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je moet een aantal selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    Swal.fire({
      title: "Bevestiging",
      text: "Ben je zeker dat je deze reservering wilt maken?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ja",
      cancelButtonText: "Nee",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../php/reserveren_backend.php", 
          type: "GET",
          data: {
            reden: reden,
            startDatum: startDatum,
            eindDatum: eindDatum,
            aantal: aantal,
            groep_id: groep_id 
          },
          dataType: "json",
          success: function(response) {
            $.ajax({
              url: "../sendEmailReservering.php",
              type: "GET",
              data: {
                reden: reden,
                startDatum: startDatum,
                eindDatum: eindDatum,
                aantal: aantal,
                groep_id: groep_id 
              },
              dataType: "json",
              success: function(response) {
                console.log(response);
              },
              error: function() {
                console.log("Er is een fout opgetreden bij het sturen van de email.");
              }
            })

            if (response.success) {
              Swal.fire({
                icon: "success",
                title: "Reservering succesvol",
                text: "Je reservering is succesvol gemaakt.",
                confirmButtonText: "Ok",
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "catalogus.php";
                }
              });
            } else {
              console.log(response);
              Swal.fire({
                icon: "error",
                title: "Fout",
                text: "Er is een fout opgetreden bij het maken van de reservering. Probeer het later opnieuw.",
                confirmButtonText: "Ok",
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: "error",
              title: "Fout",
              text: "Er is een fout opgetreden bij het maken van de reservering. Probeer het later opnieuw.",
              confirmButtonText: "Ok",
            });
          }
        }); 
      }
    });
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
        url: "../php/datePickerReserveren.php",
        type: "GET",
        dataType: "json",
        data: {
          isKit: isKit,
          groep_id: groep_id,
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