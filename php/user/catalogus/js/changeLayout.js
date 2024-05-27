document.addEventListener("DOMContentLoaded", function () {
  var button = document.getElementById("changeLayout");
  var products = document.querySelectorAll(".resultaten");
  var image = button.querySelector(".imagelayoutwijzigen");
  var isLayout1 = true; // Initial state
  var isLayoutHidden = false; // Initial state

  button.addEventListener("click", function () {
    // Define the image sources
    var src1 = "/ProgrammingProject1/images/layoutChange1.png";
    var src2 = "/ProgrammingProject1/images/layoutChange2.png";

    // Toggle the state for layout and visibility
    isLayout1 = !isLayout1;
    isLayoutHidden = !isLayoutHidden;

    // Update the image source based on the state
    image.src = isLayout1 ? src1 : src2;

    // Toggle the hidden class for each product
    products.forEach(function (product) {
      product.classList.toggle("columns", isLayoutHidden);
    });
  });
});
