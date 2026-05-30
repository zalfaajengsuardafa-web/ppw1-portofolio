<?php
// $_GET — data dari URL query string
echo $_GET['nama'] ?? 'Tamu';

// $_POST — data dari form method POST
echo $_POST['email'] ?? '';

// $_SERVER — informasi server dan request
echo $_SERVER['REQUEST_METHOD'];
echo $_SERVER['PHP_SELF'];
echo $_SERVER['HTTP_USER_AGENT'];
echo $_SERVER['REMOTE_ADDR'];

// $_SESSION
session_start();
$_SESSION['user_id'] = 42;
echo $_SESSION['user_id'];
session_destroy();

// $_COOKIE
setcookie("theme", "dark", time() + (7 * 24 * 3600));
echo $_COOKIE['theme'] ?? 'light';
?>