<?php
// $_GET — data dari URL query string
echo htmlspecialchars($_GET['nama'] ?? 'Tamu');

// $_POST — data dari form method POST
echo htmlspecialchars($_POST['email'] ?? '');

// $_SERVER — informasi server dan request
echo htmlspecialchars($_SERVER['REQUEST_METHOD']);
echo htmlspecialchars($_SERVER['PHP_SELF']);
echo htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
echo htmlspecialchars($_SERVER['REMOTE_ADDR']);

// $_SESSION
session_start();
$_SESSION['user_id'] = 42;
echo $_SESSION['user_id'];
session_destroy();

// $_COOKIE
setcookie("theme", "dark", time() + (7 * 24 * 3600));
echo htmlspecialchars($_COOKIE['theme'] ?? 'light');
?>
