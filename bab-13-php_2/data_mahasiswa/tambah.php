<?php
require 'koneksi.php';

$prodi_list = [
    'Teknik Informatika',
    'Sistem Informasi',
    'Teknik Elektro',
    'Manajemen',
    'Akuntansi',
    'Hukum',
    'Kedokteran',
    'Psikologi',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim      = trim($_POST['nim']);
    $nama     = trim($_POST['nama']);
    $prodi    = trim($_POST['prodi']);
    $ipk      = trim($_POST['ipk']);
    $semester = trim($_POST['semester']);

    $stmt_check = mysqli_prepare($conn, "SELECT id FROM mahasiswa WHERE nim = ?");
    mysqli_stmt_bind_param($stmt_check, "s", $nim);
    mysqli_stmt_execute($stmt_check);
    $cek = mysqli_stmt_get_result($stmt_check);
    if (mysqli_num_rows($cek) > 0) {
        mysqli_stmt_close($stmt_check);
        header('Location: index.php?pesan=duplikat');
        exit;
    }
    mysqli_stmt_close($stmt_check);

    $stmt = mysqli_prepare($conn, "INSERT INTO mahasiswa (nim, nama, prodi, ipk, semester) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssds", $nim, $nama, $prodi, $ipk, $semester);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: index.php?pesan=tambah');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">

          <h5 class="fw-bold mb-1"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Mahasiswa</h5>
          <p class="text-muted small mb-4">Isi form di bawah untuk menambahkan data baru.</p>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label fw-semibold">NIM</label>
              <input type="text" name="nim" class="form-control" placeholder="Contoh: 22001" required/>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required/>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Program Studi</label>
              <select name="prodi" class="form-select" required>
                <option value="">-- Pilih Prodi --</option>
                <?php foreach ($prodi_list as $p): ?>
                  <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">IPK</label>
              <input type="number" name="ipk" class="form-control" placeholder="Contoh: 3.75" step="0.01" min="0" max="4" required/>
            </div>
            <div class="mb-4">
              <label class="form-label fw-semibold">Semester</label>
              <input type="number" name="semester" class="form-control" placeholder="Contoh: 4" min="1" max="14" required/>
            </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-save me-1"></i> Simpan
              </button>
              <a href="index.php" class="btn btn-outline-secondary flex-fill">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
