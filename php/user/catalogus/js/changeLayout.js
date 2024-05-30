// Met deze javascript file kan de gebruiker de layout van de producten in de catalogus veranderen.
document.addEventListener("DOMContentLoaded", function () {
  var button = document.getElementById("changeLayout");
  var products = document.querySelectorAll(".product");
  var image = button.querySelector(".imagelayoutwijzigen");
  var isLayout1 = true;
  var isLayoutHidden = false;

  button.addEventListener("click", function () {
    var src1 = "/ProgrammingProject1/images/layoutChange1.png";
    var src2 = "/ProgrammingProject1/images/layoutChange2.png";

    isLayout1 = !isLayout1;
    isLayoutHidden = !isLayoutHidden;

    image.src = isLayout1 ? src1 : src2;

    var producten = document.querySelectorAll(".resultaten");
    producten.forEach(function (product) {
      product.classList.toggle("columns", isLayoutHidden);
    });

    products.forEach(function (product) {
      product.classList.toggle("fixed-height", isLayoutHidden);
    });
  });
});
