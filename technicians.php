<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/repositories/TechnicianRepository.php';
$techRepo = new TechnicianRepository($conn);
$technicians = $techRepo->getApprovedForPublic();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technicians | AirCon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/style.css">
    <style>
    .hero-tech {
        background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url("assets/images/hero.jpg");
        background-size: cover;
        background-position: center;
        height: 420px;
        display: flex;
        align-items: center;
        color: white;
    }
    .tech-card { border-radius: 15px; overflow: hidden; transition: .3s; }
    .tech-card:hover { transform: translateY(-8px); }
    .tech-img { height: 230px; object-fit: cover; }
    .badge-verified { background: #198754; }
    </style>
</head>
<body>
    <?php include('shared/navbar.html'); ?>

    <section class="hero-tech">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Meet Our Certified HVAC Technicians</h1>
            <p class="lead">Profiles update automatically after admin approval.</p>
            <a href="auth/login.php?redirect=create_appointment" class="btn btn-primary px-4">Book Technician</a>
        </div>
    </section>

    <div class="container my-5">
        <h2 class="text-center fw-bold mb-5">Available Technicians</h2>
        <div class="row g-4">
            <?php if (empty($technicians)): ?>
                <div class="col-12">
                    <div class="alert alert-warning">No approved technicians available right now.</div>
                </div>
            <?php else: ?>
                <?php foreach ($technicians as $tech): ?>
                    <div class="col-md-4">
                        <div class="card shadow tech-card">
                            <img src="assets/images/hero.jpg" class="card-img-top tech-img" alt="Technician">
                            <div class="card-body">
                                <h5 class="fw-bold mb-2">
                                    <?= e($tech['full_name']) ?>
                                    <span class="badge badge-verified text-white ms-1">Verified</span>
                                </h5>
                                <p class="text-muted mb-2"><?= e($tech['specialization'] ?: 'General HVAC Specialist') ?></p>
                                <p class="mb-1"><i class="bi bi-geo-alt-fill text-primary"></i> <?= e($tech['service_radius'] ?: 'Tanzania') ?></p>
                                <p class="mb-3"><i class="bi bi-award-fill text-primary"></i> <?= e((string) ($tech['years_experience'] ?? 0)) ?> Years Experience</p>
                                <a href="auth/login.php?redirect=create_appointment" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include('shared/footer.html'); ?>
</body>
</html>

