<?php include 'config.php'; ?>
<h2>Reģistrēties</h2>

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


$r = false;
//ja saitē ir parametrs rediget, tad $r būs true (ieslēdzam rediģēšanas režīmu)

//Ja ir ievades kļūda (dublikāts), tad tiek sagatavoti mainīgie, kurus atprintēt atpakaļ formā
if ($e > 0) {
    $e_pasts = $_POST["e_pasts"];
	$segvards = $_POST["segvards"];
    $foto = $_POST["foto"];
    $apraksts = $_POST["apraksts"];
}


?>

<form action="" method="post">
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

  <input type="text" name="parole" placeholder="Lietotāja parole" value="<?php if ($r) {echo "mainītparoli";} ?>" required><br><br>
  
  <input type="text" name="foto" placeholder="Foto adrese" value="<?php if ($r || $e>0) {echo $foto;} ?>"><br><br>

  <textarea name="apraksts" placeholder="Lietotāja apraksts" rows=5 cols=40><?php if ($r || $e>0) {echo $apraksts;} ?></textarea><br><br>

  <input type="submit" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Reģistrēties";}?>" name="<?php if ($r) {echo "atjauninat";} else {echo "pievienot";}?>"><br><br>
</form>
  
  <a href="index.php">Uz sākumu</a>&nbsp;
  <a href="login.php">Pieteikties</a>

<?php




//=================== LIETOTĀJU PIEVIENOŠANA ==================
if (isset($_POST["pievienot"]) && $e == 0) {
//pārbaudām, vai forma iesniegta

    $sql = "INSERT INTO lietotaji (e_pasts, parole, segvards, loma, foto, apraksts)
    VALUES ('$_POST[e_pasts]', '".password_hash($_POST["parole"], PASSWORD_DEFAULT)."', '$_POST[segvards]', 'user', '$_POST[foto]', '$_POST[apraksts]')";
    
   // echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lietotājs veiksmīgi pievienots!</p>";
    } else {
        echo "<p>Kļūda: " . $sql . "<br>" . $conn->error . "</p>";
    }

} //beidzas pārbaude, vai forma iesniegta
//=============== BEIDZAS LIETOTĀJU PIEVIENOŠANA ===============


?>