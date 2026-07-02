<?php
$serviceRepo = new ServiceCategoryRepository($conn);
$services = $serviceRepo->getAll();
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Service Categories</h1>
                <p class="mb-0">Add and manage services shown on public Our Services page.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Admin Dashboard</span>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Add Service</h5>
                <form method="POST" action="../actions/admin/create_service_category.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Service Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (TZS)</label>
                        <input type="number" class="form-control" name="price" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                    <button class="btn btn-primary w-100">Save Service</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($services)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">No services yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($services as $service): ?>
                                    <tr>
                                        <td><?= e($service['name']) ?></td>
                                        <td><?= number_format((float) $service['price'], 0) ?> TZS</td>
                                        <td><span class="badge <?= statusBadge($service['status']) ?>"><?= e(ucfirst($service['status'])) ?></span></td>
                                        <td><?= e(formatDate($service['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

