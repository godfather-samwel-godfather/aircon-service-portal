<?php
$techRepo = new TechnicianRepository($conn);
$bookingRepo = new BookingRepository($conn);
$paymentRepo = new PaymentRepository($conn);

$tech = $techRepo->getByUserId(getCurrentUserId());
$requests = $tech ? $bookingRepo->getByTechnicianAndStatuses((int) $tech['id'], ['paid', 'approved', 'in_progress']) : [];
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3"><i class="bi bi-clipboard2-check me-2"></i>Customer Requests</h1>
                <p class="mb-0">Handle assigned customer work orders with quick actions.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Technician Dashboard</span>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

    <?php if (!$tech): ?>
    <div class="alert alert-warning">No technician profile linked to your account.</div>
<?php else: ?>
    <div class="card p-4 shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table table-striped mt-2 align-middle">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>AC Unit</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No requests found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $row): ?>
                            <?php $payment = $paymentRepo->getByBookingId((int) $row['id']); ?>
                            <tr>
                                <td><?= e($row['customer_name']) ?></td>
                                <td><?= e(formatDate($row['preferred_date'])) ?></td>
                                <td><?= e(formatTime($row['preferred_time'])) ?></td>
                                <td><?= e($row['ac_name'] ?: '-') ?></td>
                                <td>
                                    <span class="badge <?= statusBadge($row['status']) ?>">
                                        <?= e(ucwords(str_replace('_', ' ', $row['status']))) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (($payment['status'] ?? '') === 'paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="dashboard.php?page=view_booking_details&booking_id=<?= e((string) $row['id']) ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                        <?php if ($row['status'] === 'paid'): ?>
                                            <form method="POST" action="../actions/technician/approve_booking.php">
                                                <input type="hidden" name="booking_id" value="<?= e((string) $row['id']) ?>">
                                                <button class="btn btn-sm btn-primary">Approve</button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal<?= e((string) $row['id']) ?>">
                                                Reject
                                            </button>
                                        <?php else: ?>
                                            <span class="text-success small">Handled</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php foreach ($requests as $row): ?>
        <div class="modal fade" id="rejectModal<?= e((string) $row['id']) ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../actions/technician/reject_booking.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Booking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="booking_id" value="<?= e((string) $row['id']) ?>">
                            <label class="form-label">Reason for rejection</label>
                            <textarea class="form-control" name="reason" rows="4" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Submit Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

