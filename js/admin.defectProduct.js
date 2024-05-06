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
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
