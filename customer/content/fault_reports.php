<?php
$customerStmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$userId = getCurrentUserId();
$customerStmt->bind_param("i", $userId);
$customerStmt->execute();
$customer = $customerStmt->get_result()->fetch_assoc();
$customerId = (int) ($customer['id'] ?? 0);

$faultRepo = new FaultReportRepository($conn);
$units = $faultRepo->getUnitsByCustomer($customerId);
$reports = $faultRepo->getByCustomer($customerId);

$openCount = 0;
$resolvedCount = 0;
foreach ($reports as $report) {
    if ($report['status'] === 'resolved' || $report['status'] === 'closed') {
        $resolvedCount++;
    } else {
        $openCount++;
    }
}
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Fault Reporting</h1>
                <p class="mb-0">Report an AC issue for an existing unit without creating a booking.</p>
            </div>
            <div class="text-md-end">
                <a href="dashboard.php?page=view_service_results" class="btn btn-outline-primary">View Service Results</a>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted">Registered AC Units</small>
            <h4 class="mb-0"><?= count($units) ?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted">Open Fault Reports</small>
            <h4 class="mb-0"><?= $openCount ?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted">Resolved/Closed</small>
            <h4 class="mb-0"><?= $resolvedCount ?></h4>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">Submit New Fault Report</h5>
            <?php if (empty($units)): ?>
                <div class="alert alert-warning">You need an existing AC unit before you can report a fault. Please create a booking first.</div>
            <?php else: ?>
                <form method="POST" action="../actions/customer/create_fault_report.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Select AC Unit</label>
                        <select name="air_conditioner_id" class="form-select" required>
                            <option value="">-- Choose unit --</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= e((string) $unit['id']) ?>">
                                    <?= e($unit['nickname'] ?: $unit['brand'] . ' ' . $unit['model']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Fault Category</label>
                        <input type="text" name="fault_category" class="form-control" placeholder="Cooling issue, Electrical, Leakage" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Fault Description</label>
                        <textarea name="description" class="form-control" rows="4" required placeholder="Describe what is happening..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Urgency</label>
                        <select name="urgency_level" class="form-select">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Upload Fault Photo</label>
                        <input type="file" name="fault_image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Fault Report</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">My Fault Reports</h5>
            <?php if (empty($reports)): ?>
                <div class="text-center text-muted py-4">No fault reports yet.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td><?= e($report['ac_name']) ?></td>
                                    <td><?= e($report['fault_category']) ?></td>
                                    <td><span class="badge bg-secondary text-white"><?= e(ucfirst($report['urgency_level'])) ?></span></td>
                                    <td><span class="badge <?= statusBadge($report['status'] ?? 'new') ?>"><?= e(ucfirst(str_replace('_', ' ', $report['status'] ?? 'new'))) ?></span></td>
                                    <td><?= e(formatDate($report['created_at'])) ?></td>
                                    <td>
                                        <?php if (!empty($report['media'])): ?>
                                            <a href="../<?= e($report['media']) ?>" target="_blank">View</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
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
</div>
