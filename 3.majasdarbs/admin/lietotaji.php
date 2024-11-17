<h2>Lietotāju konti</h2>

<?php 
$e = 0;
//kļūdas kods sākumā ir 0, tātad nav kļūdu
//========== dublikāta pārbaude ===============
if (isset($_POST["e_pasts"])) {
    $e_pasts = $_POST["e_pasts"];
    $segvards = $_POST["segvards"];

    if (isset($_POST["rediget"])) {
        $id = $_POST["rediget"];
    } else {
        $id = 0;
    }

    //parbaudām, vai datubāzē eksistē rinda ar tādu pašu nosaukumu
    $sql = "SELECT e_pasts FROM lietotaji WHERE e_pasts='$e_pasts' AND id != $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $e = 1;//kļūda - tāds e_pasts jau eksistē
    }

    //parbaudām, vai datubāzē eksistē rinda ar tādu pašu nosaukumu
    $sql = "SELECT segvards FROM lietotaji WHERE segvards='$segvards' AND id != $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if ($e == 0) {
            $e = 2;//kļūda - tāds segvards jau eksistē
        } else {
            $e = 3;//ja pirms tam segvārds arī bija nepareizs, tad kļūdas kods 3 nozīmē, ka gan nosaukums, gan segvārds ir nepareizi
        }
    }
}
//========== beidzas dublikāta pārbaude ===============


//=================== LIETOTĀJU REDIĢĒŠANA ==================
if (isset($_POST["atjauninat"]) && $e == 0) {

    $id = $_POST["rediget"];
    $e_pasts = $_POST["e_pasts"];
    $segvards = $_POST["segvards"];
    $loma = $_POST["loma"];
    $foto = $_POST["foto"];
    $apraksts = $_POST["apraksts"];
    $parole = $_POST["parole"];


    $sql = "UPDATE lietotaji SET ";
    
    if ($parole != "") {
      $parole = password_hash($_POST["parole"], PASSWORD_DEFAULT);
      $sql .= "parole='$parole', "; 
    }
    
    $sql .= "e_pasts='$e_pasts', segvards='$segvards', loma='$loma', foto='$foto', apraksts='$apraksts' WHERE id=$id";

    echo $sql;

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }

}
//=================== BEIDZAS LIETOTĀJU REDIĢĒŠANA ==================


$r = isset($_GET["rediget"]);
//ja saitē ir parametrs rediget, tad $r būs true (ieslēdzam rediģēšanas režīmu)

if ($r) {
$id = $_GET["rediget"];
//ja ir ieslēgts rediģēšanas režīms, tad iegūstam datus par rediģējamo lapu
$sql = "SELECT * FROM lietotaji WHERE id=$id";
$result = $conn->query($sql);
    if ($result->num_rows == 1) {
		$row = $result->fetch_assoc(); 
		$e_pasts = $row["e_pasts"];
        $segvards = $row["segvards"];
        $loma = $row["loma"];
        $foto = $row["foto"];
        $apraksts = $row["apraksts"];
	}
}


//Ja ir ievades kļūda (dublikāts), tad tiek sagatavoti mainīgie, kurus atprintēt atpakaļ formā
if ($e > 0) {
    $e_pasts = $_POST["e_pasts"];
	$segvards = $_POST["segvards"];
    $foto = $_POST["foto"];
    $loma = $_POST["loma"];
    $apraksts = $_POST["apraksts"];
}


?>

<h4><?php if ($r) {echo "Rediģēt lietotāju $e_pasts";} else {echo "Pievienot lietotāju";}?></h4>

