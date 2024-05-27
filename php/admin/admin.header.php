<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php include 'checkIngelogd.php'; ?>

<nav class="navbar fixed-top navbar-light nav_shadow">
  <a class="navbar-brand mb-0 h1 medialab" href="/ProgrammingProject1/php/admin/admin.index.php">
    <img src="/ProgrammingProject1/images/EhB-logo-transparant.png" width="60" class="d-inline-block align-top"
      alt="ehb EhB-logo-transparant" />
    <span class="medialabTitleNav">
      Medialab
    </span>
  </a>
  <div class="navbar-nav">
  <a class="nav-item nav-link" href="/ProgrammingProject1/php/admin/defect/defect.php">Defecten</a>
  <a class="nav-item nav-link" href="/ProgrammingProject1/php/admin/statistieke/statistiekePagina.php">Statistieken</a>
    <a class="nav-item nav-link" href="/ProgrammingProject1/php/admin/inAndOut/inAndOut.php">In and Out</a>
    <a class="nav-item nav-link" href="/ProgrammingProject1/php/admin/teLaat/teLaatIngebracht.php">Te laat</a>
    <a class="nav-item nav-link" href="/ProgrammingProject1/php/admin/blacklist/blacklist.php">Blacklist</a>
    <a class="nav-item nav-link" href="/ProgrammingProject1/php/logout.php"><img src="/ProgrammingProject1/images/logout-svgrepo-com.svg" alt="logout"
        height="25px"></a>
  </div>
</nav>