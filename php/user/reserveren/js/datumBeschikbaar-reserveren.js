let aantalBeschikbaarSpan = document.getElementById("aantalBeschikbaar");
let available = document.getElementById("available");
let groep_id = localStorage.getItem("groep_id");
let isKit = localStorage.getItem("isKit");



$(document).ready(function() {

  // functie om de adtum die in de session is gestoken vanuit de catalogus tonen
  $(function() {
    if(sessionStorage.getItem('daterange') != null) {
      $('input[name="daterange"]').val(sessionStorage.getItem('daterange'));
    }

  })

  // direchht de beschikbaarheid check van de geslecteerde datum die vanuit de catalogus is opgehaald
  let daterangeVal = sessionStorage.getItem('daterange');
  if(daterangeVal != null) {
    let startDatum = daterangeVal.split(" - ")[0];
    let eindDatum = daterangeVal.split(" - ")[1];
  
    startDatum = moment(startDatum, "MM/DD/YYYY");
    eindDatum = moment(eindDatum, "MM/DD/YYYY");
    
    startDatum = startDatum.format("YYYY-MM-DD");
    eindDatum = eindDatum.format("YYYY-MM-DD");
    if (startDatum !== eindDatum) { 
      $.ajax({
        url: "datePickerReserveren.php",
        type: "GET",
        dataType: "json",
        data: {
          isKit: isKit,
          groep_id: groep_id,
          startDatum: startDatum,
          eindDatum: eindDatum,
        },
        success: function (data) { 
          
          // Check of er geen items beschikbaar zijn
          if (data == 0) {
            Swal.fire({
              icon: "warning",
              title: "Ongeldige selectie",
              text: "Er zijn geen items beschikbaar voor deze periode.",
              confirmButtonText: "Ok",
            });
            aantalBeschikbaarSpan.innerHTML = 0;
            let optionsHTML = "";
            available.innerHTML = optionsHTML;
            return;
          } 
    
          // aantal beschikbare items tonen
          if (data[0].aantalBeschikbaar == 0) {
            Swal.fire({
              icon: "warning",
              title: "Ongeldige selectie",
              text: "Er zijn geen items beschikbaar voor deze periode.",
              confirmButtonText: "Ok",
            });
            aantalBeschikbaarSpan.innerHTML = 0;
            let optionsHTML = "";
            available.innerHTML = optionsHTML;
            return;
          }
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
  }  

  // Check of de gebruiker 2 waarschuwingen heeft
  fetch("/ProgrammingProject1/php/user/mijnUitleningen/waarschuwingenCount.php")
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
            window.location.href = "/ProgrammingProject1/php/user/catalogus/catalogus.php";
          }
        });
      }
    })
    .catch((error) => console.error("Error fetching data:", error));

  // functie wanneer de reserveren knop wordt ingedrukt
  $(".reserveren-btn").click(function() {
    let reden = $(".reden").val();
    let startDatum = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let eindDatum = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
    let aantal = $(".available").val();
    
    // Check of de reden is ingevuld
    if (reden == 0) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je moet een reden invullen.",
        confirmButtonText: "Ok",
      });
      return;
    }

    // Check of de startdatum en einddatum zijn ingevuld
    if (usertype == 3 && moment(eindDatum).diff(startDatum, 'days') !== 4) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je kunt maximum 5 dagen selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    // Check of het aantal is ingevuld
    if (aantal == null) {
      Swal.fire({
        icon: "warning",
        title: "Ongeldige selectie",
        text: "Je moet een aantal selecteren.",
        confirmButtonText: "Ok",
      });
      return;
    }

    // reservering bevestigen
    Swal.fire({
      title: "Bevestiging",
      text: "Ben je zeker dat je deze reservering wilt maken?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ja",
      cancelButtonText: "Nee",
    }).then((result) => {
      if (result.isConfirmed) {

        // reservering maken
        $.ajax({
          url: "reserveren_backend.php", 
          type: "GET",
          data: {
            isKit: isKit,
            reden: reden,
            startDatum: startDatum,
            eindDatum: eindDatum,
            aantal: aantal,
            groep_id: groep_id 
          },
          dataType: "json",
          success: function(response) {

            // email sturen van reservering
            $.ajax({
              url: "../../../sendEmailReservering.php",
              type: "GET",
              data: {
                isKit: isKit,
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

            // reservering succesvol
            if (response.success) {
              Swal.fire({
                icon: "success",
                title: "Reservering succesvol",
                text: "Je reservering is succesvol gemaakt.",
                confirmButtonText: "Ok",
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "/ProgrammingProject1/php/user/catalogus/catalogus.php";
                }
              });
            } else {

              // reservering mislukt
              console.log(response);
              Swal.fire({
                icon: "error",
                title: "Fout",
                text: "Er is een fout opgetreden bij het maken van de reservering. Probeer het later opnieuw.",
                confirmButtonText: "Ok",
              });
            }
          },
          error: function(response) {
            console.log(response);
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
  
  
  // opties voor de datum range picker
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

  // functie voor zoeken op datum om het aantal beschikbare items te tonen
  $('input[name="daterange"]').daterangepicker(
    dateRangeOptions,
    function (start, end, label) {
      let startDatum = start.format("YYYY-MM-DD");
      let eindDatum = end.format("YYYY-MM-DD");

      // Check of de startdatum en einddatum correct zijn
      if (start.day() !== 1 || end.day() !== 5) {
        Swal.fire({
          icon: "warning",
          title: "Ongeldige selectie",
          text: "Je kunt alleen van maandag tot en met vrijdag selecteren.",
          confirmButtonText: "Ok",
        });
        return;
      }

      // Check of de gebruiker een student is en of de einddatum correct is
      if (usertype == "3" && end.diff(start, "days") !== 4) {
        Swal.fire({
          icon: "warning",
          title: "Ongeldige selectie",
          text: "Je kunt maximum 5 dagen selecteren.",
          confirmButtonText: "Ok",
        });
        return;
      }

      // aantal producten beschikbaar ophalen
      $.ajax({
        url: "datePickerReserveren.php",
        type: "GET",
        dataType: "json",
        data: {
          isKit: isKit,
          groep_id: groep_id,
          startDatum: startDatum,
          eindDatum: eindDatum,
        },
        success: function (data) { 
          console.log(data);
          
          // Check of er geen items beschikbaar zijn
          if (data == 0) {
            Swal.fire({
              icon: "warning",
              title: "Ongeldige selectie",
              text: "Er zijn geen items beschikbaar voor deze periode.",
              confirmButtonText: "Ok",
            });
            aantalBeschikbaarSpan.innerHTML = 0;
            let optionsHTML = "";
            available.innerHTML = optionsHTML;
            return;
          } 

          // aantal beschikbare items tonen
          if (data[0].aantalBeschikbaar == 0) {
            Swal.fire({
              icon: "warning",
              title: "Ongeldige selectie",
              text: "Er zijn geen items beschikbaar voor deze periode.",
              confirmButtonText: "Ok",
            });
            aantalBeschikbaarSpan.innerHTML = 0;
            let optionsHTML = "";
            available.innerHTML = optionsHTML;
            return;
          }
          aantalBeschikbaarSpan.innerHTML = data[0].aantalBeschikbaar;
          let optionsHTML = "";
          for (let i = 1; i <= data[0].aantalBeschikbaar; i++) {
              optionsHTML += `<option value="${i}">${i}</option>`;
          }
          available.innerHTML = optionsHTML;
      },
      
        error: function (data) {
          console.log(data);
          alert("Er is een fout opgetreden bij het zoeken.(date)");
        },
      });
    }
  );
});