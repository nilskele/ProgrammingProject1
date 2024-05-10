$(function () {
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
        }
    )
})




document.addEventListener("DOMContentLoaded", function() {
    let productNrSpan = document.getElementById("productNrSpan");
    let productNr = localStorage.getItem("productNr");

    if (productNrSpan) {
        productNrSpan.innerHTML = "&nbsp;" + productNr;
    } else {
        console.error('localstorage productNr niet aanwezig');
    }

    let aantalProductenAanwezig = document.getElementById("aantalProductenAanwezig");

    if (aantalProductenAanwezig) {
        $.ajax({
            url: "../php/admin/reserveren.backend.php",
            method: "POST",
            data: {
                productNr: productNr
            },
            success: function(response) {
                response = JSON.parse(response);
                if(response.error) {
                    console.error(response.error);
                } else {
                    aantalProductenAanwezig.innerHTML = response[0].aantal_beschikbare_producten;
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    } else {
        console.error('aantalProductenAanwezig niet aanwezig');
    }
});
