<?php
$hasil = "";
$warna = "";
if(isset($_POST['submit'])){
    $nilai = $_POST['nilai'];
    if($nilai >= 85){
        $grade = "A";
        $deskripsi = "Sangat Baik";
        $warna = "green";
    } elseif($nilai >= 70){
        $grade = "B";
        $deskripsi = "Baik";
        $warna = "blue";
    } elseif($nilai >= 55){
        $grade = "C";
        $deskripsi = "Cukup";
        $warna = "orange";
    } elseif($nilai >= 40){
        $grade = "D";
        $deskripsi = "Kurang";
        $warna = "purple";
    } else {
        $grade = "E";
        $deskripsi = "Sangat Kurang";
        $warna = "red";
    }
    $hasil = "Grade $grade - $deskripsi";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konversi Nilai</title>
</head>

<body>

<h2>Form Konversi Nilai</h2>

<form method="POST">

    <input type="number" name="nilai" min="0" max="100" required>

    <button type="submit" name="submit">
        Konversi
    </button>

</form>

<h3 style="color: <?= $warna ?>;">
    <?= $hasil ?>
</h3>

</body>
</html>