<?php
$serviceRepo = new ServiceCategoryRepository($conn);
$technicianRepo = new TechnicianRepository($conn);
$services = $serviceRepo->getActive();
$technicians = $technicianRepo->getApprovedList();
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Book AC Service</h1>
                <p class="mb-0">Fill in AC details and problem description, then confirm booking.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Customer Dashboard</span>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="../actions/customer/create_booking_process.php">
            <h6 class="fw-bold mb-3">Air Conditioner Information</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Unit Name/Nickname</label>
                    <input type="text" name="nickname" class="form-control" placeholder="Living room AC" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Brand</label>
                    <input type="text" name="brand" class="form-control" placeholder="LG / Samsung" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Model</label>
                    <input type="text" name="model" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Serial Number</label>
                    <input type="text" name="serial_number" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">AC Type</label>
                    <input type="text" name="ac_type" class="form-control" placeholder="Split / Window / Central">
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Cooling Capacity</label>
                    <input type="text" name="cooling_capacity" class="form-control" placeholder="12000 BTU">
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Installation Date</label>
                    <input type="date" name="installation_date" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Installation Address</label>
                    <input type="text" name="installation_address" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label small text-muted">AC Notes (Optional)</label>
                    <textarea name="ac_notes" class="form-control" rows="2"></textarea>
                </div>
            </div>

            <h6 class="fw-bold mb-3">Booking Details</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Preferred Date</label>
                    <input type="date" name="preferred_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Preferred Time</label>
                    <input type="time" name="preferred_time" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Assign Technician</label>
                    <select name="technician_id" class="form-select" required>
                        <option value="">-- Select Technician --</option>
                        <?php foreach ($technicians as $tech): ?>
                        <option value="<?= e((string) $tech['id']) ?>">
                            <?= e($tech['full_name']) ?> - <?= e($tech['specialization'] ?: 'General') ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Emergency</label>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="1" name="emergency" id="emergencyCheck">
                        <label class="form-check-label" for="emergencyCheck">Mark as emergency request</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label small text-muted">Problem Description</label>
                    <textarea name="problem_description" class="form-control" rows="3" required
                        placeholder="Describe AC problem details..."></textarea>
                </div>
            </div>

            <h6 class="fw-bold mb-3">Select Services</h6>
            <div class="row g-2 mb-4">
                <?php if (empty($services)): ?>
                <div class="col-12">
                    <div class="alert alert-warning mb-0">No active services found. Please contact admin.</div>
                </div>
                <?php else: ?>
                <?php foreach ($services as $service): ?>
                <div class="col-md-6">
                    <label class="border rounded p-3 w-100">
                        <input class="form-check-input me-2" type="checkbox" name="service_ids[]"
                            value="<?= e((string) $service['id']) ?>">
                        <strong><?= e($service['name']) ?></strong>
                        <span class="text-muted small d-block">
                            <?= e($service['description'] ?: 'No description') ?>
                        </span>
                        <span class="badge bg-light text-dark mt-1">
                            <?= number_format((float) $service['price'], 0) ?> TZS
                        </span>
                    </label>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                <i class="bi bi-check2-circle me-1"></i> Confirm Booking
            </button>
        </form>
    </div>
</div>
</div>