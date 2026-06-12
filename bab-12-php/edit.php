<?php
include 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?pesan=error&detail=ID+tidak+valid");
    exit;
}

$id = (int) $_GET['id'];

// Mengambil data berdasarkan ID
$data = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$id'");

if (!$data || mysqli_num_rows($data) === 0) {
    header("Location: index.php?pesan=error&detail=Data+tidak+ditemukan");
    exit;
}

$d = mysqli_fetch_array($data);

if(isset($_POST['submit'])){
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $nim    = mysqli_real_escape_string($conn, $_POST['nim']);
    $prodi  = mysqli_real_escape_string($conn, $_POST['prodi']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $result = mysqli_query($conn, "UPDATE mahasiswa SET 
        nama='$nama', 
        nim='$nim', 
        prodi='$prodi', 
        alamat='$alamat' 
        WHERE id='$id'"
    );

    if (!$result) {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    } else {
        header("Location: index.php?pesan=edit");
        exit;
    }
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

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

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