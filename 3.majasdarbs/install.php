<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS lapas (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nosaukums VARCHAR(100) NOT NULL,
    taka VARCHAR(120) NOT NULL,
    saturs TEXT,
    laiks TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula lapas veiksmīgi izveidota!</p>";
} else {
    echo "<p>Kļūda veidojot tabulu lapas: " . $conn->error . "</p>";
}
   
//veidojam tabulu lietotaji
// izveidojam tabulu lietotaji
$sql = "CREATE TABLE IF NOT EXISTS lietotaji (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    e_pasts VARCHAR(150) NOT NULL,
    parole VARCHAR(255) NOT NULL,
    segvards VARCHAR(50),
    loma VARCHAR(10),
    foto VARCHAR(255),
    apraksts TEXT,
    registracijas_laiks TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "<p>Tabula lietotaji veiksmīgi izveidota!</p>";
    } else {
      echo "<p>Kļūda veidojot tabulu lietotaji: " . $conn->error. "</p>";
    }

// izveidojam tabulu preces
$sql = "CREATE TABLE IF NOT EXISTS preces (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nosaukums VARCHAR(255) NOT NULL,
  cena DECIMAL(6,2) NOT NULL,
  foto VARCHAR(255),
  apraksts TEXT,
  kategorijas_id int(11) NOT NULL,
  noliktava int(5)
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula preces veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu preces: " . $conn->error. "</p>";
  }

// izveidojam tabulu kategorijas
$sql = "CREATE TABLE IF NOT EXISTS kategorijas (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nosaukums VARCHAR(30) NOT NULL
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula kategorijas veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu kategorijas: " . $conn->error. "</p>";
  }

  // izveidojam tabulu pasutijumi
$sql = "CREATE TABLE IF NOT EXISTS pasutijumi (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  lietotaja_id INT(11) NOT NULL,
  laiks TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  statuss VARCHAR(30)
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula pasutijumi veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu pasutijumi: " . $conn->error. "</p>";
  }

// izveidojam tabulu pasutijuma_preces
$sql = "CREATE TABLE IF NOT EXISTS pasutijuma_preces (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pasutijuma_id INT(11) NOT NULL,
  preces_id INT(11) NOT NULL,
  daudzums INT(6) NOT NULL
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula pasutijuma_preces veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu pasutijuma_preces: " . $conn->error. "</p>";
  }
?>