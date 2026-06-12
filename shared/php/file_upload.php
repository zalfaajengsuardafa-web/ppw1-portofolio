<?php
/**
 * Shared File Upload & Delete Utilities
 *
 * Usage:
 *   require_once __DIR__ . '/../../shared/php/file_upload.php';
 *   $result = uploadFile($_FILES['foto'], 'uploads/mahasiswa/');
 *   deleteFile($filename, 'uploads/mahasiswa/');
 */

function uploadFile(array $file, string $target_dir = "uploads/mahasiswa/"): array
{
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    // Validate image
    if (!empty($file["tmp_name"])) {
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ['success' => false, 'message' => 'File bukan gambar.'];
        }
    }

    // Check file size (max 5MB)
    if ($file["size"] > 5000000) {
        return ['success' => false, 'message' => 'File terlalu besar. Maksimal 5MB.'];
    }

    // Check allowed extensions
    $allowed = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed)) {
        return ['success' => false, 'message' => 'Hanya format JPG, JPEG, PNG & GIF yang diizinkan.'];
    }

    // Generate unique filename and move file
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file  = $target_dir . $new_filename;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ['success' => true, 'filename' => $new_filename];
    }

    return ['success' => false, 'message' => 'Gagal upload file.'];
}

function deleteFile(string $filename, string $dir = "uploads/mahasiswa/"): void
{
    if ($filename && file_exists($dir . $filename)) {
        unlink($dir . $filename);
    }
}
