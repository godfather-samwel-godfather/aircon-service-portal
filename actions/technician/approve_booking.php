<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('technician');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../technician/dashboard.php?page=assigned_jobs');
}

$bookingId = (int) ($_POST['booking_id'] ?? 0);
if ($bookingId <= 0) {
    redirect('../../technician/dashboard.php?page=assigned_jobs&error=Invalid request');
}

$bookingRepo = new BookingRepository($conn);
$bookingRepo->updateStatus($bookingId, 'approved');

redirect('../../technician/dashboard.php?page=assigned_jobs&msg=Request approved');

