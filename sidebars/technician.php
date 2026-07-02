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
        <a href="dashboard.php?page=assigned_jobs"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('assigned_jobs', $current_page) ?>">
            <i class="bi bi-briefcase"></i>
            <span>Assigned Jobs</span>
        </a>
        <a href="dashboard.php?page=job_history"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('job_history', $current_page) ?>">
            <i class="bi bi-clock-history"></i>
            <span>Job History</span>
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
