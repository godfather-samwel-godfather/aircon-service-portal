<?php
$messageRepo = new ContactMessageRepository($conn);
$messages = $messageRepo->getAll();
$newCount = $messageRepo->countByStatus('new');
$repliedCount = $messageRepo->countByStatus('replied');
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Contact Messages</h1>
                <p class="mb-0">Manage customer inquiries and send replies.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Admin Dashboard</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-modern p-3">
                <small class="text-muted">New Messages</small>
                <h4 class="mb-0 fw-bold text-danger"><?= $newCount ?></h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-modern p-3">
                <small class="text-muted">Replied</small>
                <h4 class="mb-0 fw-bold text-success"><?= $repliedCount ?></h4>
            </div>
        </div>
    </div>

    <?php flashMessage(); ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>From</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($messages)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No messages yet.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?= e($msg['name']) ?></td>
                            <td><?= e($msg['email']) ?></td>
                            <td><?= e($msg['subject'] ?: 'General Inquiry') ?></td>
                            <td>
                                <span
                                    class="badge <?= $msg['status'] === 'replied' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                    <?= ucfirst($msg['status']) ?>
                                </span>
                            </td>
                            <td><?= formatDate($msg['created_at']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#viewModal<?= $msg['id'] ?>">
                                    View &amp; Reply
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View & Reply Modals (Zimehamishwa nje ya table) -->
<?php if (!empty($messages)): ?>
<?php foreach ($messages as $msg): ?>
<div class="modal fade" id="viewModal<?= $msg['id'] ?>" tabindex="-1" data-bs-keyboard="false"
    aria-labelledby="modalLabel<?= $msg['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message from <?= e($msg['name']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>From:</strong> <?= e($msg['name']) ?> (<?= e($msg['email']) ?>)
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong> <?= e($msg['phone'] ?: 'N/A') ?>
                </div>
                <div class="mb-3">
                    <strong>Subject:</strong> <?= e($msg['subject'] ?: 'General Inquiry') ?>
                </div>
                <div class="mb-3">
                    <strong>Message Date:</strong> <?= formatDate($msg['created_at']) ?>
                </div>
                <div class="mb-3 p-3 bg-light rounded">
                    <strong>Customer Message:</strong>
                    <p class="mt-2"><?= nl2br(e($msg['message'])) ?></p>
                </div>

                <?php if ($msg['reply']): ?>
                <div class="mb-3 p-3 bg-success bg-opacity-10 rounded">
                    <strong class="text-success">Your Reply
                        (<?= formatDate($msg['replied_at']) ?>):</strong>
                    <p class="mt-2"><?= nl2br(e($msg['reply'])) ?></p>
                </div>
                <?php else: ?>
                <form method="POST" action="/ACSS/airconservices_booking/actions/admin/reply_message.php">
                    <input type="hidden" name="message_id" value="<?= e((string) $msg['id']) ?>">
                    <div class="mb-3">
                        <label class="form-label">Your Reply</label>
                        <textarea name="reply" class="form-control" rows="5" required
                            placeholder="Type your reply message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>