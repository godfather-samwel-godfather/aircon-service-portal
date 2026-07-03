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
        <a href="dashboard.php?page=users"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('users', $current_page) ?>">
            <i class="bi bi-people"></i>
            <span>Users</span>
        </a>
        <a href="dashboard.php?page=bookings"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('bookings', $current_page) ?>">
            <i class="bi bi-calendar-check"></i>
            <span>Bookings</span>
        </a>
        <a href="dashboard.php?page=technicians"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('technicians', $current_page) ?>">
            <i class="bi bi-tools"></i>
            <span>Technicians</span>
        </a>
        <a href="dashboard.php?page=services"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('services', $current_page) ?>">
            <i class="bi bi-grid"></i>
            <span>Services</span>
        </a>
        <a href="dashboard.php?page=messages"
            class="nav-link text-white d-flex align-items-center gap-3 <?= sidebarActive('messages', $current_page) ?>">
            <i class="bi bi-chat-left-text"></i>
            <span>Messages</span>
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
