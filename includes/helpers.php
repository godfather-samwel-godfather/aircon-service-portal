<?php
/**
 * Shared helper functions — tumia popote mfumoni (DRY).
 */

/** Escape output for safe HTML display */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Redirect and stop script */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/** Format date for tables */
function formatDate(?string $date): string
{
    if (!$date) {
        return '-';
    }
    return date('d M Y', strtotime($date));
}

/** Format time for tables */
function formatTime(?string $time): string
{
    if (!$time) {
        return '-';
    }
    return date('g:i A', strtotime($time));
}

/** Active class for sidebar links */
function sidebarActive(string $page, string $current): string
{
    return ($page === $current) ? 'bg-primary shadow-sm' : '';
}

/** Bootstrap badge class by appointment/user status */
function statusBadge(string $status): string
{
    $map = [
        'pending'   => 'bg-warning text-dark',
        'pending_payment' => 'bg-warning text-dark',
        'paid'      => 'bg-info text-dark',
        'in_progress' => 'bg-info text-dark',
        'approved'  => 'bg-primary',
        'rejected'  => 'bg-danger',
        'completed' => 'bg-success',
        'cancelled' => 'bg-secondary',
        'new' => 'bg-warning text-dark',
        'resolved' => 'bg-success',
        'closed' => 'bg-secondary',
        'active'    => 'bg-success',
        'inactive'  => 'bg-secondary',
        'blocked'   => 'bg-danger',
        'uploaded'  => 'bg-info',
        'reviewed'  => 'bg-success',
    ];

    return $map[$status] ?? 'bg-secondary';
}

/** Show flash message from ?msg= or ?error= */
function flashMessage(): void
{
    if (!empty($_GET['msg'])) {
        echo '<div class="alert alert-success alert-dismissible fade show py-2 small">';
        echo '<i class="bi bi-check-circle me-1"></i>' . e($_GET['msg']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }

    if (!empty($_GET['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show py-2 small">';
        echo '<i class="bi bi-exclamation-circle me-1"></i>' . e($_GET['error']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }  
}

/** Set flash message in session */
function setFlash(string $type, string $message): void
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($type === 'success') {
        $_SESSION['success'] = $message;
    } elseif ($type === 'error') {
        $_SESSION['error'] = $message;
    } elseif ($type === 'errors') {
        $_SESSION['errors'] = is_array($message) ? $message : [$message];
    }
}

/** Redirect to URL */
function redirectTo(string $url): void
{
    redirect($url);
}

/** Require user to be logged in */
function requireLogin(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . __DIR__ . '/../auth/login.php');
        exit;
    }
}