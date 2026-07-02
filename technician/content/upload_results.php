<?php
$bookingId = (int) ($_GET['booking_id'] ?? 0);
$techRepo = new TechnicianRepository($conn);
$bookingRepo = new BookingRepository($conn);
$serviceResultRepo = new ServiceResultRepository($conn);

$tech = $techRepo->getByUserId(getCurrentUserId());
$booking = $bookingId > 0 ? $bookingRepo->getById($bookingId) : null;

if (!$tech || !$booking || (int) $booking['technician_id'] !== (int) $tech['id']) {
    echo '<div class="alert alert-danger">Booking not found or not assigned to you.</div>';
    return;
}

if ($serviceResultRepo->existsForBooking($bookingId)) {
    echo '<div class="alert alert-warning">Results are already uploaded for this booking. <a href="dashboard.php?page=view_booking_details&booking_id=' . e((string) $bookingId) . '">View details</a>.</div>';
    return;
}
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Upload Service Results</h1>
                <p class="mb-0">Submit before/after photos, work report, parts used, and signature.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Technician Dashboard</span>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="card border-0 shadow-sm p-4">
    <form method="POST" action="../actions/technician/upload_results_process.php" enctype="multipart/form-data">
        <input type="hidden" name="booking_id" value="<?= e((string) $bookingId) ?>">
        <div class="mb-3">
            <label class="form-label small text-muted">Booking ID</label>
            <input type="text" class="form-control" value="<?= e((string) $bookingId) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label small text-muted">Before Image</label>
            <input type="file" name="before_image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label small text-muted">After Image</label>
            <input type="file" name="after_image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label small text-muted">Work Report / Remarks</label>
            <textarea name="work_report" class="form-control" rows="5" required placeholder="Describe the completed work..."></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label small text-muted">Parts Used</label>
            <textarea name="parts_used" class="form-control" rows="3" placeholder="List replacement parts or materials used..."></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label small text-muted">Signature Image</label>
            <input type="file" name="signature_image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary w-100">Upload Results</button>
    </form>
</div>
</div>
