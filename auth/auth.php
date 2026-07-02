<?php
// auth.php - Common authentication checks for all protected pages (CALLED MIDDLEWARE)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

// LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php?error=Please login first");
    exit;
}

// ROLE VALIDATION
$valid_roles = [ 'admin', 'customer', 'technician'];

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $valid_roles)) {
    
    // SAFE LOGOUT (destroy everything)
    $_SESSION = [];
    session_unset();
    session_destroy();

    header("Location: ../auth/login.php?error=Invalid session");
    exit;
}
?>