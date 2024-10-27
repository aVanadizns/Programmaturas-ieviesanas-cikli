<?php
// Funkcija sveicienam
function sveiciens() {
    echo "Sveika, pasaule!<br>";
}

// Funkcija skaitļu summas aprēķināšanai
function summa($a, $b) {
    return $a + $b;
}

// Izsauc sveiciena funkciju
sveiciens();

// Aprēķina un izvada summu
$x = 5;
$y = 10;
echo "Skaitļu $x un $y summa ir: " . summa($x, $y);
?>

