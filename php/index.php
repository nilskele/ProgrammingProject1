<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Medialab</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</head>

<body>
  <?php
    include('index.header.php');
  ?>
  <div id="app">
    <div id="container">
      <div class="welcomeDiv">
        <div class="welcome">
          <h1>
            Welcome <br/>
            in het Medialab
          </h1>
          <p>
            Iets uitlenen? Doe maar gerust, als je de regels <br />
            hebt gelezen!! Meld uzelf hieronder aan of maak <br />
            een account met u school mail.
          </p>
          <div class="WelcomeButtons">
            <a class="btn btn-primary" href="accountAanmaken.php">
              Account aanmaken
            </a>
            <a class="btn btn-light" href="#inputEmail3">
              Log in
            </a>
          </div>
        </div>
      </div>

      <div class="Div3D">
        <img src="../images/3d-printer_44218.png" height="400px" alt="3d" />
      </div>
      <button class="btn btn-primary adminbtn" onclick="OpenAdminLogin()">
        Admin
      </button>

      <div class="adminLogin" id="AdminLoginDiv">
        <form action="index.adminLogin.php" class="AdminLoginContainer" id="AdminLoginForm" method="POST">
          <h1>Admin Login</h1>

          <div class="form-group row">
            <label for="inputAdminEmail3" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputAdminEmail3" name="inputEmail3" placeholder="Email">
            </div>
          </div>

          <div class="form-group row">
            <label for="inputAdminPassword3" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="inputAdminPassword3" name="inputPassword3"
                placeholder="Password">
            </div>
          </div>
          <button type="submit" class="btn btn-primary inloggen">Inloggen</button>
          <button type="button" class="btn btn-light" class="btn" onclick="CloseAdminLogin()">Terug</button>
        </form>
      </div>


      <form action="index.login.php" class="loginForm" id="loginForm" method="POST">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail3" name="inputEmail3" placeholder="Email">
          </div>
        </div>

        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-2 col-form-label">Password:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword3" name="inputPassword3"
              placeholder="Password">
          </div>
        </div>
        <button type="submit" class="btn btn-primary inloggen">Inloggen</button>
      </form>

      <div class="GeenAccount">
        <p>
          Nog geen account? =
        </p>
        <a class="btn btn-light accountAanmaken" href="../php/accountAanmaken.php">
          Account aanmaken
        </a>
      </div>
    </div>
  </div>
  <script src="../js/login.js"></script>
  <script src="../bootstrap/js/bootstrap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>