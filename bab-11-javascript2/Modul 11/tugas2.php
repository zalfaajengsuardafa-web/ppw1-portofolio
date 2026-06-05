<!DOCTYPE html>
<html>
<head>
    <title>Perhitungan IMT</title>
</head>
<body>

<?php

function hitungIMT($berat, $tinggi) {

    $imt = $berat / ($tinggi * $tinggi);

    if ($imt < 18.5) {
        $kategori = "Kurus";
    } elseif ($imt < 25) {
        $kategori = "Normal";
    } elseif ($imt < 30) {
        $kategori = "Gemuk";
    } else {
        $kategori = "Obesitas";
    }

    return array($imt, $kategori);
}

$berat = 55;
$tinggi = 1.60;

$hasil = hitungIMT($berat, $tinggi);

?>

<h2>Hasil Perhitungan IMT</h2>

<p>Berat Badan : <?php echo $berat; ?> kg</p>
<p>Tinggi Badan : <?php echo $tinggi; ?> m</p>
<p>Nilai IMT : <?php echo round($hasil[0], 2); ?></p>
<p>Kategori : <?php echo $hasil[1]; ?></p>

</body>
</html>