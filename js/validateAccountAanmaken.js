function validateForm() {
    let errorMessage = ""; // Variabele voor foutmeldingen

    let email = document.getElementById('email').value;
    if (!email.endsWith('@student.ehb.be')) {
        errorMessage += 'Je kunt je alleen registreren met een e-mail van de school (student.ehb.be)<br>';
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