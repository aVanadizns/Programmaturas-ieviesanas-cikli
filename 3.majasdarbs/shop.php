<h2>Veikals</h2>


<script>
    function filtret(str) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("rezultats").innerHTML = this.responseText;
          }
        };
      xmlhttp.open("GET", "shop.php?cat=" + str, true);
      xmlhttp.send();
    
      //ja mainām kategoriju, izdzēšam atslēgvārdu no meklētāja
      document.getElementById("mekletajs").value = "";
      console.log('asad');
    }
</script>

<?php

if (isset($_GET["q"]) || isset($_GET["cat"])) {
    include 'config.php';
}

if (!isset($_SESSION["grozs"])) {
    $_SESSION["grozs"] = [];
}

//$_SESSION["grozs"] = []; //iztukšot grozu

if (isset($_GET["ielikt"])) {
    $id = $_GET["ielikt"];
    $prece = array("id"=>"$id", "daudzums"=>"1");

    $key = array_search($id, array_column($_SESSION["grozs"], 'id'));
    //noskaidrojam, vai šī prece jau ir grozā
    if ($key == "") {
        //ja pievienojamā prece nav grozā, tad to ieliekam
        array_push($_SESSION["grozs"], $prece);
    } else {
        //ja prece jau ir grozā, palielinām tās daudzumu
        $_SESSION["grozs"][$key]["daudzums"] += 1;
    }
    echo "<p>Prece pievienota grozam!<p>";
}

//print_r($_SESSION["grozs"]);
echo "<br>";

if (!isset($_GET["prece"])) {
  echo "<select onchange='filtret(this.value)'>";
  echo "<option value=''>Visas kategorijas</option>";
  $sql = "SELECT * FROM kategorijas";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

		$id = $row["id"];
		$nosaukums = $row["nosaukums"];

        echo "<option value='$id'";
        if (isset($_GET["cat"]) && ($_GET["cat"] == $id)) {
            echo " selected";
        }
        echo ">$nosaukums</option>";
    }
  }
  echo "</select><br><br>";
}

if (isset($_GET["prece"])) {
//ja saitē ir norādīts drukājamās preces id, tad drukājam tikai to vienu preci
//==================== VIENAS PRECES IZDRUKĀŠANA ========== 


    $id = $_GET["prece"]; //drukājāmās preces id
    $sql = "SELECT preces.*, kategorijas.nosaukums AS kat_nosaukums FROM preces INNER JOIN kategorijas ON preces.kategorijas_id = kategorijas.id WHERE preces.id=$id";
    //echo $sql;
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $id = $row["id"];
		$nosaukums = $row["nosaukums"];
        $cena = $row["cena"];
        $foto = $row["foto"];
        $kategorija = $row["kat_nosaukums"];
        $noliktava = $row["noliktava"];
        $apraksts = $row["apraksts"];

        echo "<a href='#'>Veikals->$kategorija</a>";
        echo "<h4>$nosaukums</h4>";
        echo "<p>$cena EUR</p>";
        echo "<p>Noliktavā: $noliktava</p>";

        echo "<a href='index.php?atvert=veikals&ielikt=$id&prece=$id' class=''><button class='btn btn-primary' type='button'>Ielikt grozā</button></a> ";
        echo "<a href='index.php?atvert=grozs'><button class='btn btn-primary   align-self-end mt-auto' >Aplūkot grozu</button></a><br><br>";

        echo "<img src='$foto' id='vienasPrecesBilde'>";
        echo "<div>$apraksts</div>";

    }

    
//==================== BEIDZAS VIENAS PRECES IZDRUKĀŠANA ==========

} else {

//=================== VISU PREČU IZDRUKĀŠANA ==================
$sql = "SELECT * FROM preces";

if (isset($_GET["q"])) {
    $atslegvards = $_GET["q"];
    $sql .= " WHERE nosaukums LIKE '%$atslegvards%'";
}

if (isset($_GET["cat"]) && !empty($_GET["cat"])) {
    $kategorijas_id = $_GET["cat"];
    $sql .= " WHERE kategorijas_id=$kategorijas_id";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

		$id = $row["id"];
		$nosaukums = $row["nosaukums"];
        $cena = $row["cena"];
        $foto = $row["foto"];
        $kategorija = $row["kategorijas_id"];
        $noliktava = $row["noliktava"];

        echo "<a href='index.php?atvert=veikals&prece=$id'>";
        echo "<div class='gallery'>";
        //echo "<a href='img_5terre.jpg'>";
        echo "<div id='precesRamis'>";
        echo "<img src='$foto' alt='$nosaukums'>";
        echo "</div>";
        //echo "</a>";
        echo "<div class='desc'><strong>$nosaukums</strong><br>$cena EUR</div>";

        echo "<a href='index.php?atvert=veikals&ielikt=$id' class=''><button class='btn btn-primary ielikt_groza' type='button'>Ielikt grozā</button></a>";

        echo "</div>";
        echo "</a>";
        
	}
}
//============== BEIDZAS VISU PREČU IZDRUKĀŠANA ==================
} //beidzas gadījums, kad jādrukā visas preces
?>