<form action="index.php?atvert=lietotaji" method="post">
  <br>
  <input type="hidden" name="atvert" value="lietotaji">
  <?php if ($r) {
    echo "<input type='hidden' name='rediget' value='$id'>";
  }
  ?>
  <input type="text" name="e_pasts" placeholder="Lietotāja e-pasts" value="<?php if ($r || $e>0) {echo $e_pasts;} ?>" required><br><br>
  <?php if ($e==1 || $e==3) echo "Tāda e-pasta adrese jau eksistē!<br><br>";?>
  
  <input type="text" name="segvards" placeholder="Lietotāja segvārds" value="<?php if ($r || $e>0) {echo $segvards;} ?>" required><br><br>
  <?php if ($e==2 || $e==3) echo "Tāds segvārds jau eksistē!<br><br>"; ?>

  <input type="text" name="parole" placeholder="Lietotāja parole" value="" <?php if($r != true) {echo "required";} ?>><br><br>
  
  <input type="text" name="foto" placeholder="Foto adrese" value="<?php if ($r || $e>0) {echo $foto;} ?>"><br><br>

  Loma:&nbsp;
  <select name="loma">
    <option value="user" <?php if(($r || $e>0) && $loma == "user") {echo "selected";} ?>>Lietotājs</option>
    <option value="admin" <?php if(($r || $e>0) && $loma == "admin") {echo "selected";} ?>>Administrators</option>
  </select><br><br>

  <textarea name="apraksts" placeholder="Lietotāja apraksts" rows=5 cols=40><?php if ($r || $e>0) {echo $apraksts;} ?></textarea><br><br>

  <input type="submit" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Pievienot lietotāju";}?>" name="<?php if ($r) {echo "atjauninat";} else {echo "pievienot";}?>"><br><br>
</form>

<?php




//=================== LIETOTĀJU PIEVIENOŠANA ==================
if (isset($_POST["pievienot"]) && $e == 0) {
//pārbaudām, vai forma iesniegta

    $sql = "INSERT INTO lietotaji (e_pasts, parole, segvards, loma, foto, apraksts)
    VALUES ('$_POST[e_pasts]', '".password_hash($_POST["parole"], PASSWORD_DEFAULT)."', '$_POST[segvards]', '$_POST[loma]', '$_POST[foto]', '$_POST[apraksts]')";
    
   // echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lietotājs veiksmīgi pievienots!</p>";
    } else {
        echo "<p>Kļūda: " . $sql . "<br>" . $conn->error . "</p>";
    }

} //beidzas pārbaude, vai forma iesniegta
//=============== BEIDZAS LIETOTĀJU PIEVIENOŠANA ===============



//=================== LIETOTĀJU DZĒŠANA ==================
if (isset($_GET["dzest"])) {
    $id = $_GET["dzest"];

    echo "<p>Vai tiešām vēlaties dzēst lietotāju (id='$id')?<p>";
    echo "<a href='index.php?atvert=lietotaji&tiesamdzest=$id'>JĀ</a> <a href='index.php?atvert=lietotaji'>NĒ</a>";
}

if (isset($_GET["tiesamdzest"])) {
    $id = $_GET["tiesamdzest"];
    //ja saitē ir parametrs dzest, tad dzēšam attiecīgo sadaļu
    $sql = "DELETE FROM lietotaji WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lietotājs (id=$id) ir veiksmīgi izdzēsts!</p>";
    } else {
        echo "<p>Kļūda dzēšot lietotāju (id=$id): " . $conn->error . "</p>";
    }
}
//=================== BEIDZAS LIETOTĀJU DZĒŠANA ==================



//=================== LIETOTĀJU IZDRUKĀŠANA ==================
echo "<h4>Esošie lietotāju konti:</h4>";
$sql = "SELECT id, e_pasts, segvards, loma FROM lietotaji";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

		$id = $row["id"];
		$e_pasts = $row["e_pasts"];
        $segvards = $row["segvards"];
        $loma = $row["loma"];
        
        echo "<a href='index.php?atvert=lietotaji&rediget=$id'>rediģēt</a> ";
        echo "<a href='index.php?atvert=lietotaji&dzest=$id'>dzēst</a> ";
		echo "$id. $e_pasts $segvards $loma<br>";

	}
}
//============== BEIDZAS LIETOTĀJU IZDRUKĀŠANA ==================
?>