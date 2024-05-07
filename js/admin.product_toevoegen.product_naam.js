$(document).ready(function() {
  $('#productName').on('input', function() {
    var productName = $(this).val().trim();

    if (productName.length > 0) {
      $.ajax({
        url: 'admin.product_toevoegen.product_naam.php',
        method: 'POST',
        data: {
          productName: productName
        },
        success: function(response) {
          var suggestions = JSON.parse(response);
          displaySuggestions(suggestions);
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      });
    } else {
      $('#suggestionsDropdown').removeClass('show');
    }
  });

  function displaySuggestions(suggestions) {
    var suggestionsList = $('#suggestionsList');
    suggestionsList.empty();

    if (suggestions.length > 0) {
      suggestions.forEach(function(suggestion) {
        var suggestionItem = $('<a class="dropdown-item" href="#">').text(suggestion);
        suggestionItem.click(function() {
          $('#productName').val(suggestion);
          $('#suggestionsDropdown').removeClass('show');
        });
        suggestionsList.append(suggestionItem);
      });

      $('#suggestionsDropdown').addClass('show');
    } else {
      $('#suggestionsDropdown').removeClass('show');
    }
  }

  $(document).click(function(e) {
    if (!$(e.target).closest('.dropdown').length) {
      $('#suggestionsDropdown').removeClass('show');
    }
  });
});
