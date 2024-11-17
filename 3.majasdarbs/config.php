<?php
// URL uz attālo konfigurācijas failu
$config_url = "https://example.com/config.json"; //ievadi savu config.json faila atrašanās vietu

// Funkcija, lai iegūtu konfigurāciju
function getRemoteConfig($url) {
    $response = file_get_contents($url);
    if ($response === false) {
        die("Neizdevās nolasīt konfigurācijas datus.");
    }
    return json_decode($response, true);
}

// Nolasīt konfigurācijas datus
$config = getRemoteConfig($config_url);

// Izmanto konfigurāciju
$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

// Izveido savienojumu
$conn = new mysqli($servername, $username, $password, $dbname);

// Pārbauda savienojumu
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";
?>

<!-- 

Json faila piemērs:
{
  "servername": "remotehost",
  "username": "RemoteUsername",
  "password": "RemotePassword",
  "dbname": "RemoteDBName"
} 
  
  -->