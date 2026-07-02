<?php
$techRepo = new TechnicianRepository($conn);
$bookingRepo = new BookingRepository($conn);

$tech = $techRepo->getByUserId(getCurrentUserId());
$history = $tech ? $bookingRepo->getByTechnicianAndStatuses((int) $tech['id'], ['completed', 'rejected', 'cancelled']) : [];
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3"><i class="bi bi-clock-history me-2"></i>Job History</h1>
                <p class="mb-0">Review your completed, rejected, and cancelled jobs.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Technician Dashboard</span>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-sm border-0 rounded-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>AC Unit</th>
                    <th>Status</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No history records.</td></tr>
                <?php else: ?>
                    <?php foreach ($history as $row): ?>
                        <tr>
                            <td><?= e($row['customer_name']) ?></td>
                            <td><?= e(formatDate($row['preferred_date'])) ?></td>
                            <td><?= e($row['ac_name'] ?: '-') ?></td>
                            <td><span class="badge <?= statusBadge($row['status']) ?>"><?= e(ucwords(str_replace('_', ' ', $row['status']))) ?></span></td>
                            <td><?= e($row['rejection_reason'] ?: '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
