let hasSubmitted = false;

$(document).ready(function () {
  // Event listener for form submission
  $("#productForm").submit(function (e) {
    e.preventDefault();
    checkInputs();
  });

  // Event listener for keydown event on input fields
  $("#productName, #merk, #categorie, #beschrijving").on(
    "keydown",
    function (e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        $("#productForm").submit();
      }
    }
  );
});

function checkInputs() {
  const merk = $("#merk").val();
  const productName = $("#productName").val();
  const category = $("#categorie").val();
  const beschrijving = $("#beschrijving").val();
  const quantity = $("#quantity").val();

  let completedChecks = 0;

  // Callback function to be executed after each check
  function checkComplete() {
    completedChecks++;
    if (completedChecks === 4) {
      // All checks are completed
      if (true) {
        console.log("All inputs are valid.");
        // Submit the form multiple times based on quantity
        for (let i = 0; i < quantity; i++) {
          submitForm();
        }
      }
    }
  }

  // Call the asynchronous checks for each input
  checkItem(
    "merkOphalen.php",
    { merk: merk },
    "#brandMessage",
    "The brand already exists.",
    checkComplete
  );
  checkItem(
    "product_naamOphalen.php",
    { productName: productName },
    "#nameMessage",
    "The name already exists.",
    checkComplete
  );
  checkItem(
    "categoryOphalen.php",
    { category: category },
    "#categoryMessage",
    "The category already exists.",
    checkComplete
  );
  checkItem(
    "beschrijvingOphalen.php",
    { beschrijving: beschrijving },
    "#descriptionMessage",
    "The description already exists.",
    checkComplete
  );
}

function checkItem(url, data, messageSelector, existsMessage, callback) {
  $.ajax({
    url: url,
    method: "POST",
    data: data,
    success: function (response) {
      if (!hasSubmitted) {
        if (response === "exists") {
          $(messageSelector).text(existsMessage).addClass("error-message");
        } else {
          $(messageSelector).text("").removeClass("error-message");
        }
      }
      if (callback) {
        callback();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      if (callback) {
        callback();
      }
    },
  });
}

function allInputsValid() {
  let valid = (
    $("#brandMessage").text() !== "" &&
    $("#nameMessage").text() !== "" &&
    $("#categoryMessage").text() !== "" &&
    $("#descriptionMessage").text() !== ""
  );
  console.log("All inputs are valid:", valid);
  return valid;
}

function submitForm() {
  hasSubmitted = true;

  const formData = new FormData($("#productForm")[0]);

  $.ajax({
    url: "productToevoegenBackend.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      console.log("Response:", response);
      if (response.status === "success") {
        console.log("Product added successfully.");
        $("#formMessage").text("Product added successfully.").removeClass("error-message").addClass("success-message");
      } else {
        console.error("Error adding product:", response.message);
        $("#formMessage").text(`Error adding product: ${response.message}`).removeClass("success-message").addClass("error-message");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      $("#formMessage").text(`Error adding product: ${error}`).removeClass("success-message").addClass("error-message");
    }
  });
}
