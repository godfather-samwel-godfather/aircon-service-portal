<?php
/**
 * Customer dashboard home — summary cards from bookings table.
 */

$userId = getCurrentUserId();
$customerId = 0;
$stats = [
    'total'     => 0,
    'pending'   => 0,
    'active'    => 0,
    'completed' => 0,
];
$recentBookings = [];
$recentFaults = [];
$quickLinks = [
    ['title' => 'Book New Service', 'icon' => 'bi-plus-circle', 'url' => 'dashboard.php?page=create_appointment', 'color' => 'primary'],
    ['title' => 'View Appointments', 'icon' => 'bi-calendar2-week', 'url' => 'dashboard.php?page=view_appointments', 'color' => 'info'],
    ['title' => 'View Results', 'icon' => 'bi-check2-square', 'url' => 'dashboard.php?page=view_service_results', 'color' => 'success'],
    ['title' => 'Report a Fault', 'icon' => 'bi-exclamation-triangle', 'url' => 'dashboard.php?page=fault_reports', 'color' => 'warning'],
];

$stmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$customerRow = $stmt->get_result()->fetch_assoc();

if ($customerRow) {
    $customerId = (int) $customerRow['id'];

    $countStmt = $conn->prepare("
        SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN status IN ('pending_payment','pending_technician') THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN status IN ('paid','approved','in_progress') THEN 1 ELSE 0 END) AS active,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed
        FROM bookings
        WHERE customer_id = ?
    ");
    $countStmt->bind_param("i", $customerId);
    $countStmt->execute();
    $row = $countStmt->get_result()->fetch_assoc();

    if ($row) {
        $stats['total']     = (int) $row['total'];
        $stats['pending']   = (int) $row['pending'];
        $stats['active']    = (int) $row['active'];
        $stats['completed'] = (int) $row['completed'];
    }

    $recentStmt = $conn->prepare("
        SELECT b.id, b.preferred_date, b.preferred_time, b.status, b.problem_description,
               ac.nickname AS ac_name
        FROM bookings b
        LEFT JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
        WHERE b.customer_id = ?
        ORDER BY b.created_at DESC
        LIMIT 5
    ");
    $recentStmt->bind_param("i", $customerId);
    $recentStmt->execute();
    $recentBookings = $recentStmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $faultStmt = $conn->prepare("
        SELECT fr.id, fr.fault_category, fr.status, fr.created_at, ac.nickname AS ac_name
        FROM fault_reports fr
        LEFT JOIN air_conditioners ac ON ac.id = fr.air_conditioner_id
        WHERE fr.customer_id = ?
        ORDER BY fr.created_at DESC
        LIMIT 5
    ");
    $faultStmt->bind_param("i", $customerId);
    $faultStmt->execute();
    $recentFaults = $faultStmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div>
                <h1 class="mb-3">Welcome, <?= e($_SESSION['name'] ?? 'Customer') ?> 👋</h1>
                <p class="mb-0">Manage your AC service bookings from one place. <?= date('j F Y') ?>.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Customer Dashboard</span>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <small class="text-muted">Total Bookings</small>
                    <h4 class="mb-0 fw-bold"><?= $stats['total'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <small class="text-muted">Pending</small>
                    <h4 class="mb-0 fw-bold"><?= $stats['pending'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
                <div>
                    <small class="text-muted">Active</small>
                    <h4 class="mb-0 fw-bold"><?= $stats['active'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <small class="text-muted">Completed</small>
                    <h4 class="mb-0 fw-bold"><?= $stats['completed'] ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php foreach ($quickLinks as $link): ?>
        <div class="col-sm-6 col-lg-3">
            <a href="<?= e($link['url']) ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 h-100 hover-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-<?= e($link['color']) ?> bg-opacity-10 text-<?= e($link['color']) ?>">
                            <i class="bi <?= e($link['icon']) ?>"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark"><?= e($link['title']) ?></h6>
                            <small class="text-muted">Quick access</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Bookings</h5>
                <a href="dashboard.php?page=view_appointments" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentBookings)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                        No bookings yet.
                        <a href="dashboard.php?page=create_appointment" class="d-block mt-2">Create your first appointment</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>AC Unit</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentBookings as $booking): ?>
                                    <tr>
                                        <td><?= e($booking['ac_name'] ?? 'AC Unit') ?></td>
                                        <td><?= formatDate($booking['preferred_date']) ?></td>
                                        <td><?= formatTime($booking['preferred_time']) ?></td>
                                        <td>
                                            <span class="badge <?= statusBadge($booking['status']) ?>">
                                                <?= e(ucwords(str_replace('_', ' ', $booking['status']))) ?>
                                            </span>
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

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Activity</h5>
                <a href="dashboard.php?page=fault_reports" class="btn btn-sm btn-outline-secondary">Report Fault</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentFaults)): ?>
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-activity display-6 d-block mb-2"></i>
                        No recent fault activity.
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($recentFaults as $fault): ?>
                            <div class="border rounded p-3 hover-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?= e($fault['ac_name'] ?: 'AC Unit') ?></strong>
                                        <div class="small text-muted"><?= e($fault['fault_category'] ?: 'Fault reported') ?></div>
                                    </div>
                                    <span class="badge <?= statusBadge($fault['status'] ?? 'new') ?>">
                                        <?= e(ucfirst(str_replace('_', ' ', $fault['status'] ?? 'new'))) ?>
                                    </span>
                                </div>
                                <div class="small text-muted mt-2"><?= e(formatDate($fault['created_at'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
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
</style>
