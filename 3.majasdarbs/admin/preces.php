<h2>Preces</h2>

<?php 
$e = 0;
//kļūdas kods sākumā ir 0, tātad nav kļūdu

//=================== PREČU REDIĢĒŠANA ==================
if (isset($_POST["atjauninat"]) && $e == 0) {

    $id = $_POST["rediget"];
    $nosaukums = $_POST["nosaukums"];
    $cena = $_POST["cena"];
    $kategorija = $_POST["kategorija"];
    $foto = $_POST["foto"];
    $apraksts = $_POST["apraksts"];
    $noliktava = $_POST["noliktava"];

    $target_file = ieladet_attelu();
    if ($target_file != "uploads/default.png") {
      $foto = $target_file;
    } 

    $sql = "UPDATE preces SET nosaukums='$nosaukums', cena='$cena', kategorijas_id='$kategorija', foto='$foto', apraksts='$apraksts', noliktava='$noliktava' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo "Preces dati veiksmīgi atjaunināti!";
    } else {
      echo "Kļūda labojot datus: " . $conn->error;
    }

}
//=================== BEIDZAS PREČU REDIĢĒŠANA ==================


$r = isset($_GET["rediget"]);
//ja saitē ir parametrs rediget, tad $r būs true (ieslēdzam rediģēšanas režīmu)

if ($r) {
    $id = $_GET["rediget"];
    //ja ir ieslēgts rediģēšanas režīms, tad iegūstam datus par rediģējamo lapu
    $sql = "SELECT * FROM preces WHERE id=$id";
    $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc(); 
            $nosaukums = $row["nosaukums"];
            $cena = $row["cena"];
            $foto = $row["foto"];
            $apraksts = $row["apraksts"];
            $kategorija = $row["kategorijas_id"];
            $noliktava = $row["noliktava"];
        }
    }
?>

<h4><?php if ($r) {echo "Rediģēt preci $nosaukums";} else {echo "Pievienot preci";}?></h4>

<form action="index.php?atvert=preces<?php if($r) {echo "&rediget=$id";} ?>" method="post"  enctype="multipart/form-data">
  <br>
  <input type="hidden" name="atvert" value="preces">
  <?php if ($r) {
    echo "<input type='hidden' name='rediget' value='$id'>";
  }
  ?>
  <input type="text" name="nosaukums" placeholder="Preces nosaukums" value="<?php if ($r || $e>0) {echo $nosaukums;} ?>" required><br><br>
  
  <input type="number" step="0.01"
 name="cena" placeholder="Preces cena" value="<?php if ($r || $e>0) {echo $cena;} ?>" required><br><br>
  
  <input type="hidden" name ="foto"placeholder="Foto adrese" value="<?php if ($r || $e>0) {echo $foto;} ?>">

  <?php if ($r) {echo "<img src='../$foto' width='300'><br><br>";} ?>

  Izvēlieties preces attēlu:<br>
  <input type="file" name="fileToUpload" id="fileToUpload"><br><br>

  Kategorija:&nbsp;
  <select name="kategorija">

<?php
  $sql = "SELECT * FROM kategorijas";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $nosaukums = $row["nosaukums"];
      echo "<option value='$id'";
      if($r && $kategorija == $id) {echo ' selected';} 
      echo ">$nosaukums</option>";
    }
  }
?>
</select><br><br>

  <textarea name="apraksts" placeholder="Preces apraksts" rows=5 cols=40><?php if ($r || $e>0) {echo $apraksts;} ?></textarea><br><br>

  <input type="number" 
 name="noliktava" placeholder="Preces atlikums noliktavā" value="<?php if ($r || $e>0) {echo $noliktava;}?>" required><br><br>

  <input type="submit" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Pievienot preci";}?>" name="<?php if ($r) {echo "atjauninat";} else {echo "pievienot";}?>"><br><br>
</form>

<?php




//=================== PREČU PIEVIENOŠANA ==================
if (isset($_POST["pievienot"]) && $e == 0) {
//pārbaudām, vai forma iesniegta

    $target_file = ieladet_attelu();


    $sql = "INSERT INTO preces (nosaukums, cena, foto, apraksts, kategorijas_id, noliktava)
    VALUES ('$_POST[nosaukums]', '$_POST[cena]', '$target_file', '$_POST[apraksts]', '$_POST[kategorija]', '$_POST[noliktava]')";
    
   // echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "<p>Prece veiksmīgi pievienota!</p>";
    } else {
        echo "<p>Kļūda: " . $sql . "<br>" . $conn->error . "</p>";
    }

} //beidzas pārbaude, vai forma iesniegta
//=============== BEIDZAS PREČU PIEVIENOŠANA ===============



//=================== PREČU DZĒŠANA ==================
if (isset($_GET["dzest"])) {
    $id = $_GET["dzest"];

    echo "<p>Vai tiešām vēlaties dzēst preci (id='$id')?<p>";
    echo "<a href='index.php?atvert=preces&tiesamdzest=$id'>JĀ</a> <a href='index.php?atvert=preces'>NĒ</a>";
}

if (isset($_GET["tiesamdzest"])) {
    $id = $_GET["tiesamdzest"];
    //ja saitē ir parametrs dzest, tad dzēšam attiecīgo sadaļu
    $sql = "DELETE FROM preces WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Prece (id=$id) ir veiksmīgi izdzēsta!</p>";
    } else {
        echo "<p>Kļūda dzēšot preci (id=$id): " . $conn->error . "</p>";
    }
}
//=================== BEIDZAS PREČU DZĒŠANA ==================



//=================== PREČU IZDRUKĀŠANA ==================
echo "<h4>Esošās preces:</h4>";
$sql = "SELECT * FROM preces";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

		$id = $row["id"];
		$nosaukums = $row["nosaukums"];
        $cena = $row["cena"];
        $foto = $row["foto"];
        $kategorija = $row["kategorijas_id"];
        $noliktava = $row["noliktava"];

        
        echo "<a href='index.php?atvert=preces&rediget=$id'>rediģēt</a> ";
        echo "<a href='index.php?atvert=preces&dzest=$id'>dzēst</a> ";
		echo "$id. $nosaukums ($cena EUR); Kategorija:$kategorija Atlikums:$noliktava<br>";

	}
}
//============== BEIDZAS PREČU IZDRUKĀŠANA ==================
?>