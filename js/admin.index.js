let topBtn = document.getElementById("topBtn");

window.onscroll = function () {
  scrollFunction();
};

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

let reserverenButtonProduct = document.getElementById(
  "reserverenButtonProduct"
);
let productNrInput = document.getElementById("productNrInput");

reserverenButtonProduct.addEventListener("click", function () {
  let productNr = productNrInput.value;

  if (productNr === "") {
    Swal.fire({
      icon: "error",
      title: "Oeps...",
      text: "Het productnummer mag niet leeg zijn!",
    });
  } else {
    $.ajax({
      url: "/ProgrammingProject1/php/checkProductNr.php",
      method: "POST",
      data: {
        productNr: productNr,
      },
      success: function (data) {
        if (data === "true") {
          localStorage.setItem("productNr", productNr);
          window.location.href =
            "/ProgrammingProject1/php/admin/reserveren/reserveren.php";
        } else {
          Swal.fire({
            icon: "error",
            title: "Oeps...",
            text: "Het productnummer bestaat niet!",
          });
        }
      },
    });
  }
});

let defectBtn = document.getElementById("defectBtn");

defectBtn.addEventListener("click", function () {
  let productNr = productNrInput.value;
  localStorage.removeItem("email");

  if (productNr === "") {
    Swal.fire({
      icon: "error",
      title: "Oeps...",
      text: "Het productnummer mag niet leeg zijn!",
    });
  } else {
    $.ajax({
      url: "/ProgrammingProject1/php/checkProductNr.php",
      method: "POST",
      data: {
        productNr: productNr,
      },
      success: function (data) {
        if (data === "true") {
          localStorage.setItem("productNr", productNr);
          window.location.href =
            "/ProgrammingProject1/php/admin/inAndOut/defectProduct.php";
        } else {
          Swal.fire({
            icon: "error",
            title: "Oeps...",
            text: "Het productnummer bestaat niet!",
          });
        }
      },
    });
  }
});

let acceptBtnKit = document.getElementById("acceptBtnKit");

acceptBtnKit.addEventListener("click", function () {
  let KitNrInput = document.getElementById("KitNrInput").value;
  localStorage.removeItem("email");

  if (KitNrInput === "") {
    Swal.fire({
      icon: "error",
      title: "Oeps...",
      text: "Het kitnummer mag niet leeg zijn!",
    });
  } else {
    $.ajax({
      url: "/ProgrammingProject1/php/checkKitNr.php",
      method: "POST",
      data: {
        KitNrInput: KitNrInput,
      },
      success: function (data) {
        if (data === "true") {
          localStorage.setItem("KitNr", KitNrInput);
          window.location.href =
            "/ProgrammingProject1/php/admin/inAndOut/accepterenKit.php";
        } else {
          Swal.fire({
            icon: "error",
            title: "Oeps...",
            text: "Het kitnummer bestaat niet!",
          });
        }
      },
    });
  }
});

let defectBtnKit = document.getElementById("defectBtnKit");

defectBtnKit.addEventListener("click", function () {
  let KitNrInput = document.getElementById("KitNrInput").value;
  localStorage.removeItem("email");

  if (KitNrInput === "") {
    Swal.fire({
      icon: "error",
      title: "Oeps...",
      text: "Het kitnummer mag niet leeg zijn!",
    });
  } else {
    $.ajax({
      url: "/ProgrammingProject1/php/checkKitNr.php",
      method: "POST",
      data: {
        KitNrInput: KitNrInput,
      },
      success: function (data) {
        if (data === "true") {
          localStorage.setItem("KitNr", KitNrInput);
          window.location.href =
            "/ProgrammingProject1/php/admin/inAndOut/defectKit.php";
        } else {
          Swal.fire({
            icon: "error",
            title: "Oeps...",
            text: "Het kitnummer bestaat niet!",
          });
        }
      },
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  $(document).on("click", ".defectBtn90", function (event) {
    event.preventDefault();
    let itemText = document.getElementById("accepterenProductID").textContent;
    let itemValue = itemText.match(/\d+/);
    if (itemValue) {
      localStorage.setItem("productNr", itemValue[0]);
      window.location.href =
        "/ProgrammingProject1/php/admin/inAndOut/defectProduct.php";
    } else {
      console.log("Geen productnr gevonden");
    }
  });
});
