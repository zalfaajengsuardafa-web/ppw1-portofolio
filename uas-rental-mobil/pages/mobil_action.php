<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: mobil.php');
    exit;
}

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
$nopol = htmlspecialchars(trim($_POST['nopol'] ?? ''));
$merk = htmlspecialchars(trim($_POST['merk'] ?? ''));
$model = htmlspecialchars(trim($_POST['model'] ?? ''));
$tahun = (int)($_POST['tahun'] ?? 0);
$warna = htmlspecialchars(trim($_POST['warna'] ?? ''));
$harga_sewa = (float)($_POST['harga_sewa'] ?? 0);
$status = htmlspecialchars(trim($_POST['status'] ?? 'tersedia'));

// Validasi server-side
if (empty($nopol) || empty($merk) || empty($model) || $tahun < 2000 || empty($warna) || $harga_sewa <= 0) {
    $_SESSION['flash_message'] = 'Semua field wajib diisi dengan benar.';
    $_SESSION['flash_type'] = 'danger';
    header('Location: mobil.php');
    exit;
}

if ($action === 'create') {
    // CREATE - Prepared statement
    $stmt = mysqli_prepare($conn, "INSERT INTO mobil (nopol, merk, model, tahun, warna, harga_sewa, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssisds", $nopol, $merk, $model, $tahun, $warna, $harga_sewa, $status);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_message'] = 'Data mobil berhasil ditambahkan.';
        $_SESSION['flash_type'] = 'success';
    } else {
        $_SESSION['flash_message'] = 'Gagal menambahkan data mobil. ' . mysqli_error($conn);
        $_SESSION['flash_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);

} elseif ($action === 'update' && $id > 0) {
    // UPDATE - Prepared statement
    $stmt = mysqli_prepare($conn, "UPDATE mobil SET nopol=?, merk=?, model=?, tahun=?, warna=?, harga_sewa=?, status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssisdsi", $nopol, $merk, $model, $tahun, $warna, $harga_sewa, $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_message'] = 'Data mobil berhasil diperbarui.';
        $_SESSION['flash_type'] = 'success';
    } else {
        $_SESSION['flash_message'] = 'Gagal memperbarui data mobil. ' . mysqli_error($conn);
        $_SESSION['flash_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);

} else {
    $_SESSION['flash_message'] = 'Aksi tidak valid.';
    $_SESSION['flash_type'] = 'danger';
}

header('Location: mobil.php');
exit;
