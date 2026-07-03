<?php
/**
 * Handle contact form submission and save to database
 */

require_once __DIR__ . '/../includes/public_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectTo('contact_us.php');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$subject = trim($_POST['service'] ?? 'General Inquiry');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];
if (empty($name)) $errors[] = 'Name is required.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if (empty($message)) $errors[] = 'Message is required.';

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    redirectTo('../contact_us.php');
}

// Insert message into database
$userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session if logged in
$stmt = $conn->prepare("
    INSERT INTO contact_messages (user_id, name, email, phone, subject, message, status, created_at)
    VALUES (?, ?, ?, ?, ?, ?, 'new', NOW())
");

$stmt->bind_param('isssss', $userId, $name, $email, $phone, $subject, $message);

if ($stmt->execute()) {
    setFlash('success', 'Thank you for your message. We will get back to you shortly.');
} else {
    setFlash('error', 'Failed to send message. Please try again.');
}

redirectTo('../contact_us.php');