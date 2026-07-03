<?php
/**
 * Handle admin reply to contact message
 */

require_once __DIR__ . '/../../includes/bootstrap.php';
requireRole('admin');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('error', 'Invalid request method.');
    redirectTo('../admin/dashboard.php?page=messages');
}

$messageId = (int) ($_POST['message_id'] ?? 0);
$reply = trim($_POST['reply'] ?? '');

if (!$messageId || empty($reply)) {
    setFlash('error', 'Invalid message ID or empty reply.');
    redirectTo('../admin/dashboard.php?page=messages');
}

// Load repository
$messageRepo = new ContactMessageRepository($conn);

// Verify message exists
$message = $messageRepo->getById($messageId);
if (!$message) {
    setFlash('error', 'Message not found.');
    redirectTo('../../admin/dashboard.php?page=messages');
}

// Save reply
$adminId = $_SESSION['user_id'];
if ($messageRepo->saveReply($messageId, $reply, $adminId)) {
    setFlash('success', 'Reply sent successfully to ' . $message['email']);
} else {
    setFlash('error', 'Failed to send reply.');
}

redirectTo('../../admin/dashboard.php?page=messages');
