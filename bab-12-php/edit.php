<?php
include 'koneksi.php';

$id = $_GET['id'];

// Mengambil data berdasarkan ID
$data = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['submit'])){
    $nama   = $_POST['nama'];
    $nim    = $_POST['nim'];
    $prodi  = $_POST['prodi'];
    $alamat = $_POST['alamat'];

    // Perbaikan sintaks variabel di dalam query
    mysqli_query($conn, "UPDATE mahasiswa SET 
        nama='$nama', 
        nim='$nim', 
        prodi='$prodi', 
        alamat='$alamat' 
        WHERE id='$id'"
    );

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Mahasiswa</title>
    <!-- Tambahkan Bootstrap agar seragam -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Edit Data Mahasiswa</h2>

<form method="POST">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $d['nama']; ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>NIM</label>
        <input type="text" name="nim" value="<?= $d['nim']; ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Prodi</label>
        <input type="text" name="prodi" value="<?= $d['prodi']; ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required><?= $d['alamat']; ?></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-warning">Update</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

</body>
</html>