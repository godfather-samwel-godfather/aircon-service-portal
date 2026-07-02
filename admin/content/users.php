<?php
$userRepo = new UserRepository($conn);
$users = $userRepo->getAll();
?>

<div class="dashboard-container">

    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Manage Users</h1>
                <p class="mb-0">Manage HV aircon user accounts, customer, technician and user permissions.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Admin Dashboard</span>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
            <tr>
                <td colspan="7" class="text-center text-muted py-4">No users found.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= e((string) $user['id']) ?></td>
                <td><?= e($user['full_name']) ?></td>
                <td><?= e($user['email']) ?></td>
                <td><span class="badge bg-secondary"><?= e(ucfirst($user['role'])) ?></span></td>
                <td>
                    <span class="badge <?= statusBadge($user['status']) ?>">
                        <?= e(ucfirst($user['status'])) ?>
                    </span>
                </td>
                <td><?= e(formatDate($user['created_at'])) ?></td>
                <td class="d-flex flex-wrap gap-1">
                    <?php if ($user['role'] !== 'admin'): ?>
                    <?php if ($user['status'] !== 'active'): ?>
                    <form method="POST" action="../actions/admin/update_user_status.php" class="d-inline">
                        <input type="hidden" name="user_id" value="<?= e((string) $user['id']) ?>">
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                    </form>
                    <?php endif; ?>
                    <?php if ($user['status'] === 'active'): ?>
                    <form method="POST" action="../actions/admin/update_user_status.php" class="d-inline">
                        <input type="hidden" name="user_id" value="<?= e((string) $user['id']) ?>">
                        <input type="hidden" name="status" value="inactive">
                        <button type="submit" class="btn btn-warning btn-sm">Suspend</button>
                    </form>
                    <?php endif; ?>
                    <form method="POST" action="../actions/admin/update_user_status.php" class="d-inline"
                        onsubmit="return confirm('Block this user?');">
                        <input type="hidden" name="user_id" value="<?= e((string) $user['id']) ?>">
                        <input type="hidden" name="status" value="blocked">
                        <button type="submit" class="btn btn-danger btn-sm">Block</button>
                    </form>
                    <?php else: ?>
                    <span class="text-muted small">Protected</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>