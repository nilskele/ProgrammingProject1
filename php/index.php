<!DOCTYPE html >
<html lang = "en">

<head>
  <meta charset = "UTF-8" />
  <meta name = "viewport" content = "width=device-width, initial-scale=1.0" />
  <title>Medialab</title>
  <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />
</head>

<body>

  <div id = "app">
    <div id = "container">
    <?php
      include('header.php');
    ?>
      <div class = "welcomeDiv">
        <div class = "welcome">
          <h1>
            Welcome <br />
            in het Medialab
          </h1>
          <p>
            Iets uitlenen? Doe maar gerust, als je de regels <br />
            hebt gelezen!! Meld uzelf hieronder aan of maak <br />
            een account met u school mail.
          </p>
          <div class = "WelcomeButtons">
            <a class = "btn btn-primary" href = "./accountAanmaken.php">
              Account aanmaken
            </a>
            <a class = "btn btn-light">
              Log in
            </a>
          </div>
        </div>
      </div>

      <div class = "Div3D" >
        <img src = "../images/3d-printer_44218.png" height = "400px" alt = "3d" />
      </div>
      <a class = "btn btn-primary adminbtn" href = "admin.php">
        Admin
      </a>
      <div class = "loginForm">
        <div class = "form-group row">
          <label for = "inputEmail3" class = "col-sm-2 col-form-label">
            Email:
          </label>
          <div class = "col-sm-10">
            <input type = "email" class = "form-control" id = "inputEmail3" placeholder = "Email" />
          </div>
        </div>

        <div class = "form-group row">
          <label for = "inputPassword3" class = "col-sm-2 col-form-label">
            Password:
          </label>
          
          <div class = "col-sm-10">
            <input type = "password" class = "form-control" id = "inputPassword3" placeholder = "Password" />
          </div>
        </div>
        <a class = "btn btn-primary inloggen" href = "../catalogus/catalogus.php">
          Inloggen
        </a>
      </div>
      <div class = "GeenAccount">
        <p>
          Nog geen account? =
        </p>
        <a class = "btn btn-light accountAanmaken" href = "./accountAanmaken.php">
          Account aanmaken
        </a>
      </div>
    </div>
  </div>

  <script type = "module" src = ""></script>
  <script src = "/bootstrap/js/bootstrap.js"></script>
</body>

</html>