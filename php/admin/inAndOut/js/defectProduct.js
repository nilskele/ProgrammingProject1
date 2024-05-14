document.addEventListener("DOMContentLoaded", function() {
    let productNrSpan = document.getElementById("productNrSpan");
    let productNr = localStorage.getItem("productNr");
    let email = localStorage.getItem("email");

    let emailInput = document.getElementById("email");

    if (emailInput) {
        emailInput.value = email;
    }

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

        Swal.fire({
            title: 'Weet u zeker dat u dit wilt doen?',
            text: "Het product zal als defect worden gemeld.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, meld het defect!'
        }).then((result) => {
            if (result.isConfirmed) {
                meldDefect(formData);
            }
        });
    });

    // Functie om het defect te melden
    function meldDefect(formData) {
        fetch('../inAndOut/defectProductBackend.php', {
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
                    text: data,
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
    }

    // Event listener voor de knop "Uit catalogus halen"
    let removeFromCatalogBtn = document.getElementById("removeFromCatalogBtn");
    if (removeFromCatalogBtn) {
        removeFromCatalogBtn.addEventListener("click", function() {
            Swal.fire({
                title: 'Weet u zeker dat u dit wilt doen?',
                text: "Het product zal uit de catalogus worden gehaald.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ja, haal het uit de catalogus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let productNr = productNrInput.value;
                    let formData = new FormData();
                    formData.append('productNr', productNr);

                    fetch('../inAndOut/defectProduct.Catalogus.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        data = data.trim();
                        console.log(data);
                        if (data === "Product is uit de catalogus gehaald.") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Uit de catalogus gehaald!',
                                text: 'Het product is uit de catalogus gehaald.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Er is iets misgegaan',
                                text: data,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

                }
            });
        });
    }

    // Event listener voor de knop "Persoon waarschuwen"
    let blacklistPersonBtn = document.getElementById("blacklistPersonBtn");
    if (blacklistPersonBtn) {
        blacklistPersonBtn.addEventListener("click", function() {
            Swal.fire({
                title: 'Weet u zeker dat u dit wilt doen?',
                text: "De persoon zal worden gewaarschuwd.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ja, waarschuw de persoon!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let email = document.getElementById("email").value;
                    let formData = new FormData();
                    formData.append('email', email);

                    fetch('../inAndOut/defectProduct.Blacklist.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        data = data.trim();
                        console.log(data);
                        if (data === "Persoon is toegevoegd aan de blacklist.") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Persoon gewaarschuwd!',
                                text: 'De persoon is succesvol gewaarschuwd.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Er is iets misgegaan',
                                text: data,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
    }

    let accepterenBtn = document.getElementById("accepterenBtn");
    if (accepterenBtn) {
        accepterenBtn.addEventListener("click", function(event) {
            event.preventDefault();
    
            Swal.fire({
                title: "Weet je zeker dat je het product wilt accepteren?",
                text: "Dit product zal worden geaccepteerd",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ja, accepteren",
                cancelButtonText: "Annuleren"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/ProgrammingProject1/php/delete_row2.php',
                        method: 'POST',
                        data: { productNr: productNr },
                        success: function(response) {
                            if (response === 'success') {
                                console.log("checkcheck")
                                
                            } else {
                                console.error('Failed to delete row');
                                
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    }
});

