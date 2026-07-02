<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('customer');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../customer/dashboard.php?page=fault_reports');
}

$userId = getCurrentUserId();
$customerStmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$customerStmt->bind_param("i", $userId);
$customerStmt->execute();
$customer = $customerStmt->get_result()->fetch_assoc();

if (!$customer) {
    redirect('../../customer/dashboard.php?page=fault_reports&error=Customer profile not found');
}

$customerId = (int) $customer['id'];
$airConditionerId = (int) ($_POST['air_conditioner_id'] ?? 0);
$faultCategory = trim((string) ($_POST['fault_category'] ?? 'Other'));
$description = trim((string) ($_POST['description'] ?? ''));
$urgencyLevel = in_array($_POST['urgency_level'] ?? 'medium', ['low', 'medium', 'high', 'emergency'], true)
    ? $_POST['urgency_level']
    : 'medium';

if ($airConditionerId <= 0 || $faultCategory === '' || $description === '') {
    redirect('../../customer/dashboard.php?page=fault_reports&error=Please fill all required fields');
}

$acStmt = $conn->prepare("SELECT id FROM air_conditioners WHERE id = ? AND customer_id = ? LIMIT 1");
$acStmt->bind_param("ii", $airConditionerId, $customerId);
$acStmt->execute();
$ac = $acStmt->get_result()->fetch_assoc();

if (!$ac) {
    redirect('../../customer/dashboard.php?page=fault_reports&error=Selected AC unit is invalid');
}

$mediaPath = null;
if (!empty($_FILES['fault_image']['tmp_name']) && is_uploaded_file($_FILES['fault_image']['tmp_name'])) {
    $uploadDir = __DIR__ . '/../../assets/uploads/fault_reports/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $extension = pathinfo($_FILES['fault_image']['name'], PATHINFO_EXTENSION);
    $filename = 'fault_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    $destPath = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['fault_image']['tmp_name'], $destPath)) {
        $mediaPath = 'assets/uploads/fault_reports/' . $filename;
    }
}

$faultRepo = new FaultReportRepository($conn);
$faultRepo->create($customerId, $airConditionerId, $faultCategory, $description, $mediaPath, $urgencyLevel);

redirect('../../customer/dashboard.php?page=fault_reports&msg=Fault report submitted successfully');
