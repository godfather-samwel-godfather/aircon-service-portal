<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('technician');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../technician/dashboard.php?page=assigned_jobs');
}

$bookingId = (int) ($_POST['booking_id'] ?? 0);
$reason = trim((string) ($_POST['reason'] ?? ''));

if ($bookingId <= 0 || $reason === '') {
    redirect('../../technician/dashboard.php?page=assigned_jobs&error=Rejection reason is required');
}

$bookingRepo = new BookingRepository($conn);
$bookingRepo->updateStatus($bookingId, 'rejected', $reason);

redirect('../../technician/dashboard.php?page=assigned_jobs&msg=Request rejected');

