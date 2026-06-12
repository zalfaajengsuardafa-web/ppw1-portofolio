<?php
/**
 * Shared Database Connection Utility
 *
 * Usage:
 *   require_once __DIR__ . '/../../shared/php/db_connect.php';
 *   $conn = db_connect('localhost', 'root', '', 'my_database');
 */

function db_connect(
    string $host = 'localhost',
    string $user = 'root',
    string $pass = '',
    string $db = ''
): mysqli {
    $conn = mysqli_connect($host, $user, $pass, $db);

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    return $conn;
}
