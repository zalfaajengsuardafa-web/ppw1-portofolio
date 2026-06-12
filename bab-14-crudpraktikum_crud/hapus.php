<?php
include_once("config.php");
requireLogin();

// Cek apakah ada ID yang dikirimkan
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID tidak valid.";
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Ambil data foto sebelum menghapus
$result = mysqli_query($conn, "SELECT foto FROM mahasiswa WHERE id=$id");

if(!$result) {
    $_SESSION['error'] = "Terjadi kesalahan saat mengambil data: " . mysqli_error($conn);
    header("Location: index.php");
    exit();
}

if(mysqli_num_rows($result) === 0) {
    $_SESSION['error'] = "Data tidak ditemukan.";
    header("Location: index.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
$foto = $row['foto'];

// Hapus data dari database
$delete_query = "DELETE FROM mahasiswa WHERE id=$id";
if(mysqli_query($conn, $delete_query)) {
    // Hapus file foto jika ada
    if($foto) {
        deleteFile($foto);
    }
    $_SESSION['message'] = "Data berhasil dihapus!";
} else {
    $_SESSION['error'] = "Error: " . mysqli_error($conn);
}

// Redirect kembali ke halaman utama
header("Location: index.php");
exit();
?>