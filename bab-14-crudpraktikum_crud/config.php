<?php
session_start();

// Konfigurasi database — baca dari environment variable, jangan hardcode kredensial
$host     = getenv('DB_HOST')     ?: "localhost";
$username = getenv('DB_USERNAME') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$database = getenv('DB_DATABASE') ?: "db_praktikum_crud";

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);
// Cek koneksi
if (!$conn) {
    die("Koneksi gagal. Silakan hubungi administrator.");
}

// Fungsi untuk generate CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fungsi untuk validasi CSRF token
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fungsi untuk cek login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
// Fungsi untuk redirect jika belum login
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
// Fungsi untuk upload file
function uploadFile($file, $target_dir = "uploads/mahasiswa/") {
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            return ['success' => false, 'message' => 'File bukan gambar.'];
        }
    }
    if ($file["size"] > 5000000) {
        return ['success' => false, 'message' => 'File terlalu besar. Maksimal 5MB.'];
    }
    $allowed = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowed)) {
        return ['success' => false, 'message' => 'Hanya format JPG, JPEG, PNG & GIF yang diizinkan.'];
    }
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file  = $target_dir . $new_filename;
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Error saat upload file.'];
    }
}
// Fungsi untuk hapus file
function deleteFile($filename, $dir = "uploads/mahasiswa/") {
    if ($filename && file_exists($dir . $filename)) {
        unlink($dir . $filename);
    }
}
?>

