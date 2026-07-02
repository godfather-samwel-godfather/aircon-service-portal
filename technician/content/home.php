<?php
$userId = getCurrentUserId();
$techId = 0;
$stats = ['assigned' => 0, 'in_progress' => 0, 'completed' => 0];
$recentAssignments = [];
$recentNotifications = [];

$stmt = $conn->prepare("SELECT id FROM technicians WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$techRow = $stmt->get_result()->fetch_assoc();

if ($techRow) {
    $techId = (int) $techRow['id'];

    $countStmt = $conn->prepare("
        SELECT
            SUM(CASE WHEN status IN ('approved','paid') THEN 1 ELSE 0 END) AS assigned,
            SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) AS in_progress,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed
        FROM bookings
        WHERE technician_id = ?
    ");
    $countStmt->bind_param("i", $techId);
    $countStmt->execute();
    $row = $countStmt->get_result()->fetch_assoc();

    if ($row) {
        $stats['assigned']    = (int) $row['assigned'];
        $stats['in_progress'] = (int) $row['in_progress'];
        $stats['completed']   = (int) $row['completed'];
    }

    $assignmentStmt = $conn->prepare(
        "SELECT b.id, b.preferred_date, b.preferred_time, b.status, ac.nickname AS ac_name
         FROM bookings b
         LEFT JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
         WHERE b.technician_id = ?
         ORDER BY b.created_at DESC
         LIMIT 5"
    );
    $assignmentStmt->bind_param("i", $techId);
    $assignmentStmt->execute();
    $recentAssignments = $assignmentStmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $notificationStmt = $conn->prepare(
        "SELECT b.id, b.status, b.preferred_date, b.preferred_time
         FROM bookings b
         WHERE b.technician_id = ? AND b.status IN ('approved','in_progress','pending_technician')
         ORDER BY b.updated_at DESC
         LIMIT 3"
    );
    $notificationStmt->bind_param("i", $techId);
    $notificationStmt->execute();
    $recentNotifications = $notificationStmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="dashboard-container">
    <div class="welcome-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div>
                <h1 class="mb-3">Hello, <?= e($_SESSION['name'] ?? 'Technician') ?> 👋</h1>
                <p class="mb-0">Daily overview for <?= date('j F Y') ?>. Keep your workflow moving.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Technician Panel</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-modern p-3">
                <small class="text-muted">Assigned Jobs</small>
                <h4 class="mb-0 fw-bold"><?= $stats['assigned'] ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-modern p-3">
                <small class="text-muted">In Progress</small>
                <h4 class="mb-0 fw-bold"><?= $stats['in_progress'] ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-modern p-3">
                <small class="text-muted">Completed</small>
                <h4 class="mb-0 fw-bold"><?= $stats['completed'] ?></h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-modern">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Immediate Bookings</h5>
                    <a href="dashboard.php?page=assigned_jobs" class="btn btn-sm btn-outline-primary">View Assigned</a>
                </div>
                <div class="scrollable-table">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>AC Unit</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentAssignments)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No active bookings assigned yet.
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($recentAssignments as $booking): ?>
                            <tr>
                                <td><?= e($booking['ac_name'] ?? 'AC Unit') ?></td>
                                <td><?= formatDate($booking['preferred_date']) ?></td>
                                <td><?= formatTime($booking['preferred_time']) ?></td>
                                <td><span
                                        class="badge <?= statusBadge($booking['status']) ?>"><?= e(ucwords(str_replace('_', ' ', $booking['status']))) ?></span>
                                </td>
                                <td><a href="dashboard.php?page=view_booking_details&id=<?= e($booking['id']) ?>"
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
                    <div class="list-group-item text-center text-muted">No recent notifications.</div>
                    <?php else: ?>
                    <?php foreach ($recentNotifications as $note): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong><?= e(ucwords(str_replace('_', ' ', $note['status']))) ?></strong>
                                <div class="small text-muted"><?= formatDate($note['preferred_date']) ?> at
                                    <?= formatTime($note['preferred_time']) ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-modern">
                <h5 class="mb-3">Quick Actions</h5>
                <a href="dashboard.php?page=assigned_jobs" class="btn btn-secondary w-100 mb-2">View Assigned Jobs</a>
                <a href="dashboard.php?page=upload_results" class="btn btn-outline-secondary w-100 mb-2">Upload
                    Result</a>
                <a href="dashboard.php?page=job_history" class="btn btn-outline-secondary w-100">Job History</a>
            </div>
        </div>
    </div>
</div>