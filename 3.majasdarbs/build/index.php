<?php
// Start the session
session_start();
include 'functions.php';
include 'config.php';
?>
<!DOCTYPE html>
<html lang="lv">
<head>
<meta charset="UTF-8">
<meta name="viewport" content=
"width=device-width, initial-scale=1">
<title>Mājaslapas publiskā daļa</title>
<!-- Latest compiled and minified CSS -->
<link href=
"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
rel="stylesheet"><!-- Bootstrap Font Icon CSS -->
<link rel="stylesheet" href=
"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<!-- Latest compiled JavaScript -->

<script src=
"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<!-- Header daļa -->
<div class="container-fluid p-5 bg-success text-white">
<h1>Mājaslapas publiskā daļa</h1>
<p><?php
  if (pieteicies()) {
    //ja lietotājs ir pieteicies, tad izdrukājam sveiciena tekstu
    echo "Sveiki, ".segvards()."!<br>";
    echo "<a href='index.php?atvert=profils'>Mans profils</a><br>";
    echo "<a href='index.php?atvert=grozs'>Grozs</a>";
  } else {
    echo "Sveicināts, viesi!";
  }
?></p>
</div>
<!-- Galvenā izvēlne -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
<div class="container-fluid">
<!-- <a class="navbar-brand" href="javascript:void(0)">Logo</a> -->
<div class="collapse navbar-collapse" id="mynavbar">
<ul class="navbar-nav me-auto"><?php
    $sql = "SELECT id, nosaukums FROM lapas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
     // output data of each row
      while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $nosaukums = $row["nosaukums"];
        echo "<li class='nav-item'>
          <a class='nav-link' href='index.php?id=$id'>$nosaukums</a>
          </li>";
    }
}
?></ul>
<script>
    function meklet(str) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("rezultats").innerHTML = this.responseText;
          }
        };
      xmlhttp.open("GET", "shop.php?q=" + str, true);
      xmlhttp.send();
    
    }
</script>
<?php if (isset($_GET["atvert"]) && ($_GET["atvert"] == "veikals")) { ?>
<form class="d-flex"><input class="form-control me-2" type="text"
id="mekletajs" placeholder="Meklēt..." onkeyup=
"meklet(this.value)"></form>
<?php } ?><a href="index.php?atvert=veikals" class=
"nav_saite"><button class="btn btn-warning" type=
"button">Veikals</button></a> <?php
    //pogas uz admin paneli un pieteikšanos

    if(pieteicies()) { ?> <a href="logout.php" class=
"nav_saite"><button class="btn btn-primary" type=
"button">Atteikties</button></a> <?php if (irAdministrators()) { ?>
<a href="admin/index.php" class="nav_saite"><button class=
"btn btn-primary" type="button">Administrācijas
panelis</button></a> <?php } ?> <?php 
    } else { ?> <a href="login.php" class=
"nav_saite"><button class="btn btn-primary" type=
"button">Pieteikties</button></a> <?php 
    } ?></div>
</div>
</nav>
<!-- Satura daļa -->
<div class="container my-5 justifiedtext">
<div class="row">
<div class="col" id="rezultats"><?php

      if (isset($_GET["id"])) {
      //ja adresē tiek padots id, tad drukājam attiecīgās sadaļas saturu
        $id = $_GET["id"];

        $sql = "SELECT saturs FROM lapas WHERE id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
            //echo $row["saturs"];
            echo nl2br("<p>{$row['saturs']}</p>");

        }
      } elseif (isset($_GET["atvert"])) {
      //ja saitē ir parametrs atvert

        if ($_GET["atvert"] == "profils") {
          include 'profile.php';
        } elseif($_GET["atvert"] == "veikals") {
          include 'shop.php';
        } elseif($_GET["atvert"] == "grozs") {
          include 'cart.php';
        }

      }
    ?></div>
</div>
</div>
<!-- beidzas satura daļa -->
</body>
</html>
