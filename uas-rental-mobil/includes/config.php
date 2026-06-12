<?php
// ============================================
// Konfigurasi Database - Sistem Rental Mobil
// ============================================

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rental_mobil';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// Konfigurasi Aplikasi
define('APP_NAME', 'Rental Mobil');
define('APP_VERSION', '1.0');
define('BASE_URL', 'http://localhost/ppw1-portofolio/uas-rental-mobil/');
define('ITEMS_PER_PAGE', 5);
