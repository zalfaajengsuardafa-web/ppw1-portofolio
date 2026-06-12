<?php
include 'koneksi.php';

if(isset($_POST['submit'])){

    $nama = trim($_POST['nama']);
    $nim = trim($_POST['nim']);
    $prodi = trim($_POST['prodi']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare($conn, "INSERT INTO mahasiswa (nama, nim, prodi, alamat) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $nama, $nim, $prodi, $alamat);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:index.php");
    exit;
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
