<?php
session_start();
require_once __DIR__ . '/includes/config.php';

// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}

// Redirect to login
header('Location: pages/login.php');
exit;
