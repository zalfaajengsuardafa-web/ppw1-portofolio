<?php
include_once("config.php");

if (isLoggedIn()) { header('Location: index.php'); exit(); }

$errors = [];

if (isset($_POST['register'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if (empty($username)) $errors[] = 'Username tidak boleh kosong';
  if (empty($email)) $errors[] = 'Email tidak boleh kosong';
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid';
  if (empty($full_name)) $errors[] = 'Nama lengkap tidak boleh kosong';
  if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter';
  if ($password !== $confirm) $errors[] = 'Konfirmasi password tidak cocok';

  $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
  if (mysqli_num_rows($check) > 0)
    $errors[] = 'Username atau email sudah terdaftar';

  if (empty($errors)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, full_name, password)
            VALUES ('$username','$email','$full_name','$hashed')";
    if (mysqli_query($conn, $sql))
      $success = 'Registrasi berhasil! Silakan login.';
    else
      $errors[] = 'Error: ' . mysqli_error($conn);
  }
}
?>