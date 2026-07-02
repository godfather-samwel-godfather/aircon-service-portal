<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/repositories/ServiceCategoryRepository.php';
$serviceRepo = new ServiceCategoryRepository($conn);
$services = $serviceRepo->getActive();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | AirCon Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>
<body>
    <?php include('shared/navbar.html'); ?>

    <section class="service-hero">
        <h1>Professional Air Conditioning Services</h1>
        <p>Book trusted HVAC experts for installation, repair and maintenance.</p>
        <a href="auth/register.php" class="book-main text-decoration-none">Book A Service</a>
    </section>

    <section class="services-container">
        <h2>Our Services</h2>
        <p class="subtitle">Available services are managed by admin from dashboard</p>
        <div class="services-grid">
            <?php if (empty($services)): ?>
                <div class="alert alert-warning w-100">No active services available yet.</div>
            <?php else: ?>
                <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <img src="<?= e($service['image'] ?: 'assets/images/hero.jpg') ?>" alt="<?= e($service['name']) ?>">
                        <div class="card-content">
                            <h3><?= e($service['name']) ?></h3>
                            <p><?= e($service['description'] ?: 'Professional AC service from verified technicians.') ?></p>
                            <div class="fw-bold mb-2"><?= number_format((float) $service['price'], 0) ?> TZS</div>
                            <a href="auth/login.php?redirect=create_appointment" class="btn btn-primary btn-sm">Book Now</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php include('shared/footer.html'); ?>
</body>
</html>