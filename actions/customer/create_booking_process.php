<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('customer');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../customer/dashboard.php?page=create_appointment');
}

$userId = getCurrentUserId();

$customerStmt = $conn->prepare("SELECT id FROM customers WHERE user_id = ? LIMIT 1");
$customerStmt->bind_param("i", $userId);
$customerStmt->execute();
$customer = $customerStmt->get_result()->fetch_assoc();

if (!$customer) {
    redirect('../../customer/dashboard.php?page=create_appointment&error=Customer profile not found');
}

$customerId = (int) $customer['id'];
$technicianId = (int) ($_POST['technician_id'] ?? 0);
$preferredDate = (string) ($_POST['preferred_date'] ?? '');
$preferredTime = (string) ($_POST['preferred_time'] ?? '');
$problemDescription = trim((string) ($_POST['problem_description'] ?? ''));
$emergency = !empty($_POST['emergency']) ? 1 : 0;
$serviceIds = $_POST['service_ids'] ?? [];

if ($technicianId <= 0 || $preferredDate === '' || $preferredTime === '' || $problemDescription === '' || empty($serviceIds)) {
    redirect('../../customer/dashboard.php?page=create_appointment&error=Please fill all required fields');
}

$acRepo = new AirConditionerRepository($conn);
$bookingRepo = new BookingRepository($conn);
$paymentRepo = new PaymentRepository($conn);
$serviceRepo = new ServiceCategoryRepository($conn);

$acId = $acRepo->create($customerId, [
    'nickname' => trim((string) ($_POST['nickname'] ?? 'Main Unit')),
    'brand' => trim((string) ($_POST['brand'] ?? '')),
    'model' => trim((string) ($_POST['model'] ?? '')),
    'serial_number' => trim((string) ($_POST['serial_number'] ?? '')),
    'ac_type' => trim((string) ($_POST['ac_type'] ?? '')),
    'cooling_capacity' => trim((string) ($_POST['cooling_capacity'] ?? '')),
    'installation_date' => (string) ($_POST['installation_date'] ?? null),
    'installation_address' => trim((string) ($_POST['installation_address'] ?? '')),
    'notes' => trim((string) ($_POST['ac_notes'] ?? ''))
]);

$bookingId = $bookingRepo->create([
    'customer_id' => $customerId,
    'technician_id' => $technicianId,
    'air_conditioner_id' => $acId,
    'preferred_date' => $preferredDate,
    'preferred_time' => $preferredTime,
    'problem_description' => $problemDescription,
    'emergency' => $emergency
]);

$services = $serviceRepo->getActive();
$servicePriceMap = [];
foreach ($services as $service) {
    $servicePriceMap[(int) $service['id']] = (float) ($service['price'] ?? 0);
}

$total = 0;
foreach ($serviceIds as $serviceIdRaw) {
    $serviceId = (int) $serviceIdRaw;
    if ($serviceId > 0 && isset($servicePriceMap[$serviceId])) {
        $price = $servicePriceMap[$serviceId];
        $bookingRepo->attachService($bookingId, $serviceId, $price);
        $total += $price;
    }
}

$paymentRepo->createPending($bookingId, $total);

redirect('../../customer/dashboard.php?page=view_appointments&msg=Booking created. Please pay to continue');

