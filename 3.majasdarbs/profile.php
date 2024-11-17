<h2>Mans profils</h2>

<?php 
$e = 0;
//kļūdas kods sākumā ir 0, tātad nav kļūdu
//========== dublikāta pārbaude ===============
if (isset($_POST["e_pasts"])) {
    $e_pasts = $_POST["e_pasts"];
    $segvards = $_POST["segvards"];

    if (isset($_SESSION["lietotajs"])) {
        $id = $_SESSION["lietotajs"];
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
    $foto = $_POST["foto"];
    $parole = $_POST["parole"];
    $apraksts = $_POST["apraksts"];


    $sql = "UPDATE lietotaji SET ";
    
    if ($parole != "") {
        $parole = password_hash($parole, PASSWORD_DEFAULT);
        $sql .= "parole='$parole', ";
    }

    $sql .= "e_pasts='$e_pasts', segvards='$segvards', foto='$foto', apraksts='$apraksts' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo "Dati veiksmīgi atjaunināti!";
    } else {
      echo "Kļūda atjauninot datus: " . $conn->error;
    }

}
//=================== BEIDZAS LIETOTĀJU REDIĢĒŠANA ==================


$r = true;
//ja saitē ir parametrs rediget, tad $r būs true (ieslēdzam rediģēšanas režīmu)

if ($r) {
$id = $_SESSION["lietotajs"];
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

<form action="index.php?atvert=profils" method="post">
  <br>
  <input type="hidden" name="atvert" value="profils">
  <?php if ($r) {
    echo "<input type='hidden' name='rediget' value='$id'>";
  }
  ?>
  <input type="text" name="e_pasts" placeholder="Lietotāja e-pasts" value="<?php if ($r || $e>0) {echo $e_pasts;} ?>" required><br><br>
  <?php if ($e==1 || $e==3) echo "Tāda e-pasta adrese jau eksistē!<br><br>";?>
  
  <input type="text" name="segvards" placeholder="Lietotāja segvārds" value="<?php if ($r || $e>0) {echo $segvards;} ?>" required><br><br>
  <?php if ($e==2 || $e==3) echo "Tāds segvārds jau eksistē!<br><br>"; ?>

  <input type="text" name="parole" placeholder="Lietotāja parole" value="" ><br><br>
  
  <input type="text" name="foto" placeholder="Foto adrese" value="<?php if ($r || $e>0) {echo $foto;} ?>"><br><br>

  <textarea name="apraksts" placeholder="Lietotāja apraksts" rows=5 cols=40><?php if ($r || $e>0) {echo $apraksts;} ?></textarea><br><br>

  <input type="submit" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Pievienot lietotāju";}?>" name="<?php if ($r) {echo "atjauninat";} else {echo "pievienot";}?>"><br><br>
</form>

<?php

//=================== LIETOTĀJU DZĒŠANA ==================
if (isset($_POST["dzest"])) {
    $id = $_POST["dzest"];

    echo "<p>Vai tiešām vēlaties dzēst lietotāju (id='$id')?<p>";
    echo "<a href='index.php?atvert=lietotaji&tiesamdzest=$id'>JĀ</a> <a href='index.php?atvert=lietotaji'>NĒ</a>";
}

if (isset($_POST["tiesamdzest"])) {
    $id = $_POST["tiesamdzest"];
    //ja saitē ir parametrs dzest, tad dzēšam attiecīgo sadaļu
    $sql = "DELETE FROM lietotaji WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lietotājs (id=$id) ir veiksmīgi izdzēsts!</p>";
    } else {
        echo "<p>Kļūda dzēšot lietotāju (id=$id): " . $conn->error . "</p>";
    }
}
//=================== BEIDZAS LIETOTĀJU DZĒŠANA ==================

?>