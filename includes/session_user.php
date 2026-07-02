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
 */
function requireLogin(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!getCurrentUserId()) {
        redirect('../auth/login.php?error=Please login first');
    }
}