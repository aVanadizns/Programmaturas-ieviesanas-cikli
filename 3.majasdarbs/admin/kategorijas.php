<h2>Preču kategorijas</h2>

<?php 
$e = 0;
//kļūdas kods sākumā ir 0, tātad nav kļūdu

//=================== KATEGORIJAS REDIĢĒŠANA ==================
if (isset($_POST["atjauninat"]) && $e == 0) {

    $id = $_POST["rediget"];
    $nosaukums = $_POST["nosaukums"];
    
    $sql = "UPDATE kategorijas SET nosaukums='$nosaukums' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo "Kategorijas dati veiksmīgi atjaunināti!";
    } else {
      echo "Kļūda labojot kategoriju: " . $conn->error;
    }

}
//=================== BEIDZAS KATEGORIJAS REDIĢĒŠANA ==================


$r = isset($_GET["rediget"]);
//ja saitē ir parametrs rediget, tad $r būs true (ieslēdzam rediģēšanas režīmu)

if ($r) {
    $id = $_GET["rediget"];
    //ja ir ieslēgts rediģēšanas režīms, tad iegūstam datus par rediģējamo lapu
    $sql = "SELECT * FROM kategorijas WHERE id=$id";
    $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc(); 
            $nosaukums = $row["nosaukums"];
        }
    }
?>

<h4><?php if ($r) {echo "Rediģēt kategoriju $nosaukums";} else {echo "Pievienot kategoriju";}?></h4>

<form action="index.php?atvert=kategorijas<?php if($r) {echo "&rediget=$id";} ?>" method="post"  enctype="multipart/form-data">
  <br>
  <input type="hidden" name="atvert" value="kategorijas">
  <?php if ($r) {
    echo "<input type='hidden' name='rediget' value='$id'>";
  }
  ?>
  <input type="text" name="nosaukums" placeholder="Kategorijas nosaukums" value="<?php if ($r || $e>0) {echo $nosaukums;} ?>" required><br><br>
  
  <input type="submit" value="<?php if ($r) {echo "Saglabāt izmaiņas";} else {echo "Pievienot kategoriju";}?>" name="<?php if ($r) {echo "atjauninat";} else {echo "pievienot";}?>"><br><br>
</form>

<?php




//=================== KATEGORIJAS PIEVIENOŠANA ==================
if (isset($_POST["pievienot"]) && $e == 0) {
//pārbaudām, vai forma iesniegta

    $sql = "INSERT INTO kategorijas (nosaukums)
    VALUES ('$_POST[nosaukums]')";
    
    echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "<p>Kategorija veiksmīgi pievienota!</p>";
    } else {
        echo "<p>Kļūda: " . $sql . "<br>" . $conn->error . "</p>";
    }

} //beidzas pārbaude, vai forma iesniegta
//=============== BEIDZAS KATEGORIJAS PIEVIENOŠANA ===============



//=================== KATEGORIJAS DZĒŠANA ==================
if (isset($_GET["dzest"])) {
    $id = $_GET["dzest"];

    echo "<p>Vai tiešām vēlaties dzēst kategoriju (id='$id')?<p>";
    echo "<a href='index.php?atvert=kategorijas&tiesamdzest=$id'>JĀ</a> <a href='index.php?atvert=kategorijas'>NĒ</a>";
}

if (isset($_GET["tiesamdzest"])) {
    $id = $_GET["tiesamdzest"];
    //ja saitē ir parametrs dzest, tad dzēšam attiecīgo sadaļu
    $sql = "DELETE FROM kategorijas WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Kategorija (id=$id) ir veiksmīgi izdzēsta!</p>";
    } else {
        echo "<p>Kļūda dzēšot kategoriju (id=$id): " . $conn->error . "</p>";
    }
}
//=================== BEIDZAS KATEGORIJAS DZĒŠANA ==================



//=================== KATEGORIJAS IZDRUKĀŠANA ==================
echo "<h4>Esošās kategorijas:</h4>";
$sql = "SELECT * FROM kategorijas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

		$id = $row["id"];
		$nosaukums = $row["nosaukums"];
        
        echo "<a href='index.php?atvert=kategorijas&rediget=$id'>rediģēt</a> ";
        echo "<a href='index.php?atvert=kategorijas&dzest=$id'>dzēst</a> ";
		echo "$id. $nosaukums<br>";

	}
}
//============== BEIDZAS KATEGORIJAS IZDRUKĀŠANA ==================
?>