<?php
/**
 * Run once: http://localhost/ACSS/airconservices_booking/reset_test_passwords.php
 * Sets known passwords for test accounts.
 */
require_once __DIR__ . '/config/db.php';

$accounts = [
    'admin@aircon.com' => 'Admin@123',
    'customer@aircon.com' => 'Customer@123',
    'tech@aircon.com' => 'Tech@123',
];

$stmt = $conn->prepare('UPDATE users SET password = ? WHERE email = ?');

foreach ($accounts as $email => $plain) {
    $hash = password_hash($plain, PASSWORD_DEFAULT);
    $stmt->bind_param('ss', $hash, $email);
    $stmt->execute();
    echo $email . ' => ' . $plain . ' (' . ($stmt->affected_rows ? 'updated' : 'not found') . ')<br>';
}

echo '<br>Done. Delete this file after use.';
