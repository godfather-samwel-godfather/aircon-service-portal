<?php
/**
 * Session helpers — user aliyeingia na role check.
 */

/** Current logged-in user id */
function getCurrentUserId(): int
{
    return (int) ($_SESSION['user_id'] ?? 0);
}

/** Current user role */
function getCurrentRole(): string
{
    return (string) ($_SESSION['role'] ?? '');
}

/**
 * Block access if role si sahihi (tumia kwenye action files).
 */
function requireRole(string $role): void
{
    if (getCurrentRole() !== $role) {
        redirect('../auth/unauthorized.php');
    }
}

/**
 * Start session + login check kwa action files.
 *//**
 * Start session + login check kwa action files.
 * Tunatumia function_exists kuzuia kosa la "Cannot redeclare" 
 * endapo faili hili litaingizwa mara nyingi.
 */
if (!function_exists('requireLogin')) {
    function requireLogin(): void
    {
        // Angalia kama session haijaanza kabla ya kuanzisha
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Angalia kama mtumiaji hajaingia
        if (!getCurrentUserId()) {
            // Hakikisha njia (path) ya kuelekea login.php ni sahihi kulingana na muundo wa folder zako
            header('Location: ../auth/login.php?error=Please login first');
            exit(); // Muhimu: Acha script iendelee baada ya redirect
        }
    }
}