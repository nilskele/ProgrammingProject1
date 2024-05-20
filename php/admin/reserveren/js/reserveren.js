let reserverenbtn = document.getElementById("reserverenbtn");
let usertype = 0;

let aantalProductenAanwezig = document.getElementById("aantalProductenAanwezig");
let hoeveel = document.getElementById("hoeveel");

$(function () {
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

    let dateRangeOptions = {
        opens: "center",
        minDate: moment().toDate(),
        startDate: moment().toDate(),
        isInvalidDate: function (date) {
            return date.day() === 6 || date.day() === 0;
        },
    };

    let product_id = localStorage.getItem("productNr");
    let aantalProductenAanwezig = document.getElementById("aantalProductenAanwezig");

    $('input[name="daterange"]').daterangepicker(
        dateRangeOptions,
        function(start, end) {
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
                url: "reserveren.backend_aantalBeschikbaar.php",
                type: "GET",
                dataType: "json",
                data: {
                    product_id: product_id,
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

$("#reserverenBtn").click(function() {
    let productNr = localStorage.getItem("productNr");
    let startDatum = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let eindDatum = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
    let reden = document.getElementById("reden").value;
    let aantal = document.getElementById("hoeveel").value;
    let email = document.getElementById("email").value;

    if (email === "") {
        Swal.fire({
            icon: "warning",
            title: "Ongeldige selectie",
            text: "Je moet een email invullen.",
            confirmButtonText: "Ok",
        });
        return;
    }

    if (reden === "0") {
        Swal.fire({
            icon: "warning",
            title: "Ongeldige selectie",
            text: "Je moet een reden invullen.",
            confirmButtonText: "Ok",
        });
        return;
    }

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
            $.ajax({
                url: "reserveren.backend.php",
                method: "GET",
                data: {
                    productNr: productNr,
                    startDatum: startDatum,
                    eindDatum: eindDatum,
                    reden: reden,
                    email: email,
                    aantal: aantal,
                },
                dataType: "json",
                success: function(response) {
                    $.ajax({
                        url: "../../../sendEmailReserveringAdmin.php",
                        method: "GET",
                        data: {
                            productNr: productNr,
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
