document.getElementById("loginForm").addEventListener("submit", function (event) {
    let email = document.getElementById("inputEmail3").value;
    let password = document.getElementById("inputPassword3").value;

    if (email.trim() === "" && password.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Fout",
            text: "Gelieve alle velden in te vullen.",
        });
        event.preventDefault();
    } else if (email.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Fout",
            text: "Gelieve een e-mailadres in te vullen.",
        });
        event.preventDefault();

    } else if (password.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Fout",
            text: "Gelieve een wachtwoord in te vullen.",
        });
        event.preventDefault();
    }
});


function OpenAdminLogin() {
    document.getElementById("AdminLoginDiv").style.display = "block";
}

function CloseAdminLogin() {
    document.getElementById("AdminLoginDiv").style.display = "none";
}

document.getElementById("AdminLoginForm").addEventListener("submit", function (event) {
    let email = document.getElementById("inputAdminEmail3").value;
    let password = document.getElementById("inputAdminPassword3").value;

    if (email.trim() === "" && password.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Fout",
            text: "Gelieve alle velden in te vullen.",
        });
        event.preventDefault();
    } else if (email.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Fout",
            text: "Gelieve een e-mailadres in te vullen.",
        });
        event.preventDefault();

    } else if (password.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Fout",
            text: "Gelieve een wachtwoord in te vullen.",
        });
        event.preventDefault();
    }
});