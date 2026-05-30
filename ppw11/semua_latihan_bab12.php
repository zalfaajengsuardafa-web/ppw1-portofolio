<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bab 12 - Latihan PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 24px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 32px;
        }
        .latihan {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .latihan-header {
            background: #3498db;
            color: white;
            padding: 10px 18px;
            font-weight: bold;
            font-size: 15px;
        }
        .latihan-body {
            padding: 16px 18px;
            font-size: 15px;
            color: #2c3e50;
            border-left: 4px solid #3498db;
        }
        .latihan-body code {
            background: #f4f6f8;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h1>Bab 12 — Latihan PHP (1–18)</h1>

<?php

/* ============================================================
   LATIHAN 1 — Output dengan PHP
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 1 — Output dengan PHP</div>
        <div class="latihan-body">';

echo "Hello world";

echo '</div></div>';


/* ============================================================
   LATIHAN 2 — PHP dengan HTML
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 2 — PHP dengan HTML</div>
        <div class="latihan-body">';

echo "Hello world";

echo '</div></div>';


/* ============================================================
   LATIHAN 3 — Komentar pada PHP
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 3 — Komentar pada PHP</div>
        <div class="latihan-body">';

// This is a single-line comment
# This is also a single-line comment
/*
This is a multiple-lines comment block
that spans over multiple lines
*/
// You can also use comments to leave out parts of a code line
$x = 5 /* + 15 */ + 5;
echo "Hasil \$x = 5 /* + 15 */ + 5 → " . $x;

echo '</div></div>';


/* ============================================================
   LATIHAN 4 — PHP Case Sensitive
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 4 — PHP Case Sensitive</div>
        <div class="latihan-body">';

$color = "red";
echo "My car is "   . $color . "<br>";
// $COLOR dan $coLOR belum didefinisikan — PHP akan error jika dipanggil
// Contoh di modul menunjukkan bahwa variabel PHP bersifat case sensitive
echo "<em>Catatan: \$COLOR dan \$coLOR berbeda dari \$color (case sensitive)</em>";

echo '</div></div>';


/* ============================================================
   LATIHAN 5 — Deklarasi Variabel
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 5 — Deklarasi Variabel</div>
        <div class="latihan-body">';

$txt = "Hello world!";
$x   = 5;
$y   = 10.5;
echo "\$txt = $txt <br>";
echo "\$x   = $x <br>";
echo "\$y   = $y";

echo '</div></div>';


/* ============================================================
   LATIHAN 6 — Output Variabel 1 (interpolasi string)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 6 — Output Variabel 1</div>
        <div class="latihan-body">';

$txt = "PPW1";
echo "I love $txt!";

echo '</div></div>';


/* ============================================================
   LATIHAN 7 — Output Variabel 2 (concatenation)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 7 — Output Variabel 2</div>
        <div class="latihan-body">';

$txt = "PPW1";
echo "I love " . $txt . "!";

echo '</div></div>';


/* ============================================================
   LATIHAN 8 — Output Variabel 3 (operasi aritmatika)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 8 — Output Variabel 3 (Aritmatika)</div>
        <div class="latihan-body">';

$x = 5;
$y = 4;
echo $x + $y;

echo '</div></div>';


/* ============================================================
   LATIHAN 9 — Mengetahui panjang string (strlen)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 9 — Panjang String (strlen)</div>
        <div class="latihan-body">';

echo strlen("Hello world!"); // outputs 12

echo '</div></div>';


/* ============================================================
   LATIHAN 10 — Menghitung jumlah kata (str_word_count)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 10 — Jumlah Kata (str_word_count)</div>
        <div class="latihan-body">';

echo str_word_count("Hello world!"); // outputs 2

echo '</div></div>';


/* ============================================================
   LATIHAN 11 — Membalik String (strrev)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 11 — Membalik String (strrev)</div>
        <div class="latihan-body">';

echo strrev("Hello world!"); // outputs !dlrow olleH

echo '</div></div>';


/* ============================================================
   LATIHAN 12 — Pencarian dalam string (strpos)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 12 — Pencarian dalam String (strpos)</div>
        <div class="latihan-body">';

echo strpos("Hello world!", "world"); // outputs 6

echo '</div></div>';


/* ============================================================
   LATIHAN 13 — Mengganti Text (str_replace)
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 13 — Mengganti Text (str_replace)</div>
        <div class="latihan-body">';

echo str_replace("world", "Dolly", "Hello world!"); // outputs Hello Dolly!

echo '</div></div>';


/* ============================================================
   LATIHAN 14 — Fungsi dasar
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 14 — Fungsi Dasar</div>
        <div class="latihan-body">';

function writeMsg() {
    echo "Hello world!";
}
writeMsg(); // call the function

echo '</div></div>';


/* ============================================================
   LATIHAN 15 — Fungsi dengan satu argument
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 15 — Fungsi dengan Argument</div>
        <div class="latihan-body">';

function familyName($fname) {
    echo "$fname Jaeger.<br>";
}
familyName("Jani");
familyName("Hege");
familyName("Stale");
familyName("Kai Jim");
familyName("Borge");

echo '</div></div>';


/* ============================================================
   LATIHAN 16 — Fungsi dengan dua argument
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 16 — Fungsi dengan 2 Argument</div>
        <div class="latihan-body">';

function familyName2($fname, $year) {
    echo "$fname Jaeger. Born in $year <br>";
}
familyName2("Hege",    "1975");
familyName2("Stale",   "1978");
familyName2("Kai Jim", "1983");

echo '</div></div>';


/* ============================================================
   LATIHAN 17 — Fungsi dengan nilai default argument
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 17 — Fungsi dengan Nilai Default</div>
        <div class="latihan-body">';

function setHeight($minheight = 50) {
    echo "The height is : $minheight <br>";
}
setHeight(350);
setHeight();    // will use the default value of 50
setHeight(135);
setHeight(80);

echo '</div></div>';


/* ============================================================
   LATIHAN 18 — Fungsi dengan return value
   ============================================================ */
echo '<div class="latihan">
        <div class="latihan-header">Latihan 18 — Fungsi dengan Return Value</div>
        <div class="latihan-body">';

function sum($x, $y) {
    $z = $x + $y;
    return $z;
}
echo "5 + 10 = " . sum(5, 10) . "<br>";
echo "7 + 13 = " . sum(7, 13) . "<br>";
echo "2 + 4 = "  . sum(2, 4);

echo '</div></div>';

?>

</body>
</html>
