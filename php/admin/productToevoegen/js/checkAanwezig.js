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

  let completedChecks = 0;

  // Callback function to be executed after each check
  function checkComplete() {
    completedChecks++;

    if (completedChecks === 5) {
      // All checks are completed
      if (allInputsValid()) {
        submitForm();
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
  // Increment the counter for the synchronous check
  checkComplete();
}

function checkItem(url, data, messageSelector, existsMessage, callback) {
  $.ajax({
    url: url,
    method: "POST",
    data: data,
    success: function (response) {
      if (!hasSubmitted) {
        if (response === "exists") {
          console.log(data);
          $(messageSelector).text(existsMessage).addClass("error-message");
        } else {
          console.log("The item does not exist.");
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
  return (
    $("#brandMessage").text() === "" &&
    $("#nameMessage").text() === "" &&
    $("#categoryMessage").text() === "" &&
    $("#descriptionMessage").text() === ""
  );
}

function submitForm() {
  hasSubmitted = true;
  $("#productForm").off("submit").submit();
}
