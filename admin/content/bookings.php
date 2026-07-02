<?php
$result = $conn->query("SELECT COUNT(*) AS c FROM bookings");
$total = $result ? (int) $result->fetch_assoc()['c'] : 0;
?>

<div class="dashboard-container">
    <div class="welcome-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="mb-3">Bookings Overview</h1>
                <p class="mb-0">Total bookings in the system at a glance.</p>
            </div>
            <div class="text-md-end">
                <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Admin Dashboard</span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold">Bookings Overview</h4>
        <p class="text-muted mb-2">Total bookings in system.</p>
        <h2 class="mb-0"><?= $total ?></h2>
    </div>
</div>

