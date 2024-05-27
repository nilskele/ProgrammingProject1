// Function for the toggle switch
function updateSearchType() {
    var searchToggle = document.getElementById('searchToggle');
    var searchType = document.getElementById('searchType');
    var labelID = document.getElementById('labelID');
    var labelNaam = document.getElementById('labelNaam');

    if (searchToggle.checked) {
        searchType.value = 'naam';
        labelID.classList.remove('active');
        labelNaam.classList.add('active');
    } else {
        searchType.value = 'id';
        labelID.classList.add('active');
        labelNaam.classList.remove('active');
    }

    // Save the state to localStorage
    localStorage.setItem('searchToggleState', searchToggle.checked);
}

// Function for the checkbox
function updateKitCheckbox() {
    var kitCheckbox = document.getElementById('kitCheckbox');
    localStorage.setItem('kitCheckboxState', kitCheckbox.checked);
}

function loadSearchType() {
    var searchToggle = document.getElementById('searchToggle');
    var searchType = document.getElementById('searchType');
    var labelID = document.getElementById('labelID');
    var labelNaam = document.getElementById('labelNaam');
    var kitCheckbox = document.getElementById('kitCheckbox');

    // Get the state from localStorage
    var toggleState = localStorage.getItem('searchToggleState') === 'true';
    var kitCheckboxState = localStorage.getItem('kitCheckboxState') === 'true';

    // Set the state of the checkboxes
    searchToggle.checked = toggleState;
    kitCheckbox.checked = kitCheckboxState;

    // Set the searchType and labels based on the state
    if (toggleState) {
        searchType.value = 'naam';
        labelID.classList.remove('active');
        labelNaam.classList.add('active');
    } else {
        searchType.value = 'id';
        labelID.classList.add('active');
        labelNaam.classList.remove('active');
    }
}

// Initialize the toggle labels and state on page load
document.addEventListener("DOMContentLoaded", function() {
    loadSearchType();
});

// Scroll to results if search was performed
function scrollToResults() {
    setTimeout(function() {
        document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
    }, 100); // Slight delay to ensure results are rendered
}

window.addEventListener('DOMContentLoaded', (event) => {
    if (new URLSearchParams(window.location.search).has('Zoeken')) {
        scrollToResults();
    }
});
