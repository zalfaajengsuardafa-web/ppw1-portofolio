<!DOCTYPE html>
<html>
<head>
    <title>Bulan dan Sisa Hari</title>
</head>
<body>

<?php

$bulan = date("F");
$hariSekarang = date("d");
$totalHari = date("t");

$sisaHari = $totalHari - $hariSekarang;

?>

<h2>Informasi Bulan Saat Ini</h2>

<p>Bulan Sekarang : <?php echo $bulan; ?></p>
<p>Hari Ini Tanggal : <?php echo date("d-m-Y"); ?></p>
<p>Sisa Hari di Bulan Ini : <?php echo $sisaHari; ?> hari</p>

</body>
</html>