<h2>Grozs</h2>

<?php
if (isset($_SESSION['grozs']) && isset($_GET["iztirit"])) {
    $_SESSION['grozs'] = [];
}

if(isset($_SESSION["grozs"]) && !empty($_SESSION["grozs"])) {
    
//================= PASŪTĪJUMS ==========

  if(isset($_GET["pasutit"])) {
    //ja ir komanda pasūtīt, veidojam pasūtījumu
  
    //veicam ierakstu tabulā pasutijumi
    $sql = "INSERT INTO pasutijumi (lietotaja_id, statuss)
    VALUES ('$_SESSION[lietotajs]', 'pasūtījums saņemts')";
    if ($conn->query($sql) === TRUE) {
        //echo "<p>Pasūtījuns veiksmīgi veikts!</p>";
    } else {
        echo "<p>Kļūda: " . $sql . "<br>" . $conn->error . "</p>";
    }
  
    // ievietojam pasūtijuma preces tabulā pasutijuma_preces
    $last_id = $conn->insert_id; //jaunā pasūtījuma id
    $grozs = $_SESSION['grozs'];
    $daudzums_groza = count($grozs); //preču skaits grozā
    
    for($x = 0; $x < $daudzums_groza; $x++) {
    //aplūkojam katru preci grozā
      
      $id = $grozs[$x]['id'];  //preces id      
      $daudzums = $grozs[$x]['daudzums'];
  
      //liekam tekošo preci tabulā pasutijuma_preces
      $sql = "INSERT INTO pasutijuma_preces (pasutijuma_id, preces_id, daudzums)
      VALUES ('$last_id', '$id', '$daudzums')";
      if ($conn->query($sql) === TRUE) {
          //echo "<p>Pasūtījuns veiksmīgi veikts!</p>";
      } else {
          echo "<p>Kļūda: " . $sql . "<br>" . $conn->error . "</p>";
      }
  
    }
  
    echo "Pasūtījums ir veikts!";
    $_SESSION['grozs'] = [];
    
    } else {


//================== BEIDZAS PASŪTĪJUMS ===========
    
    if (isset($_GET["dzest"])) {
        //ja ir dota komanda, dzēšam preci no groza
            $dzest = $_GET["dzest"]; //dzēšamās preces numurs grozā
            unset($_SESSION['grozs'][$dzest]);//izdzēšam preci ar numuru $dzest
            $grozs2 = array_values($_SESSION['grozs']); //sanumurējam pa jaunu masīva indeksus
            $_SESSION['grozs'] = $grozs2; //sanumurēto masīvu piešķiram grozam
    }

    if (isset($_GET["plus"])) {
        $numurs = $_GET["plus"];
        $_SESSION['grozs'][$numurs]['daudzums'] += 1;
    }

    if (isset($_GET["minus"])) {
        $numurs = $_GET["minus"];
        if ($_SESSION['grozs'][$numurs]['daudzums'] > 1) {
            $_SESSION['grozs'][$numurs]['daudzums'] -= 1;
        }
    }
    
    
    //ja grozs eksistē un ja grozs nav tukšs, tad drukājam groza saturu
    $grozs = $_SESSION["grozs"];
    $precu_skaits = count($grozs);

    echo "<a href='index.php?atvert=grozs&iztirit=true'><button class='btn btn-primary   align-self-end mt-auto' >Iztīrīt grozu</button></a> ";
    echo "<a href='index.php?atvert=grozs&pasutit=true'><button class='btn btn-primary   align-self-end mt-auto' >Pasūtīt preces</button></a><br><br>";

    $kopeja_summa = 0;

    for ($x = 0; $x < $precu_skaits; $x++) {
        $id = $grozs[$x]["id"];
        $preces_daudzums = $grozs[$x]["daudzums"];

        //noskaidrojam preces nosaukumu un cenu no datubāzes
        $sql = "SELECT nosaukums, cena FROM preces WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $nosaukums = $row["nosaukums"];
            $cena = $row["cena"];
        }
        
        echo "<a href='index.php?atvert=grozs&dzest=$x'><i class='bi-x-octagon-fill'></i></a> ";
        echo "<strong><a class='bez_apaksstripas' href='index.php?atvert=grozs&plus=$x'>";
        echo '<i class="bi bi-plus-square-fill"></i>';
        echo "</a></strong> ";
        echo "<strong><a class='bez_apaksstripas' href='index.php?atvert=grozs&minus=$x'>";
        echo '<i class="bi bi-dash-square-fill"></i>';
        echo "</a></strong> ";

        $npk = $x + 1; //preces numurs grozā
        $summa = $cena * $preces_daudzums;
        $kopeja_summa += $summa;
        echo "$npk. $nosaukums (kods $id), cena: $cena EUR, daudzums: $preces_daudzums, summa: $summa EUR<br>";
    }
    echo "<br><p>Pirkuma kopējā summa: $kopeja_summa EUR<p>";

  }//beidzas pretējais gadījums pasūtījuma veidošanai, t.i., kad tiek izdrukāts groza saturs
} else {
    //ja grozs neeksistē vai arī tas ir tukšs
    echo "Šobrīd grozs ir tukšs!";
}

?>