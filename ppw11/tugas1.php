<!DOCTYPE html>
<html>
<head>
    <title>Profil Mahasiswa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
        }

        th {
            background-color: #d9d9d9;
        }
    </style>
</head>
<body>

<?php
$nama = "Zalfa Ajeng Suardafa";
$nim = "25/568990/SV/27577";
$prodi = "Teknologi Rekayasa Perangkat Lunak";
$asal = "Yogyakarta";
?>

<h2>Profil Mahasiswa</h2>

<table>
    <tr>
        <th>Data</th>
        <th>Keterangan</th>
    </tr>

    <tr>
        <td>Nama</td>
        <td><?php echo $nama; ?></td>
    </tr>

    <tr>
        <td>NIM</td>
        <td><?php echo $nim; ?></td>
    </tr>

    <tr>
        <td>Program Studi</td>
        <td><?php echo $prodi; ?></td>
    </tr>

    <tr>
        <td>Asal Kota</td>
        <td><?php echo $asal; ?></td>
    </tr>
</table>

</body>
</html>