document.getElementById('categorie').addEventListener('change', function() {
  var categorieSelect = document.getElementById('categorie');
  var categoryOptions = categorieSelect.options;
  
  if (categorieSelect.value !== 'All') {
      categoryOptions[0].disabled = true; // Disable the "Categorie" option
  } else {
      categoryOptions[0].disabled = false; // Enable the "Categorie" option
  }
});
