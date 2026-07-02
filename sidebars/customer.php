<?php
$current_page = $_GET['page'] ?? 'home';
require_once __DIR__ . '/../includes/helpers.php';
?>

<div class="sidebar d-none d-md-flex flex-column p-3 vh-100 position-fixed sidebar-bg text-white"
    style="width: 250px; top: 56px;">
    <div class="nav nav-pills flex-column mb-auto gap-1">

        <a href="dashboard.php?page=home"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('home', $current_page) ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="dashboard.php?page=create_appointment"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('create_appointment', $current_page) ?>">
            <i class="bi bi-plus-circle"></i>
            <span>Create Appointment</span>
        </a>
        <a href="dashboard.php?page=view_appointments"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('view_appointments', $current_page) ?>">
            <i class="bi bi-eye"></i>
            <span>View Appointments</span>
        </a>
        <a href="dashboard.php?page=view_service_results"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('view_service_results', $current_page) ?>">
            <i class="bi bi-check2-square"></i>
            <span>Service Results</span>
        </a>
        <a href="dashboard.php?page=fault_reports"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('fault_reports', $current_page) ?>">
            <i class="bi bi-exclamation-triangle"></i>
            <span>Fault Reports</span>
        </a>

        <a href="dashboard.php?page=appointment_history"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('appointment_history', $current_page) ?>">
            <i class="bi bi-clock-history"></i>
            <span>Appointment History</span>
        </a>

    </div>
    <div class="nav nav-pills flex-column mt-auto pb-5">
        <hr class="text-white-50">
        <a href="../auth/logout.php" class="nav-link text-white d-flex align-items-center gap-3">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>
</div>