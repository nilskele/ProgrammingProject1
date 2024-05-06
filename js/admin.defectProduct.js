document.addEventListener("DOMContentLoaded", function() {
    let productNrSpan = document.getElementById("productNrSpan");
    let productNr = localStorage.getItem("productNr");

    if (productNrSpan) {
        productNrSpan.innerHTML = "&nbsp;" + productNr;
    } else {
        console.error('localstorage productNr niet aanwezig');
    }

    let defectForm = document.querySelector(".defectProductForm");
    let productNrInput = defectForm.querySelector("#productNr");

    productNrInput.value = productNr;

    defectForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(defectForm);

        fetch('../php/admin.defectProductBackend.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === "Defect succesvol gemeld.") {
                    Swal.fire({
                    icon: 'success',
                    title: 'Product defect gemeld',
                    text: 'Het product is succesvol gemeld als defect',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Er is iets misgegaan',
                    text: 'Het opgegeven e-mailadres bestaat niet.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }            
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Er is iets misgegaan',
                text: 'Er is iets misgegaan bij het melden van het defect',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });
});
