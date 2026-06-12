<?php
include_once("config.php");

if (isLoggedIn()) { header('Location: index.php'); exit(); }

$errors = [];

if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $full_name = trim($_POST['full_name']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if (empty($username)) $errors[] = 'Username tidak boleh kosong';
  if (empty($email)) $errors[] = 'Email tidak boleh kosong';
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid';
  if (empty($full_name)) $errors[] = 'Nama lengkap tidak boleh kosong';
  if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter';
  if ($password !== $confirm) $errors[] = 'Konfirmasi password tidak cocok';

  $stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=?");
  mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
  mysqli_stmt_execute($stmt_check);
  $check = mysqli_stmt_get_result($stmt_check);
  if (mysqli_num_rows($check) > 0)
    $errors[] = 'Username atau email sudah terdaftar';
  mysqli_stmt_close($stmt_check);

  if (empty($errors)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt_ins = mysqli_prepare($conn, "INSERT INTO users (username, email, full_name, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt_ins, "ssss", $username, $email, $full_name, $hashed);
    if (mysqli_stmt_execute($stmt_ins))
      $success = 'Registrasi berhasil! Silakan login.';
    else
      $errors[] = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
    mysqli_stmt_close($stmt_ins);
  }
}
?>
