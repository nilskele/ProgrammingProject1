document.getElementById("loginForm").addEventListener("submit", function (event) {
  event.preventDefault();
  let email = document.getElementById("inputEmail3").value;
  let password = document.getElementById("inputPassword3").value;

    // Check of de velden zijn ingevuld
  if (email.trim() === "" && password.trim() === "") {
      Swal.fire({
          icon: "error",
          title: "Fout",
          text: "Gelieve alle velden in te vullen.",
      });
      return;

      // Check of het e-mailadres is ingevuld
  } else if (email.trim() === "") {
      Swal.fire({
          icon: "error",
          title: "Fout",
          text: "Gelieve een e-mailadres in te vullen.",
      });
      return;

      // Check of het e-mailadres een studenten e-mailadres is of docenten e-mailadres
  } else if (!email.endsWith("@student.ehb.be") && !email.endsWith("@ehb.be")) {
      Swal.fire({
          icon: "error",
          title: "Fout",
          text: "Je kunt je alleen inloggen met een e-mail van de school (student.ehb.be)",
      });
      return;

        // Check of het wachtwoord is ingevuld
  } else if (password.trim() === "") {
      Swal.fire({
          icon: "error",
          title: "Fout",
          text: "Gelieve een wachtwoord in te vullen.",
      });
      return;
  }

  // AJAX-oproep om in te loggen
  $.ajax({
      url: "../php/index.login.php",
      type: "POST",
      dataType: "json",
      data: {
          inputEmail3: email,
          inputPassword3: password,
      },
      success: function (response) {
          if (response.status === "success") {
              Swal.fire({
                  icon: "success",
                  title: "Succes",
                  text: "Je bent succesvol ingelogd.",
                  timer: 2000,
              }).then(() => {
                  window.location.href = response.redirect;
              });
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Fout",
                  text: response.message,
              });
          }
      },
  });
});
