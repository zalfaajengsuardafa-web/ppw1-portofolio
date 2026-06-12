<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Mengambil data berdasarkan ID (prepared statement)
$stmt = mysqli_prepare($conn, "SELECT * FROM mahasiswa WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_array($data);
mysqli_stmt_close($stmt);

if (!$d) {
    header("Location:index.php");
    exit;
}

if(isset($_POST['submit'])){
    $nama   = trim($_POST['nama']);
    $nim    = trim($_POST['nim']);
    $prodi  = trim($_POST['prodi']);
    $alamat = trim($_POST['alamat']);

    $stmt_upd = mysqli_prepare($conn, "UPDATE mahasiswa SET nama=?, nim=?, prodi=?, alamat=? WHERE id=?");
    mysqli_stmt_bind_param($stmt_upd, "ssssi", $nama, $nim, $prodi, $alamat, $id);
    mysqli_stmt_execute($stmt_upd);
    mysqli_stmt_close($stmt_upd);

    header("Location:index.php");
    exit;
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
        <input type="text" name="nama" value="<?= htmlspecialchars($d['nama']); ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>NIM</label>
        <input type="text" name="nim" value="<?= htmlspecialchars($d['nim']); ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Prodi</label>
        <input type="text" name="prodi" value="<?= htmlspecialchars($d['prodi']); ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required><?= htmlspecialchars($d['alamat']); ?></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-warning">Update</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

</body>
</html>
