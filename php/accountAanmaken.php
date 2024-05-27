<?php
include('index.header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Registratie</title>
    <!-- Externe CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/accountAanmaken.css">
    <style>
        /* Your CSS styles hier */
    </style>
</head>
<body>
<div class="container">
<a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-container">
               
                <div id="error-message"></div>
                <form id="registrationForm" action="registreren.php" method="post" onsubmit="return validateForm()">
                    <div class="input-field">
                        <label for="voornaam">Voornaam:</label>
                        <input type="text" id="voornaam" name="voornaam" class="form-control" required>
                    </div>
                    <div class="input-field">
                        <label for="achternaam">Achternaam:</label>
                        <input type="text" id="achternaam" name="achternaam" class="form-control" required>
                    </div>
                    <div class="input-field">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="input-field">
                        <label for="passwoord">Wachtwoord:</label>
                        <input type="password" id="passwoord" name="passwoord" class="form-control" required>
                    </div>
                    <div class="input-field">
                        <label for="passwoord_confirm">Wachtwoord herhalen:</label>
                        <input type="password" id="passwoord_confirm" name="passwoord_confirm" class="form-control" required>
                    </div>
                    <input type="hidden" id="userType" name="userType" value="3">
                    <div class="buttons">
                        <button type="submit" class="btn btn-primary btn-block" onclick="setUserType(3)">Account Aanmaken</button>
                        <button type="button" class="btn btn-primary btn-block" id="admin" style="display: none;" onclick="setUserType(1)">Admin Aanmaken</button>
                        <button type="button" class="btn btn-primary btn-block" id="docent" style="display: none;" onclick="setUserType(2)">Docent Aanmaken</button>
                    </div>
                </form>
            </div>
            <div class="text-center mt-3 login-message">
                <h5 class="login-link">Al een account?</h5>
                <a href="index.php" class="btn btn-primary btn-block">Log in</a>
            </div>
        </div>
    </div>
</div>
<!-- Externe JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/validateAccountAanmaken.js"></script>
<script>
    // Function to display success message using SweetAlert2
    function showSuccessMessage() {
        Swal.fire({
            title: 'Account Aangemaakt',
            text: 'Je account is succesvol aangemaakt!',
            icon: 'success',
            confirmButtonText: 'Ga naar de startpagina'
        }).then((result) => {
            if (result.isConfirmed) {
                redirectToCatalog();
            }
        });
    }

    // Function to redirect to the index.php page
    function redirectToCatalog() {
        window.location.href = 'index.php';
    }

    // Check if success parameter is present in URL
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');

    // If success parameter is true, show success message
    if (successParam === 'true') {
        showSuccessMessage();
    }

</script>
</body>
</html>
