<?php
// Start the session
session_start();
include '../functions.php';
include '../config.php';

//pārbaudām, vai lietotājs ir pieteicies
if (!pieteicies()) {
  //ja lietotājs nav ielogojies, tad sūtām viņu uz login.php
  header("Location: ../login.php");
  exit();
} elseif (!irAdministrators()) {
  //ja ir ielogojies, bet nav admin tiesību
  header("Location: ../index.php");
  exit();
} else {
//ja lietotājs ir ielogojies, tad rādām admin paneļa saturu
?>
<!DOCTYPE html>
<html lang="lv">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administrācijas panelis</title>
  
  <!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<!-- Header daļa -->
<div class="container-fluid p-5 bg-primary text-white">
  <h1>Administrācijas panelis</h1>
  <p><?php
  echo "Sveiki, ".segvards()."!";
  ?></p> 
</div>
  
<!-- Galvenā izvēlne -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="javascript:void(0)">Logo</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
       
      <li class="nav-item">
        <a class="nav-link" href="index.php">Sākums</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?atvert=lapas">Lapas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?atvert=lietotaji">Lietotāji</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?atvert=preces">Preces</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?atvert=kategorijas">Kategorijas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?atvert=pasutijumi">Pasūtījumi</a>
      </li>

      </ul>
	  <!--
      <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
    -->
    
      <a href="../logout.php" class="nav_saite"><button class="btn btn-primary" type="button">Atteikties</button></a>
      <a href="../index.php" class="nav_saite"><button class="btn btn-primary" type="button">Aplūkot mājaslapu</button></a>
    
    <!--</form> -->
    </div>
  </div>
</nav>

<!-- Satura daļa -->
<div class="container my-5 justifiedtext">
  <div class="row">
    <div class="col">

      <?php 
      if (isset($_GET["atvert"])) {
      //ja saitē tiek padots parametrs atvert, tad iekļaujam atbilstošo lapu (sadaļu)
      
        if ($_GET["atvert"] == "lapas") {
          include 'lapas.php';
        } elseif ($_GET["atvert"] == "lietotaji") {
          include 'lietotaji.php';
        } elseif ($_GET["atvert"] == "preces") {
          include 'preces.php';
        } elseif ($_GET["atvert"] == "kategorijas") {
          include 'kategorijas.php';
        } elseif ($_GET["atvert"] == "pasutijumi") {
          include 'pasutijumi.php';
        }
      
      } else {
        //ja nav padots atvert, rādām admin sākuma lapu
        echo "<p>Esiet sveicināts admin panelī!</p>";
      }
      ?>

      

    </div>
  </div>
</div>
<!-- beidzas satura daļa -->

</body>
</html>
<?php
} //beidzas pārbaude, vai lietotājs ir ielogojies
?>