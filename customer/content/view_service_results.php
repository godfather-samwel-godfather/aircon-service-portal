<?php
$customerStmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$userId = getCurrentUserId();
$customerStmt->bind_param("i", $userId);
$customerStmt->execute();
$customer = $customerStmt->get_result()->fetch_assoc();
$customerId = (int) ($customer['id'] ?? 0);

$serviceResultRepo = new ServiceResultRepository($conn);
$faultRepo = new FaultReportRepository($conn);
$results = $serviceResultRepo->getByCustomer($customerId);
$faultReports = $faultRepo->getByCustomer($customerId);

$timeline = [];
foreach ($results as $result) {
    $timeline[] = [
        'type' => 'result',
        'date' => $result['created_at'],
        'title' => 'Service Result Uploaded',
        'subtitle' => $result['ac_name'],
        'details' => trim($result['work_report'] . ' ' . $result['parts_used']),
        'status' => $result['booking_status'],
        'link' => null,
    ];
}
foreach ($faultReports as $report) {
    $timeline[] = [
        'type' => 'fault',
        'date' => $report['created_at'],
        'title' => 'Fault Report Submitted',
        'subtitle' => $report['ac_name'],
        'details' => $report['fault_category'] . ': ' . $report['description'],
        'status' => $report['status'],
        'link' => $report['media'] ? '../' . $report['media'] : null,
    ];
}
usort($timeline, function ($a, $b) {
    return strcmp($b['date'], $a['date']);
});
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">View Service Results</h1>
                <p class="mb-0">Review technician uploads, AC timeline, and fault reports in one place.</p>
            </div>
            <div class="text-md-end">
                <a href="dashboard.php?page=fault_reports" class="btn btn-outline-primary">Report a Fault</a>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-4 shadow-sm border-0">
            <h6 class="mb-2">Service Results</h6>
            <p class="small text-muted mb-0">Technician reports, before/after images, and signatures.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 shadow-sm border-0">
            <h6 class="mb-2">Fault Report Timeline</h6>
            <p class="small text-muted mb-0">Track issues separately from regular bookings.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="mb-3">Latest Results</h5>
        <?php if (empty($results)): ?>
            <div class="text-center text-muted py-4">No service results uploaded yet.</div>
        <?php else: ?>
            <?php foreach ($results as $result): ?>
                <div class="mb-4 border-bottom pb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1"><?= e($result['ac_name']) ?> <small class="text-muted">(<?= e(ucwords(str_replace('_', ' ', $result['booking_status']))) ?>)</small></h6>
                            <div class="small text-muted">Service date: <?= e(formatDate($result['preferred_date'])) ?> · Uploaded: <?= e(formatDate($result['created_at'])) ?></div>
                        </div>
                        <span class="badge <?= statusBadge($result['booking_status']) ?>"><?= e(ucwords(str_replace('_', ' ', $result['booking_status']))) ?></span>
                    </div>
                    <p class="mb-2"><strong>Technician:</strong> <?= e($result['technician_name']) ?></p>
                    <p class="mb-2"><strong>Work Report:</strong> <?= e($result['work_report']) ?></p>
                    <p class="mb-2"><strong>Parts Used:</strong> <?= e($result['parts_used'] ?: 'None specified') ?></p>
                    <div class="row g-3">
                        <?php if (!empty($result['before_image'])): ?>
                        <div class="col-sm-4">
                            <div class="card">
                                <img src="../<?= e($result['before_image']) ?>" class="card-img-top" alt="Before image">
                                <div class="card-body py-2 small text-center">Before</div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($result['after_image'])): ?>
                        <div class="col-sm-4">
                            <div class="card">
                                <img src="../<?= e($result['after_image']) ?>" class="card-img-top" alt="After image">
                                <div class="card-body py-2 small text-center">After</div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($result['signature_image'])): ?>
                        <div class="col-sm-4">
                            <div class="card">
                                <img src="../<?= e($result['signature_image']) ?>" class="card-img-top" alt="Signature image">
                                <div class="card-body py-2 small text-center">Signature</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="mb-3">AC Unit Timeline</h5>
        <?php if (empty($timeline)): ?>
            <div class="text-center text-muted py-4">No timeline events yet.</div>
        <?php else: ?>
            <ul class="timeline list-unstyled">
                <?php foreach ($timeline as $event): ?>
                    <li class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong><?= e($event['title']) ?></strong>
                            <span class="small text-muted"><?= e(formatDate($event['date'])) ?></span>
                        </div>
                        <p class="mb-1"><?= e($event['subtitle']) ?></p>
                        <p class="small text-muted mb-1"><?= e($event['details']) ?></p>
                        <?php if (!empty($event['link'])): ?>
                            <a href="<?= e($event['link']) ?>" target="_blank">View attachment</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
</div>
