<?php
include_once("config.php");
requireLogin();

// Hanya terima request POST untuk aksi hapus (mencegah CSRF via GET)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
    $_SESSION['error'] = "Sesi tidak valid. Silakan coba lagi.";
    header("Location: index.php");
    exit();
}

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Ambil data foto sebelum menghapus (prepared statement)
    $stmt = mysqli_prepare($conn, "SELECT foto FROM mahasiswa WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];

        // Hapus data dari database (prepared statement)
        $stmt_del = mysqli_prepare($conn, "DELETE FROM mahasiswa WHERE id=?");
        mysqli_stmt_bind_param($stmt_del, "i", $id);
        if (mysqli_stmt_execute($stmt_del)) {
            if ($foto) {
                deleteFile($foto);
            }
            $_SESSION['message'] = "Data berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat menghapus data.";
        }
        mysqli_stmt_close($stmt_del);
    }
    mysqli_stmt_close($stmt);
}

// Redirect kembali ke halaman utama
header("Location: index.php");
exit();
?>
