<?php
include_once("config.php");

if (isLoggedIn()) { header('Location: index.php'); exit(); }

if (isset($_POST['login'])) {
  $input_user = $_POST['username'];

  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? OR email = ?");
  mysqli_stmt_bind_param($stmt, "ss", $input_user, $input_user);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($_POST['password'], $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['full_name'] = $user['full_name'];
      header('Location: index.php');
      exit();
    } else {
      $error = "Username atau password salah!";
    }
  } else {
    $error = "Username atau password salah!";
  }
  mysqli_stmt_close($stmt);
}
?>
