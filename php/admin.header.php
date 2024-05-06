<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php include 'admin.checkIngelogd.php'; ?>

<nav class="navbar fixed-top navbar-light nav_shadow">
  <a class="navbar-brand mb-0 h1 medialab" href="admin.index.php">
    <img src="../images/EhB-logo-transparant.png" width="60" class="d-inline-block align-top"
      alt="ehb EhB-logo-transparant" />
    <span class="medialabTitleNav">
      Medialab
    </span>
  </a>
  <div class="navbar-nav">

    <a class="nav-item nav-link" href="admin.inandout.php">In and Out</a>
    <a class="nav-item nav-link" href="admin.laatingebracht.php">Te laat</a>
    <a class="nav-item nav-link" href="admin.blacklist.php">Blacklist</a>
    <a class="nav-item nav-link" href="logout.php"><img src="../images/logout-svgrepo-com.svg" alt="loagout"
        height="25px"></a>
  </div>
</nav>