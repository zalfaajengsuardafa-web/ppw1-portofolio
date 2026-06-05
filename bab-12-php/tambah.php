<?php
include 'koneksi.php';

if(isset($_POST['submit'])){

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "INSERT INTO mahasiswa VALUES(
        '',
        '$nama',
        '$nim',
        '$prodi',
        '$alamat'
    )");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Tambah Data Mahasiswa</h2>

<form method="POST">

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Prodi</label>
        <input type="text" name="prodi" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-success">
        Simpan
    </button>

</form>

</body>
</html>