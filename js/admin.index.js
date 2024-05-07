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
                        url: "checkProductNr.php",
                        method: "POST",
                        data: {
                                productNr: productNr
                        },
                        success: function (data) {
                                if (data === "true") {
                                        localStorage.setItem("productNr", productNr);
                                        window.location.href = "admin.reserveren.php";
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
                        url: "checkProductNr.php",
                        method: "POST",
                        data: {
                                productNr: productNr
                        },
                        success: function (data) {
                                if (data === "true") {
                                        localStorage.setItem("productNr", productNr);
                                        window.location.href = "admin.defectProduct.php";
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
