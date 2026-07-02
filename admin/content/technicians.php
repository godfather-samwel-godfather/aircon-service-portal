<?php
$techRepo = new TechnicianRepository($conn);
$technicians = $techRepo->getApprovedForPublic();
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Approved Technicians</h1>
                <p class="mb-0">Browse technician profiles available for service assignments.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Admin Dashboard</span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Experience</th>
                        <th>Radius</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($technicians)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">No approved technicians.</td></tr>
                    <?php else: ?>
                        <?php foreach ($technicians as $tech): ?>
                            <tr>
                                <td><?= e($tech['full_name']) ?></td>
                                <td><?= e($tech['specialization'] ?: 'General') ?></td>
                                <td><?= e((string) $tech['years_experience']) ?> years</td>
                                <td><?= e($tech['service_radius'] ?: '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

