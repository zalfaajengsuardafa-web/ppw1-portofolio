<?php
include 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?pesan=error&detail=ID+tidak+valid");
    exit;
}

$id = (int) $_GET['id'];

$result = mysqli_query($conn, "DELETE FROM mahasiswa WHERE id='$id'");

if (!$result) {
    header("Location: index.php?pesan=error&detail=" . urlencode(mysqli_error($conn)));
    exit;
}

if (mysqli_affected_rows($conn) === 0) {
    header("Location: index.php?pesan=error&detail=Data+tidak+ditemukan");
    exit;
}

header("Location: index.php?pesan=hapus");
exit;
?>