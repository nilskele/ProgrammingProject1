document.addEventListener("DOMContentLoaded", function () {
  // Function to fetch data from the server and populate the table
  function fetchDataAndPopulateTable() {
    fetch("mandjeOphalen.php")
      .then((response) => response.json())
      .then((data) => {
        // Select the table body
        const tableBody = document.querySelector("table tbody");

        // Clear existing table rows
        tableBody.innerHTML = "";

        // Iterate over the data and create table rows
        data.forEach((row) => {
          // Create a new table row
          const newRow = document.createElement("tr");

          // Format Uitleendatum to 'dd/mm/yyyy' format
          const uitleendatumFormatted = formatDate(row.Uitleendatum);
          const terugbrengDatumFormatted = formatDate(row.terugbrengDatum);

          // Determine button classes based on possession
          const buttonClass =
            row.in_bezit === 1 ? "reserveren-button" : "uitlenen-button";

          // Populate the table row with data
          newRow.innerHTML = `
            <td>${row.groep_naam}</td>
            <td>${uitleendatumFormatted}</td>
            <td>${terugbrengDatumFormatted}</td>
            <td><button class="melden-button" value="${
              row.lening_id
            }">Melden</button></td>
            <td><button class="${buttonClass}" data-id="${
            row.product_id
          }" style="background-color: ${
            row.in_bezit === 1 ? "green" : "red"
          }; color: white;">${
            row.in_bezit === 1 ? "Verlengen" : "Annuleren"
          }</button></td>
          `;

          // Append the new row to the table body
          tableBody.appendChild(newRow);
        });
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // Function to format date as 'dd/mm/yyyy'
  function formatDate(dateString) {
    const datumBeschikbaarDate = new Date(dateString);
    const terugbrengDatumDate = new Date(datumBeschikbaarDate);
    terugbrengDatumDate.setDate(terugbrengDatumDate.getDate());
    return terugbrengDatumDate.toLocaleDateString("en-NL");
  }

  // Call the function to fetch data and populate the table when the page loads
  fetchDataAndPopulateTable();

  // Event delegation for button clicks
  document.querySelector("table").addEventListener("click", function (event) {
    const target = event.target;

    // Check if the clicked element is a button
    if (target.tagName === "BUTTON") {
      const id = target.getAttribute("data-id");
      const action = target.textContent.trim().toLowerCase();
      // Handle button clicks based on class name
      if (target.classList.contains("melden-button")) {
        let buttonValue = target.getAttribute("value");
        document.getElementById("lening_id").value = buttonValue;
        toonMMeldenPopUp();

        const form = document.getElementById("defectMeldenForm");

        form.addEventListener("submit", function (event) {
          event.preventDefault();

          const lening_id = localStorage.getItem("product_id");
          document.getElementById("lening_id").value = lening_id;

          const formData = new FormData(form);

          fetch(form.action, {
            method: "POST",
            body: formData,
          })
            .then((response) => {
              if (response.ok) {
                Swal.fire(
                  "Defect gemeld!",
                  "Het defect is succesvol gemeld.",
                  "success"
                );
              } else {
                throw new Error("Failed to submit form.");
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              Swal.fire({
                title: "Er is iets fout gegaan",
                text: "Probeer het later opnieuw.",
                icon: "error",
                confirmButtonText: "Ok",
              });
            });
        });
      } else if (target.classList.contains("reserveren-button")) {
        // Handle Reserveren button click
        if (target.textContent === "Annuleren") {
          Swal.fire({
            title: "Weet je zeker dat je wil annuleren?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, annuleren!",
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                "Cancelled!",
                "Je verlenging is geannuleerd.",
                "success"
              );
              // Add any further actions here after cancellation confirmation
              target.textContent = "Verlengen";
              target.style.backgroundColor = "green";
            }
          });
        } else {
          Swal.fire({
            title: "Weet je zeker dat je het item wil verlengen?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, verleng het!",
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire("Verlenged!", "Het item is verlengd.", "success");
              // Add any further actions here after lending confirmation
              target.textContent = "Annuleren";
              target.style.backgroundColor = "red";
            }
          });
        }
      } else if (target.classList.contains("uitlenen-button")) {
        // Handle Uitlenen button click
        if (target.textContent === "Annuleren") {
          Swal.fire({
            title: "Weet je zeker dat je de reservatie wilt annuleren?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, annuleren!",
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                "Cancelled!",
                "Je reservatie is geannuleerd.",
                "success"
              );
              // Add any further actions here after cancellation confirmation
              target.textContent = "Uitlenen";
              target.style.backgroundColor = "green";
            }
          });
        } else {
          Swal.fire({
            title: "Weet je zeker dat je het item wil uitlenen?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, leen het uit!",
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire("Uitgeleend!", "Het item is uitgeleend.", "success");
              // Add any further actions here after lending confirmation
              target.textContent = "Annuleren";
              target.style.backgroundColor = "red";
            }
          });
        }
      }
    }

    // Handle Verlengen button click
    if (target.textContent === "Verlengen") {
      const productId = target.getAttribute("data-id");

      // Fetch current date from server to calculate new terugbrengDatum
      fetchCurrentDateAndExtend(productId);
    }
  });

  let waarschuwingenCount = document.querySelector(".waarschuwingenCount");
  let waarshcuwingenDiv = document.querySelector(".waarschuwingenDiv");

  if (waarschuwingenCount) {
    fetch("waarschuwingenCount.php")
      .then((response) => response.json())
      .then((data) => {
        let waarschuwingenCountPhp = data;
        waarschuwingenCount.textContent = waarschuwingenCountPhp - 1;
      })
      .catch((error) => console.error("Error fetching data:", error));
  } else {
    console.error("Element with class 'waarschuwingenCount' not found.");
  }

  // Function to fetch current date from server and extend product return date
  function fetchCurrentDateAndExtend(productId) {
    // AJAX request to fetch current date from server
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          const currentDate = response.currentDate;

          // Calculate new terugbrengDatum (7 days from current date)
          const newReturnDate = new Date(currentDate);
          newReturnDate.setDate(newReturnDate.getDate() + 7);
          const formattedReturnDate = formatDate(newReturnDate);

          // Update database with new terugbrengDatum
          const updateData = {
            productId: productId,
            newReturnDate: formattedReturnDate,
          };

          // AJAX request to update database with new terugbrengDatum
          const xhrUpdate = new XMLHttpRequest();
          xhrUpdate.onreadystatechange = function () {
            if (xhrUpdate.readyState === XMLHttpRequest.DONE) {
              if (xhrUpdate.status === 200) {
                Swal.fire(
                  "Verlengd!",
                  "De terugbrengdatum is met 7 dagen verlengd.",
                  "success"
                );
                // Update UI to reflect new terugbrengDatum
                const verlengenButton = document.querySelector(
                  `[data-id="${productId}"]`
                );
                const returnDateCell =
                  verlengenButton.parentNode.previousElementSibling;
                returnDateCell.textContent = formattedReturnDate;
                verlengenButton.textContent = "Annuleren";
                verlengenButton.style.backgroundColor = "red";
              } else {
                console.error("Failed to update database.");
                Swal.fire({
                  title: "Er is iets fout gegaan",
                  text: "Probeer het later opnieuw.",
                  icon: "error",
                  confirmButtonText: "Ok",
                });
              }
            }
          };
          xhrUpdate.open("POST", "verlengen.php");
          xhrUpdate.setRequestHeader("Content-Type", "application/json");
          xhrUpdate.send(JSON.stringify(updateData));
        } else {
          console.error("Failed to fetch current date.");
          Swal.fire({
            title: "Er is iets fout gegaan",
            text: "Probeer het later opnieuw.",
            icon: "error",
            confirmButtonText: "Ok",
          });
        }
      }
    };
    xhr.open("GET", "updateDatabase.php");
    xhr.send();
  }

  // Function to display defect report popup
  function toonMMeldenPopUp() {
    document.getElementById("meldenPopUp").style.display = "block";
  }

  // Function to close defect report popup
  function sluitMMeldenPopUp() {
    document.getElementById("meldenPopUp").style.display = "none";
  }
});
