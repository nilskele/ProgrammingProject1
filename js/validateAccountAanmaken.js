
// Function to set the userType value
function setUserType(userType) {
    document.getElementById('userType').value = userType;
    document.getElementById('registrationForm').submit();
}

$(document).ready(function () {
    let admin = document.getElementById('admin'); 
    let docent = document.getElementById('docent');
    $.ajax({
        url: '../php/admin/getUsertype.php',
        type: 'GET',
        success: function (data) {
            if (data == 'Admin') {
                admin.style.display = 'block';
                docent.style.display = 'block';
            } 
        }
    });
});

function validateForm() {
    let errorMessage = ""; // Variabele voor foutmeldingen

    let email = document.getElementById('email').value;
    if (!email.endsWith('@student.ehb.be') && !email.endsWith('@ehb.be')) {
        errorMessage += 'Je kunt je alleen registreren met een e-mail van de school (student.ehb.be of ehb.be)<br>';
    }

    let passwoord = document.getElementById('passwoord').value;
    let confirmpasswoord = document.getElementById('passwoord_confirm').value;
    if (passwoord !== confirmpasswoord) {
        errorMessage += 'De wachtwoorden komen niet overeen<br>';
    }

    // Foutmeldingen weergeven in de error-message container
    document.getElementById('error-message').innerHTML = errorMessage;

    // Return true als er geen foutmeldingen zijn, anders false
    return errorMessage === "";
}