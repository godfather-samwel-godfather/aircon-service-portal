<?php
$bookingRepo = new BookingRepository($conn);
$paymentRepo = new PaymentRepository($conn);

$userId = getCurrentUserId();
$stmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();
$customerId = (int) ($customer['id'] ?? 0);

$historyBookings = [];
if ($customerId) {
    $historyBookings = $bookingRepo->getByCustomerId($customerId);
    $historyBookings = array_values(array_filter($historyBookings, function ($row) {
        return in_array($row['status'] ?? '', ['completed', 'cancelled', 'rejected'], true);
    }));
}

$completedCount = count(array_filter($historyBookings, fn($row) => ($row['status'] ?? '') === 'completed'));
$cancelledCount = count(array_filter($historyBookings, fn($row) => ($row['status'] ?? '') === 'cancelled'));
$rejectedCount = count(array_filter($historyBookings, fn($row) => ($row['status'] ?? '') === 'rejected'));
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Appointment History</h1>
                <p class="mb-0">Track completed, cancelled, and rejected appointments with a clear service timeline.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Customer Dashboard</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100 hover-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Completed</small>
                    <h4 class="mb-0 fw-bold mt-1"><?= $completedCount ?></h4>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check2-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100 hover-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Cancelled</small>
                    <h4 class="mb-0 fw-bold mt-1"><?= $cancelledCount ?></h4>
                </div>
                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100 hover-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Rejected</small>
                    <h4 class="mb-0 fw-bold mt-1"><?= $rejectedCount ?></h4>
                </div>
                <div class="stat-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-slash-circle"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($historyBookings)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                No past appointments yet.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>AC Unit</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historyBookings as $i => $row): ?>
                            <?php $payment = $paymentRepo->getByBookingId((int) $row['id']); ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= e($row['ac_name'] ?: 'AC Unit') ?></td>
                                <td><?= e(formatDate($row['preferred_date'])) ?></td>
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
                                    <small class="text-muted">
                                        <?= e($row['problem_description'] ?: 'No extra details provided') ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>

<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.12) !important;
}
.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
</style>
