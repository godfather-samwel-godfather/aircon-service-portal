<?php
$bookingRepo = new BookingRepository($conn);
$paymentRepo = new PaymentRepository($conn);

$userId = getCurrentUserId();
$stmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();
$customerId = (int) ($customer['id'] ?? 0);

$bookings = $customerId ? $bookingRepo->getByCustomerId($customerId) : [];

$pendingPayment = $customerId ? $bookingRepo->countByCustomerAndStatus($customerId, 'pending_payment') : 0;
$paid = $customerId ? $bookingRepo->countByCustomerAndStatus($customerId, 'paid') : 0;
$approved = $customerId ? $bookingRepo->countByCustomerAndStatus($customerId, 'approved') : 0;
$rejected = $customerId ? $bookingRepo->countByCustomerAndStatus($customerId, 'rejected') : 0;
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">My Bookings</h1>
                <p class="mb-0">Track payment and technician approval status.</p>
            </div>
            <div class="text-md-end">
                <a href="dashboard.php?page=create_appointment" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> New Booking
                </a>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3"><small class="text-muted">Pending Payment</small>
            <h4 class="mb-0"><?= $pendingPayment ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3"><small class="text-muted">Paid</small>
            <h4 class="mb-0"><?= $paid ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3"><small class="text-muted">Approved</small>
            <h4 class="mb-0"><?= $approved ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3"><small class="text-muted">Rejected</small>
            <h4 class="mb-0"><?= $rejected ?></h4>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>AC Unit</th>
                        <th>Technician</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No bookings yet.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($bookings as $i => $row): ?>
                    <?php $payment = $paymentRepo->getByBookingId((int) $row['id']); ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?= e(formatDate($row['preferred_date'])) ?><br>
                            <small class="text-muted"><?= e(formatTime($row['preferred_time'])) ?></small>
                        </td>
                        <td><?= e($row['ac_name'] ?: 'AC Unit') ?></td>
                        <td><?= e($row['technician_name'] ?: 'Not assigned') ?></td>
                        <td><span
                                class="badge bg-light text-dark"><?= e($bookingRepo->getServiceNames((int) $row['id'])) ?></span>
                        </td>
                        <td>
                            <span class="badge <?= statusBadge($row['status']) ?>">
                                <?= e(ucwords(str_replace('_', ' ', $row['status']))) ?>
                            </span>
                            <?php if ($row['status'] === 'rejected'): ?>
                            <div class="small text-danger mt-1">
                                <?= e($row['rejection_reason'] ?: 'No reason provided') ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (($payment['status'] ?? '') === 'paid'): ?>
                            <span class="badge bg-success">Paid</span>
                            <?php else: ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] === 'pending_payment'): ?>
                            <a class="btn btn-success btn-sm"
                                href="../actions/customer/pay_booking.php?id=<?= e((string) $row['id']) ?>">
                                <i class="bi bi-credit-card me-1"></i> Pay
                            </a>
                            <?php else: ?>
                            <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>