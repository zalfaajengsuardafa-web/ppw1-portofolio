<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: transaksi.php');
    exit;
}

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
$id_mobil = (int)($_POST['id_mobil'] ?? 0);
$nama_penyewa = htmlspecialchars(trim($_POST['nama_penyewa'] ?? ''));
$no_ktp = htmlspecialchars(trim($_POST['no_ktp'] ?? ''));
$no_telp = htmlspecialchars(trim($_POST['no_telp'] ?? ''));
$tgl_sewa = $_POST['tgl_sewa'] ?? '';
$tgl_kembali = $_POST['tgl_kembali'] ?? '';
$total_biaya = (float)($_POST['total_biaya'] ?? 0);

// Validasi server-side
if ($id_mobil <= 0 || empty($nama_penyewa) || empty($no_ktp) || empty($no_telp) || empty($tgl_sewa) || empty($tgl_kembali)) {
    $_SESSION['flash_message'] = 'Semua field wajib diisi.';
    $_SESSION['flash_type'] = 'danger';
    header('Location: transaksi.php');
    exit;
}

// Hitung total biaya di server jika belum dihitung
if ($total_biaya <= 0) {
    $stmt = mysqli_prepare($conn, "SELECT harga_sewa FROM mobil WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_mobil);
    mysqli_stmt_execute($stmt);
    $mobil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($mobil) {
        $days = max(1, (strtotime($tgl_kembali) - strtotime($tgl_sewa)) / 86400);
        $total_biaya = $days * $mobil['harga_sewa'];
    }
}

if ($action === 'create') {
    // CREATE
    $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_mobil, nama_penyewa, no_ktp, no_telp, tgl_sewa, tgl_kembali, total_biaya, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')");
    mysqli_stmt_bind_param($stmt, "isssssd", $id_mobil, $nama_penyewa, $no_ktp, $no_telp, $tgl_sewa, $tgl_kembali, $total_biaya);

    if (mysqli_stmt_execute($stmt)) {
        // Update status mobil menjadi disewa
        $stmt2 = mysqli_prepare($conn, "UPDATE mobil SET status='disewa' WHERE id=?");
        mysqli_stmt_bind_param($stmt2, "i", $id_mobil);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        $_SESSION['flash_message'] = 'Transaksi berhasil ditambahkan.';
        $_SESSION['flash_type'] = 'success';
    } else {
        $_SESSION['flash_message'] = 'Gagal menambahkan transaksi. ' . mysqli_error($conn);
        $_SESSION['flash_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);

} elseif ($action === 'update' && $id > 0) {
    // UPDATE
    $stmt = mysqli_prepare($conn, "UPDATE transaksi SET id_mobil=?, nama_penyewa=?, no_ktp=?, no_telp=?, tgl_sewa=?, tgl_kembali=?, total_biaya=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "isssssdi", $id_mobil, $nama_penyewa, $no_ktp, $no_telp, $tgl_sewa, $tgl_kembali, $total_biaya, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_message'] = 'Transaksi berhasil diperbarui.';
        $_SESSION['flash_type'] = 'success';
    } else {
        $_SESSION['flash_message'] = 'Gagal memperbarui transaksi. ' . mysqli_error($conn);
        $_SESSION['flash_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);

} else {
    $_SESSION['flash_message'] = 'Aksi tidak valid.';
    $_SESSION['flash_type'] = 'danger';
}

header('Location: transaksi.php');
exit;
