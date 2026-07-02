<?php
$stats = [
    'users'       => 0,
    'customers'   => 0,
    'technicians' => 0,
    'bookings'    => 0,
];

$queries = [
    'users'       => "SELECT COUNT(*) AS c FROM users",
    'customers'   => "SELECT COUNT(*) AS c FROM customers",
    'technicians' => "SELECT COUNT(*) AS c FROM technicians",
    'bookings'    => "SELECT COUNT(*) AS c FROM bookings",
];

foreach ($queries as $key => $sql) {
    $result = $conn->query($sql);
    if ($result) {
        $stats[$key] = (int) $result->fetch_assoc()['c'];
    }
}

$recentBookings = [];
$recentNotifications = [];

$bookingStmt = $conn->query(
    "SELECT b.id, b.preferred_date, b.preferred_time, b.status, u.full_name AS customer_name
     FROM bookings b
     LEFT JOIN customers c ON c.id = b.customer_id
     LEFT JOIN users u ON u.id = c.user_id
     ORDER BY b.created_at DESC
     LIMIT 5"
);
if ($bookingStmt) {
    $recentBookings = $bookingStmt->fetch_all(MYSQLI_ASSOC);
}

$notificationStmt = $conn->query(
    "SELECT b.id, b.status, u.full_name AS customer_name, b.created_at
     FROM bookings b
     LEFT JOIN customers c ON c.id = b.customer_id
     LEFT JOIN users u ON u.id = c.user_id
     WHERE b.status IN ('pending_payment','pending_technician','rejected')
     ORDER BY b.created_at DESC
     LIMIT 3"
);
if ($notificationStmt) {
    $recentNotifications = $notificationStmt->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="dashboard-container">
    <div class="welcome-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div>
                <h1 class="mb-3">Welcome Back, Admin 👋</h1>
                <p class="mb-0">Your dashboard summary for today, <?= date('j F Y') ?>.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">System Overview</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card-modern p-3">
                <small class="text-muted">Total Users</small>
                <h4 class="mb-0 fw-bold"><?= $stats['users'] ?></h4>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-modern p-3">
                <small class="text-muted">Customers</small>
                <h4 class="mb-0 fw-bold"><?= $stats['customers'] ?></h4>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-modern p-3">
                <small class="text-muted">Technicians</small>
                <h4 class="mb-0 fw-bold"><?= $stats['technicians'] ?></h4>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-modern p-3">
                <small class="text-muted">Bookings</small>
                <h4 class="mb-0 fw-bold"><?= $stats['bookings'] ?></h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-modern">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Immediate Bookings</h5>
                    <a href="dashboard.php?page=bookings" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="scrollable-table">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentBookings)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent booking activity
                                    available.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($recentBookings as $booking): ?>
                            <tr>
                                <td><?= e($booking['customer_name'] ?? 'Customer') ?></td>
                                <td>Service Request</td>
                                <td><?= formatDate($booking['preferred_date']) ?>
                                    <?= formatTime($booking['preferred_time']) ?></td>
                                <td><span
                                        class="badge <?= statusBadge($booking['status']) ?>"><?= e(ucwords(str_replace('_', ' ', $booking['status']))) ?></span>
                                </td>
                                <td><a href="dashboard.php?page=bookings"
                                        class="btn btn-sm btn-outline-primary">Details</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-modern mb-4">
                <h5 class="mb-3">Recent Notifications</h5>
                <div class="list-group list-group-flush">
                    <?php if (empty($recentNotifications)): ?>
                    <div class="list-group-item text-center text-muted">No alerts currently.</div>
                    <?php else: ?>
                    <?php foreach ($recentNotifications as $note): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= e($note['customer_name']) ?></strong>
                            <div class="small text-muted">Status:
                                <?= e(ucwords(str_replace('_', ' ', $note['status']))) ?></div>
                        </div>
                        <span class="small text-muted"><?= formatDate($note['created_at']) ?></span>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-modern">
                <h5 class="mb-3">Quick Actions</h5>
                <a href="dashboard.php?page=users" class="btn btn-secondary w-100 mb-2">Manage Users</a>
                <a href="dashboard.php?page=technicians" class="btn btn-outline-secondary w-100 mb-2">Review
                    Technicians</a>
                <a href="dashboard.php?page=services" class="btn btn-outline-secondary w-100 mb-2">Service
                    Categories</a>
                <a href="dashboard.php?page=bookings" class="btn btn-outline-secondary w-100">View Bookings</a>
            </div>
        </div>
    </div>
</div>