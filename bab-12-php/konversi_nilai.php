<?php
require_once __DIR__ . '/../shared/php/grade_converter.php';

$hasil = "";
$warna = "";
if(isset($_POST['submit'])){
    $nilai = (int)$_POST['nilai'];
    $result = convertGrade($nilai);

    if (isset($result['error'])) {
        $hasil = $result['error'];
        $warna = "red";
    } else {
        $grade = $result['grade'];
        $deskripsi = $result['description'];
        $warna = $result['color'];
        $hasil = "Grade $grade - $deskripsi";
    }
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
