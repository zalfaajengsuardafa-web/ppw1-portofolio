<?php
function bersihkan($input): string {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

$errors = [];
$sukses = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama  = bersihkan($_POST['nama'] ?? '');
  $email = bersihkan($_POST['email'] ?? '');
  $umur  = (int) ($_POST['umur'] ?? 0);

  if (empty($nama)) {
    $errors[] = "Nama tidak boleh kosong.";
  } elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal 3 karakter.";
  }

  if (empty($email)) {
    $errors[] = "Email tidak boleh kosong.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
  }

  if ($umur < 17 || $umur > 100) {
    $errors[] = "Umur harus antara 17 dan 100.";
  }

  if (empty($errors)) {
    $sukses = true;
  }
}
?>