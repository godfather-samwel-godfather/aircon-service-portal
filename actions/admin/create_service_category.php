<?php
require_once __DIR__ . '/../../includes/action_bootstrap.php';
requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../../admin/dashboard.php?page=services');
}

$name = trim((string) ($_POST['name'] ?? ''));
$description = trim((string) ($_POST['description'] ?? ''));
$price = (float) ($_POST['price'] ?? 0);

if ($name === '' || $price <= 0) {
    redirect('../../admin/dashboard.php?page=services&error=Name and price are required');
}

$imagePath = null;
if (!empty($_FILES['image']['name'])) {
    $uploadDir = __DIR__ . '/../../assets/uploads/services/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = 'service_' . time() . '_' . mt_rand(1000, 9999) . '.' . strtolower($ext);
    $fullPath = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
        $imagePath = 'assets/uploads/services/' . $filename;
    }
}

$repo = new ServiceCategoryRepository($conn);
$ok = $repo->create($name, $description, $price, $imagePath);

if (!$ok) {
    redirect('../../admin/dashboard.php?page=services&error=Failed to add service');
}

redirect('../../admin/dashboard.php?page=services&msg=Service added successfully');

