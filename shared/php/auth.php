<?php
/**
 * Shared Authentication Utilities
 *
 * Provides session-based login helpers used across CRUD modules.
 *
 * Usage:
 *   require_once __DIR__ . '/../../shared/php/auth.php';
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function logout(): void
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
