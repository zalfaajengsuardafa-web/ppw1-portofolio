<?php
require 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php?pesan=error&detail=' . urlencode('ID tidak valid'));
    exit;
}

$result = mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

if (!$result) {
    header('Location: index.php?pesan=error&detail=' . urlencode('Gagal menghapus: ' . mysqli_error($conn)));
    exit;
}

if (mysqli_affected_rows($conn) === 0) {
    header('Location: index.php?pesan=error&detail=' . urlencode('Data tidak ditemukan'));
    exit;
}

header('Location: index.php?pesan=hapus');
exit;
