<?php
  $r = isset($_GET["rediget"]);
?>

<h2>Lietotāju konti</h2>
<br>
<?php

//========= DUBLIKĀTA PĀRBAUDE ========
$e = 0; //sākumā kļūdas kods ir nulle, tātad kļūdu nav
if (isset($_GET["e_pasts"])) {
  $e_pasts = $_GET["e_pasts"];
  $segvards = $_GET["segvards"];

  $id = 0;
  if ($r) {$id = $_GET["rediget"];}

  $sql = "SELECT e_pasts FROM lietotaji WHERE e_pasts='$e_pasts' AND id != $id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $e = 1; //kļūda - dublējas nosaukums
  }

  $sql = "SELECT segvards FROM lietotaji WHERE segvards='$segvards'  AND id != $id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $e += 2; //kļūda - dublējas nosaukums
  }

}

//========= BEIDZAS DUBLIKĀTA PĀRBAUDE ========

//======== LAPAS LIETOTĀJA =========
if (isset($_GET["atjauninat"]) && $e==0) {
  //ja forma tika iesniegta rediģēšanas režīmā, tad informāciju atbilstošajā rindiņā atjauniunām!
  $nosaukums = $_GET["nosaukums"];
  $taka = $_GET["taka"];
  $saturs = $_GET["saturs"];
  $id = $_GET["rediget"];

  $sql = "UPDATE lapas SET nosaukums='$nosaukums', taka='$taka', saturs='$saturs' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "<p>Lapa ($nosaukums) veiksmīgi atjaunināta!</p>";
  } else {
    echo "<p>Kļūda atjauninot lapu ($nosaukums): " . $conn->error . "!</p>";
  }
}
//======== BeIDZAS LIETOTĀJA ATJAUNINĀŠANA =========



  if ($r) {
    echo "<h4>Rediģēt lietotāja kontu</h4>";
  } else {
    echo "<h4>Pievienot lietotāja kontu</h4>";
  }

  if ($r) {
  //iegūstam rediģējamās lapas saturu
  $id = $_GET["rediget"];
    $sql = "SELECT nosaukums, taka, saturs FROM lapas WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $taka = $row["taka"];
      $nosaukums = $row["nosaukums"];
      $saturs = $row["saturs"];
    }
  }

  if ($e>0) {
    //ja bijusi kļūida, tad formā atprintēsim datus no iepriekš iesniegtajiem
    $e_pasts = $_GET["e_pasts"];
    $segvards = $_GET["segvards"];
    $parole = $_GET["parole"];
    $foto = $_GET["foto"];
    $apraksts = $_GET["apraksts"];
    $loma = $_GET["loma"];
  }

?>
<br>
<form action="" method="get">

    <input type="hidden" name="atvert" value="lietotaji">

    <?php
    if ($r) {
      echo '<input type="hidden" name="rediget" value="'.$_GET["rediget"].'">';
    }
    ?>

    <input type="text" name="e_pasts" value="<?php if($r || $e>0) {echo $e_pasts;} ?>" placeholder="Lietotāja e-pasts" required><br><br>
    <?php if($e == 1 || $e == 3) {
      echo "<p>Tāds e-pasts jau eksistē!</p>";} ?>

    <input type="text" name="segvards" placeholder="Lietotāja segvārds" value="<?php if($r || $e>0) {echo $segvards;} ?>" required><br><br>
    <?php if($e == 2 || $e == 3) {
      echo "<p>Tāds segvārds jau eksistē!</p>";} ?>

    <input type="text" name="parole" placeholder="Lietotāja parole" value="<?php if($r || $e>0) {echo $parole;} ?>" required><br><br>

    <input type="text" name="foto" placeholder="Lietotāja foto adrese" value="<?php if($r || $e>0) {echo $foto;} ?>"><br><br>

    Loma:&nbsp;
    <select name="loma">
      <option value="user" <?php if(($r || $e>0) && $loma == "user") {echo "selected";} ?>>Lietotājs</option>
      <option value="admin" <?php if(($r || $e>0) && $loma == "admin") {echo "selected";} ?>>Administrators</option>
    </select><br><br>

    <textarea name="apraksts" placeholder="Lietotāja apraksts..." rows=5 cols=40><?php if($r || $e>0) { echo $apraksts;} ?></textarea><br><br>

    <input type="submit" name="<?php if($r) {echo "atjauninat";} else {echo "pievienot";} ?>" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Pievienot lietotāju";} ?>">
    
    <br><br>
</form>

<?php 

//============ LIETOTĀJU PIEVIENOŠANA ==========
if (isset($_GET["pievienot"]) && $e==0) {
//ja administrators aizpildīja lapu pievienošanas formu un to iesniedza, tad pievienojam launo lapu datubāzei
  
  $sql = "INSERT INTO lietotaji (e_pasts, segvards, parole, foto, loma, apraksts)
  VALUES ('$_GET[e_pasts]', '$_GET[segvards]', '$_GET[parole]', '$_GET[foto]', '$_GET[loma]', '$_GET[apraksts]')";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Lietotājs '$_GET[e_pasts]' veiksmīgi pievienots!</p>";
  } else {
    echo "<p>Kļūda pievienojot lietotāju: " . $sql . "<br>" . $conn->error . "</p>";
  }
}
//============ BEIDZAS LIETOTĀJU PIEVIENOŠANA ==========

//============ LIETOTĀJU DZĒŠANA ==========
if (isset($_GET["dzest"])) {
  $id = $_GET["dzest"];

  echo "Vai tiešām dzēst sadaļu (id=$id)?<br>";
  echo "<a href='index.php?atvert=lapas&tiesamdzest=$id'>JĀ</a> ";
  echo "<a href='index.php?atvert=lapas'>NĒ</a><br><br>";
}

if (isset($_GET["tiesamdzest"])) {
  $id = $_GET["tiesamdzest"];
  $sql = "DELETE FROM lapas WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "<p>Lapas veiksmīgi izdzēsta!<p>";
  } else {
    echo "Kļūda dzēšot lapu (id=$id): " . $conn->error;
  }

}
 
//============ BEIDZAS LIETOTĀJU DZĒŠANA ==========


//============ LIETOTĀJU IZDRUKĀŠANA ==========
$sql = "SELECT id, e_pasts, segvards, loma FROM lietotaji";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
     // output data of each row
      while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $e_pasts = $row["e_pasts"];
        $segvards = $row["segvards"];
        $loma = $row["loma"];

        echo "<a href='index.php?atvert=lietotaji&dzest=$id'>dzēst</a> ";
        echo "<a href='index.php?atvert=lietotaji&rediget=$id'>rediģēt</a> ";
        echo "$id. $e_pasts ($segvards) $loma<br>";
    }
}
//============ BEIDZAS LIETOTĀJU IZDRUKĀŠANA ==========

?>