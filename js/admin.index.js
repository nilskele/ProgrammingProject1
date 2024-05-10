let topBtn = document.getElementById("topBtn");

window.onscroll = function () {
    scrollFunction();
}

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        topBtn.style.display = "block";
    } else {
        topBtn.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


let reserverenButtonProduct = document.getElementById("reserverenButtonProduct");
let productNrInput = document.getElementById("productNrInput");

reserverenButtonProduct.addEventListener("click", function () {
        let productNr = productNrInput.value;
        
        if (productNr === "") {
                Swal.fire({
                        icon: "error",
                        title: "Oeps...",
                        text: "Het productnummer mag niet leeg zijn!"
                });
        } else {
                $.ajax({
                        url: "../checkProductNr.php",
                        method: "POST",
                        data: {
                                productNr: productNr
                        },
                        success: function (data) {
                                if (data === "true") {
                                        localStorage.setItem("productNr", productNr);
                                        window.location.href = "../reserveren.php";
                                } else {
                                        Swal.fire({
                                                icon: "error",
                                                title: "Oeps...",
                                                text: "Het productnummer bestaat niet!"
                                        });
                                }
                        }
                });
        }    
});

let defectBtn = document.getElementById("defectBtn");

defectBtn.addEventListener("click", function () {
        let productNr = productNrInput.value;
        
        if (productNr === "") {
                Swal.fire({
                        icon: "error",
                        title: "Oeps...",
                        text: "Het productnummer mag niet leeg zijn!"
                });
        } else {
                $.ajax({
                        url: "../checkProductNr.php",
                        method: "POST",
                        data: {
                                productNr: productNr
                        },
                        success: function (data) {
                                if (data === "true") {
                                        localStorage.setItem("productNr", productNr);
                                        window.location.href = "defectProduct.php";
                                } else {
                                        Swal.fire({
                                                icon: "error",
                                                title: "Oeps...",
                                                text: "Het productnummer bestaat niet!"
                                        });
                                }
                        }
                });
        }    
});

document.addEventListener("DOMContentLoaded", function() {
        $(document).on('click', '.defectBtn', function(event) {
            event.preventDefault();
            let itemText = document.getElementById('accepterenProductID').textContent;
            let itemValue = itemText.match(/\d+/);
            if (itemValue) {
                localStorage.setItem("productNr", itemValue[0]);
            } else {
                console.log("No numerical value found.");
            }
            window.location.href = "defectProduct.php";
        });
    });
    
    let acceptBtn= document.getElementById("acceptBtn");

acceptBtn.addEventListener("click", function () {
        let productNr = productNrInput.value;
        
        if (productNr === "") {
                Swal.fire({
                        icon: "error",
                        title: "Oeps...",
                        text: "Het productnummer mag niet leeg zijn!"
                });
        } else {
                $.ajax({
                        url: "../checkProductNr.php",
                        method: "POST",
                        data: {
                                productNr: productNr
                        },
                        success: function (data) {
                                if (data === "true") {
                                        Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You are about to perform an action. Do you want to proceed?",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, proceed!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '../php/delete_row2.php',
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
                                } else {
                                        Swal.fire({
                                                icon: "error",
                                                title: "Oeps...",
                                                text: "Het productnummer bestaat niet!"
                                        });
                                }
                        }
                });
        }    
});