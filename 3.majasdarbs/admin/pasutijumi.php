<h2>Pasūtījumi</h2>
<?php
if (!isset($_GET["id"])) {
//======== DRUKĀJAM VISUS PASŪTĪJUMUS ========
$sql = "SELECT pasutijumi.id, pasutijumi.laiks, pasutijumi.statuss, lietotaji.e_pasts FROM pasutijumi INNER JOIN lietotaji ON pasutijumi.lietotaja_id = lietotaji.id";
//echo $sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<a href='index.php?atvert=pasutijumi&id=$row[id]'>$row[id]. $row[laiks] ($row[statuss]) $row[e_pasts]</a><br>";
    }
}
//======== BEIDZAM DRUKĀT VISUS PASŪTĪJUMUS ========
} else { //ja saitē ir pasūtījuma id
//============ ATVĒRT VIENU PASŪTĪJUMU ========

$id = $_GET["id"]; //drukājamā pasūtījuma id

$sql = "SELECT pasutijumi.id, pasutijumi.laiks, pasutijumi.statuss, lietotaji.e_pasts FROM pasutijumi INNER JOIN lietotaji ON pasutijumi.lietotaja_id = lietotaji.id WHERE pasutijumi.id=$id";
//echo $sql;
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    echo "<h4>Detaļas par pasūtījumu</h4>";
    echo "Pasūtījuma numurs (id): $row[id]<br>";
    echo "Pasūtījuma laiks: $row[laiks]<br>";
    echo "Pasūtītāja e-pasts: $row[e_pasts]<br>";
    echo "Pasūtījuma statuss: $row[statuss]<br>";
}
    echo "<br><h4>Pasūtītās preces:</h4>";
    $sql = "SELECT pasutijuma_preces.preces_id, pasutijuma_preces.daudzums, preces.nosaukums FROM pasutijuma_preces INNER JOIN preces ON pasutijuma_preces.preces_id = preces.id WHERE pasutijuma_preces.pasutijuma_id=$id";
    //echo $sql;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "$row[preces_id]. $row[nosaukums] ($row[daudzums] gab.)<br>";
        }
    }

//============beidzas pasūtījuma atvēršana ==========
}
?>