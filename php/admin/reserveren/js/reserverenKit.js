let reserverenbtn = document.getElementById("reserverenbtn");
let usertype = 0;

let aantalProductenAanwezig = document.getElementById("aantalProductenAanwezig");
let hoeveel = document.getElementById("hoeveel");

$(function () {
    // AJAX-oproep om het usertype op te halen
    $.ajax({
        url: "/ProgrammingProject1/php/getUser_id.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            usertype = data.user_id;
        },
        error: function() {
            alert("Er is een fout opgetreden bij het zoeken.");
        },
    });

    // opties voor de datepicker
    let dateRangeOptions = {
        opens: "center",
        minDate: moment().toDate(),
        startDate: moment().toDate(),
        isInvalidDate: function (date) {
            return date.day() === 6 || date.day() === 0;
        },
    };

    let KitNr = localStorage.getItem("KitNr");   
    let kitNrspan = document.getElementById("kitNrspan");
    kitNrspan.innerHTML = KitNr; 
    let aantalProductenAanwezig = document.getElementById("aantalProductenAanwezig");

    // functie voor zoeken op datum om het aantal beschikbare items te tonen
    $('input[name="daterange"]').daterangepicker(
        dateRangeOptions,
        function(start, end) {
            let startDatum = start.format("YYYY-MM-DD");
            let eindDatum = end.format("YYYY-MM-DD");

            // controle of de start en einddatum op een maandag en vrijdag vallen
            if (start.day() !== 1 || end.day() !== 5) {
                Swal.fire({
                    icon: "warning",
                    title: "Ongeldige selectie",
                    text: "Je kunt alleen van maandag tot en met vrijdag selecteren.",
                    confirmButtonText: "Ok",
                });
                return;
            }

            // controle of de einddatum correct is voor studenten
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
                url: "reserveren.backend_aantalBeschikbaarKit.php",
                type: "GET",
                dataType: "json",
                data: {
                    KitNr: KitNr,
                    startDatum: startDatum,
                    eindDatum: eindDatum,
                },
                success: function (data) {
                    if (data.error) {
                        Swal.fire({
                            icon: "error",
                            title: "Fout",
                            text: data.error,
                            confirmButtonText: "Ok",
                        });
                    } else {
                        // aantal producten beschikbaar tonen in de select
                        aantalProductenAanwezig.innerHTML = data[0].aantalBeschikbaar;
                        let optionsHTML = "";
                        for (let i = 1; i <= data[0].aantalBeschikbaar; i++) {
                            optionsHTML += `<option value="${i}">${i}</option>`;
                        }
                        hoeveel.innerHTML = optionsHTML;
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Fout",
                        text: "Er is een fout opgetreden bij het zoeken.(date)",
                        confirmButtonText: "Ok",
                    });
                    console.error(xhr);
                }
            });
        }
    );
});

// Event listener voor het reserveren van een kit
$("#reserverenBtn").click(function() {
    let KitNr = localStorage.getItem("KitNr");
    let startDatum = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let eindDatum = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
    let reden = document.getElementById("reden").value;
    let aantal = document.getElementById("hoeveel").value;
    let email = document.getElementById("email").value;

    // controle of email inegevuld is
    if (email === "") {
        Swal.fire({
            icon: "warning",
            title: "Ongeldige selectie",
            text: "Je moet een email invullen.",
            confirmButtonText: "Ok",
        });
        return;
    }

    // controle of reden ingevuld is
    if (reden === "0") {
        Swal.fire({
            icon: "warning",
            title: "Ongeldige selectie",
            text: "Je moet een reden invullen.",
            confirmButtonText: "Ok",
        });
        return;
    }

    // controle of aantal ingevuld is
    if (aantal === "0") {
        Swal.fire({
            icon: "warning",
            title: "Ongeldige selectie",
            text: "Je moet een aantal invullen.",
            confirmButtonText: "Ok",
        });
        return;
    }

    Swal.fire({
        icon: "info",
        title: "Bevestiging",
        text: "Wil je deze reservatie bevestigen?",
        showCancelButton: true,
        confirmButtonText: "Ja",
        cancelButtonText: "Nee",
    }).then((result) => {
        if (result.isConfirmed) {
            // reservering maken
            $.ajax({
                url: "reserveren.backendKit.php",
                method: "GET",
                data: {
                    KitNr: KitNr,
                    startDatum: startDatum,
                    eindDatum: eindDatum,
                    reden: reden,
                    email: email,
                    aantal: aantal,
                },
                dataType: "json",
                success: function(response) {
                    // email sturen van reservering naar student
                    $.ajax({
                        url: "../../../sendEmailReserveringAdminKit.php",
                        method: "GET",
                        data: {
                            KitNr: KitNr,
                            startDatum: startDatum,
                            eindDatum: eindDatum,
                            reden: reden,
                            email: email,
                            aantal: aantal,
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                        },
                        error: function() {
                            console.log("Er is een fout opgetreden bij het sturen van de email.");
                        }
                    })


                    if(response.error) {
                        Swal.fire({
                            icon: "error",
                            title: "Reserveren mislukt",
                            text: response.error,
                            confirmButtonText: "Ok",
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Reserveren gelukt",
                            text: "Je reservatie is succesvol opgeslagen.",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Fout",
                        text: "Er is een fout opgetreden bij het reserveren.",
                        confirmButtonText: "Ok",
                    });
                    console.error("Error details:", xhr.responseText);
                }
            }); 
        }
    });
});
