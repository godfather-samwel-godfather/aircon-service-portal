<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('technician');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../technician/dashboard.php?page=assigned_jobs');
}

$technicianRepo = new TechnicianRepository($conn);
$bookingRepo = new BookingRepository($conn);
$serviceResultRepo = new ServiceResultRepository($conn);

$tech = $technicianRepo->getByUserId(getCurrentUserId());
if (!$tech) {
    redirect('../../technician/dashboard.php?page=assigned_jobs&error=Technician profile not found');
}

$bookingId = (int) ($_POST['booking_id'] ?? 0);
$workReport = trim((string) ($_POST['work_report'] ?? ''));
$partsUsed = trim((string) ($_POST['parts_used'] ?? ''));

if ($bookingId <= 0 || $workReport === '') {
    redirect('../../technician/dashboard.php?page=upload_results&booking_id=' . $bookingId . '&error=Please provide the work report');
}

$booking = $bookingRepo->getById($bookingId);
if (!$booking || (int) $booking['technician_id'] !== (int) $tech['id']) {
    redirect('../../technician/dashboard.php?page=assigned_jobs&error=Booking not assigned to you');
}

if ($serviceResultRepo->existsForBooking($bookingId)) {
    redirect('../../technician/dashboard.php?page=view_booking_details&booking_id=' . $bookingId . '&error=Results already uploaded for this booking');
}

$uploadDir = __DIR__ . '/../../assets/uploads/service_results/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$beforeImage = null;
$afterImage = null;
$signatureImage = null;

if (!empty($_FILES['before_image']['tmp_name']) && is_uploaded_file($_FILES['before_image']['tmp_name'])) {
    $extension = pathinfo($_FILES['before_image']['name'], PATHINFO_EXTENSION);
    $filename = 'before_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    if (move_uploaded_file($_FILES['before_image']['tmp_name'], $uploadDir . $filename)) {
        $beforeImage = 'assets/uploads/service_results/' . $filename;
    }
}

if (!empty($_FILES['after_image']['tmp_name']) && is_uploaded_file($_FILES['after_image']['tmp_name'])) {
    $extension = pathinfo($_FILES['after_image']['name'], PATHINFO_EXTENSION);
    $filename = 'after_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    if (move_uploaded_file($_FILES['after_image']['tmp_name'], $uploadDir . $filename)) {
        $afterImage = 'assets/uploads/service_results/' . $filename;
    }
}

if (!empty($_FILES['signature_image']['tmp_name']) && is_uploaded_file($_FILES['signature_image']['tmp_name'])) {
    $extension = pathinfo($_FILES['signature_image']['name'], PATHINFO_EXTENSION);
    $filename = 'signature_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    if (move_uploaded_file($_FILES['signature_image']['tmp_name'], $uploadDir . $filename)) {
        $signatureImage = 'assets/uploads/service_results/' . $filename;
    }
}

$customerId = (int) $booking['customer_id'];
$serviceResultRepo->create(
    $bookingId,
    (int) $tech['id'],
    $customerId,
    $beforeImage,
    $afterImage,
    $workReport,
    $partsUsed,
    $signatureImage
);

$historyStmt = $conn->prepare(
    "INSERT INTO service_history
     (booking_id, technician_id, customer_id, service_date, work_done, remarks)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$serviceDate = $booking['preferred_date'] ?: date('Y-m-d');
$historyStmt->bind_param(
    "iiisss",
    $bookingId,
    $tech['id'],
    $customerId,
    $serviceDate,
    $workReport,
    $partsUsed
);
$historyStmt->execute();

$bookingRepo->updateStatus($bookingId, 'completed');

redirect('../../technician/dashboard.php?page=view_booking_details&booking_id=' . $bookingId . '&msg=Service results uploaded successfully');
