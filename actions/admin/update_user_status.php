<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../admin/dashboard.php?page=users');
}

$userId = (int) ($_POST['user_id'] ?? 0);
$status = (string) ($_POST['status'] ?? '');
$allowed = ['active', 'inactive', 'blocked', 'pending'];

if ($userId <= 0 || !in_array($status, $allowed, true)) {
    redirect('../../admin/dashboard.php?page=users&error=Invalid request');
}

$userRepo = new UserRepository($conn);
$techRepo = new TechnicianRepository($conn);

$ok = $userRepo->updateStatus($userId, $status);

$user = $userRepo->getById($userId);
if ($ok && $user && $user['role'] === 'technician') {
    if ($status === 'active') {
        $techRepo->setVerificationByUser($userId, 'approved');
    } elseif ($status === 'blocked' || $status === 'inactive') {
        $techRepo->setVerificationByUser($userId, 'rejected');
    } else {
        $techRepo->setVerificationByUser($userId, 'pending');
    }
}

redirect('../../admin/dashboard.php?page=users&msg=User status updated');

