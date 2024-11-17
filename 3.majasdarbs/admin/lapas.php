<?php
  $r = isset($_GET["rediget"]);
?>

<h2>Lapas</h2>
<br>
<?php

//========= DUBLIKĀTA PĀRBAUDE ========
$e = 0; //sākumā kļūdas kods ir nulle, tātad kļūdu nav
if (isset($_GET["nosaukums"])) {
  $nosaukums = $_GET["nosaukums"];
  $taka = $_GET["taka"];

  $id = 0;
  if ($r) {$id = $_GET["rediget"];}

  $sql = "SELECT nosaukums FROM lapas WHERE nosaukums='$nosaukums' AND id != $id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $e = 1; //kļūda - dublējas nosaukums
  }

  $sql = "SELECT taka FROM lapas WHERE taka='$taka'  AND id != $id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $e += 2; //kļūda - dublējas nosaukums

  }

}

//========= BEIDZAS DUBLIKĀTA PĀRBAUDE ========

//======== LAPAS ATJAUNINĀŠANA =========
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
//======== BeIDZAS LAPAS ATJAUNINĀŠANA =========



  if ($r) {
    echo "<h4>Rediģēt mājaslapas sadaļu (lapu)</h4>";
  } else {
    echo "<h4>Pievienot mājaslapai sadaļu (lapu)</h4>";
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
    $taka = $_GET["taka"];
    $nosaukums = $_GET["nosaukums"];
    $saturs = $_GET["saturs"];
  }

?>
<br>
<form action="" method="get">

    <input type="hidden" name="atvert" value="lapas">

    <?php
    if ($r) {
      echo '<input type="hidden" name="rediget" value="'.$_GET["rediget"].'">';
    }
    ?>

    <input type="text" name="nosaukums" value="<?php if($r || $e>0) {echo $nosaukums;} ?>" placeholder="Lapas nosaukums" required><br><br>
    <?php if($e == 1 || $e == 3) {
      echo "<p>Tāds nosaukums jau eksistē!</p>";} ?>

    <input type="text" name="taka" placeholder="Lapas taka (īsceļš)" value="<?php if($r || $e>0) {echo $taka;} ?>" required><br><br>
    <?php if($e == 2 || $e == 3) {
      echo "<p>Tāda taka (īsceļš) jau eksistē!</p>";} ?>

    <textarea name="saturs" placeholder="Lapas saturs" rows=5 cols=40><?php if($r || $e>0) { echo $saturs;} ?></textarea><br><br>

    <input type="submit" name="<?php if($r) {echo "atjauninat";} else {echo "pievienot";} ?>" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Pievienot sadaļu";} ?>">
    
    <br><br>
</form>

<?php 

if (isset($_GET["pievienot"]) && $e==0) {
//ja administrators aizpildīja lapu pievienošanas formu un to iesniedza, tad pievienojam launo lapu datubāzei
  $nosaukums = $_GET["nosaukums"];
  $taka = $_GET["taka"];
  $saturs = $_GET["saturs"];
  
  $sql = "INSERT INTO lapas (nosaukums, taka, saturs)
  VALUES ('$nosaukums', '$taka', '$saturs')";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Lapa '$nosaukums' veiksmīgi pievienota!</p>";
  } else {
    echo "<p>Kļūda pievienojot lapu: " . $sql . "<br>" . $conn->error . "</p>";
  }
}

//============ LAPU DZĒŠANA ==========
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
 
//============ BEIDZAS LAPU DZĒŠANA ==========


//============ LAPU IZDRUKĀŠANA ==========
$sql = "SELECT id, nosaukums, laiks FROM lapas";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
     // output data of each row
      while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $nosaukums = $row["nosaukums"];
        $laiks = $row["laiks"];

        echo "<a href='index.php?atvert=lapas&dzest=$id'>dzēst</a> ";
        echo "<a href='index.php?atvert=lapas&rediget=$id'>rediģēt</a> ";
        echo "$id. $nosaukums $laiks<br>";
    }
}
//============ BEIDZAS LAPU IZDRUKĀŠANA ==========

?>