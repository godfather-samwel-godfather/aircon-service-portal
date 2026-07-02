<?php
$bookingId = (int) ($_GET['booking_id'] ?? 0);
$techRepo = new TechnicianRepository($conn);
$bookingRepo = new BookingRepository($conn);
$serviceResultRepo = new ServiceResultRepository($conn);
$paymentRepo = new PaymentRepository($conn);

$tech = $techRepo->getByUserId(getCurrentUserId());
$booking = $bookingId > 0 ? $bookingRepo->getById($bookingId) : null;

if (!$tech || !$booking || (int) $booking['technician_id'] !== (int) $tech['id']) {
    echo '<div class="alert alert-danger">Booking not found or not assigned to you.</div>';
    return;
}

$serviceResult = $serviceResultRepo->getByBookingId($bookingId);
$payment = $paymentRepo->getByBookingId($bookingId);
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Booking Details</h1>
                <p class="mb-0">Review the customer booking and upload results when ready.</p>
            </div>
            <div class="text-md-end">
                <?php if (!$serviceResult && in_array($booking['status'], ['paid', 'approved', 'in_progress'], true)): ?>
                    <a href="dashboard.php?page=upload_results&booking_id=<?= e((string) $bookingId) ?>" class="btn btn-primary">Upload Results</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">Customer & Booking</h5>
            <p><strong>Customer:</strong> <?= e($booking['customer_name']) ?></p>
            <p><strong>AC Unit:</strong> <?= e($booking['ac_name'] ?: '-') ?></p>
            <p><strong>Date & Time:</strong> <?= e(formatDate($booking['preferred_date'])) ?> at <?= e(formatTime($booking['preferred_time'])) ?></p>
            <p><strong>Status:</strong> <span class="badge <?= statusBadge($booking['status']) ?>"><?= e(ucwords(str_replace('_', ' ', $booking['status']))) ?></span></p>
            <p><strong>Problem:</strong> <?= e($booking['problem_description']) ?></p>
            <p><strong>Service Items:</strong> <span class="badge bg-light text-dark"><?= e($bookingRepo->getServiceNames($bookingId)) ?></span></p>
            <p><strong>Payment:</strong> <?= e($payment['status'] ?? 'pending') ?></p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">Service Result</h5>
            <?php if ($serviceResult): ?>
                <p><strong>Technician:</strong> <?= e($serviceResult['technician_name']) ?></p>
                <p><strong>Work Report:</strong> <?= e($serviceResult['work_report']) ?></p>
                <p><strong>Parts Used:</strong> <?= e($serviceResult['parts_used'] ?: 'None') ?></p>
                <?php if (!empty($serviceResult['before_image'])): ?>
                    <p><strong>Before:</strong> <a href="../<?= e($serviceResult['before_image']) ?>" target="_blank">View</a></p>
                <?php endif; ?>
                <?php if (!empty($serviceResult['after_image'])): ?>
                    <p><strong>After:</strong> <a href="../<?= e($serviceResult['after_image']) ?>" target="_blank">View</a></p>
                <?php endif; ?>
                <?php if (!empty($serviceResult['signature_image'])): ?>
                    <p><strong>Signature:</strong> <a href="../<?= e($serviceResult['signature_image']) ?>" target="_blank">View</a></p>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">No results uploaded yet. Click Upload Results to record work done.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
