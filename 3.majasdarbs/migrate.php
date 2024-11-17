<?php

include 'config.php';

// Savienojuma izveide
$conn = new mysqli($servername, $username, $password, $dbname);

// Pārbauda savienojumu
if ($conn->connect_error) {
    die("Savienojums neizdevās: " . $conn->connect_error);
}

// Faila nosaukums
$filename = "database_export.sql";

// Atveram failu rakstīšanai
$file = fopen($filename, "w");

// Iegūstam visu tabulu nosaukumus
$tablesResult = $conn->query("SHOW TABLES");
if (!$tablesResult) {
    die("Kļūda, iegūstot tabulas: " . $conn->error);
}

// Iterējam caur tabulām
while ($row = $tablesResult->fetch_row()) {
    $table = $row[0];

    // Iegūstam tabulas struktūru
    $createTableResult = $conn->query("SHOW CREATE TABLE `$table`");
    $createTableRow = $createTableResult->fetch_assoc();
    $createTableSQL = $createTableRow['Create Table'] . ";\n\n";

    // Rakstām struktūru failā
    fwrite($file, "-- Struktūra tabulai `$table`\n");
    fwrite($file, $createTableSQL);

    // Iegūstam visus ierakstus no tabulas
    $dataResult = $conn->query("SELECT * FROM `$table`");
    if ($dataResult->num_rows > 0) {
        fwrite($file, "-- Dati tabulai `$table`\n");
        while ($data = $dataResult->fetch_assoc()) {
            // Izveidojam INSERT vaicājumu
            $columns = array_keys($data);
            $values = array_map(function ($value) use ($conn) {
                return $value === null ? "NULL" : "'" . $conn->real_escape_string($value) . "'";
            }, array_values($data));

            $insertSQL = sprintf(
                "INSERT INTO `%s` (`%s`) VALUES (%s);\n",
                $table,
                implode("`, `", $columns),
                implode(", ", $values)
            );

            // Rakstām INSERT vaicājumu failā
            fwrite($file, $insertSQL);
        }
    }
    fwrite($file, "\n");
}

// Aizveram failu
fclose($file);

// Pabeidzam procesu
echo "Eksports pabeigts. SQL fails saglabāts kā `$filename`.";

// Aizveram savienojumu
$conn->close();
?>
