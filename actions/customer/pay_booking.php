<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('customer');

$bookingId = (int) ($_GET['id'] ?? 0);
if ($bookingId <= 0) {
    redirect('../../customer/dashboard.php?page=view_appointments&error=Invalid booking');
}

$paymentRepo = new PaymentRepository($conn);
$bookingRepo = new BookingRepository($conn);

$payment = $paymentRepo->getByBookingId($bookingId);
if (!$payment) {
    redirect('../../customer/dashboard.php?page=view_appointments&error=Payment record not found');
}

$paymentRepo->markPaid($bookingId);
$bookingRepo->updateStatus($bookingId, 'paid');

redirect('../../customer/dashboard.php?page=view_appointments&msg=Payment successful, request sent to technician');

