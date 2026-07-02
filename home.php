<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AirCon Service | Professional HVAC Platform</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/CSS/style.css">
    <style>
    :root {
        --primary-color: #0d6efd;
        --dark-blue: #002366;
    }

    .hero-section {
        background: #f8f9fa;
        padding: 60px 0;
    }

    .feature-card {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border-radius: 15px;
    }

    .btn-custom {
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
    }

    .bg-dark-blue {
        background-color: var(--dark-blue);
        color: white;
    }

    /* --- Hero Section Styling --- */
    .hero-section {
        position: relative;
        /* Hakikisha njia ya picha (path) ni sahihi kwenye folder lako */
        background: url('assets/images/hero.jpg') no-repeat center center/cover;
        min-height: 80vh;
        /* Nimeipunguza kidogo ili isichukue skrini nzima kama unavyoona kwenye picha */
        display: flex;
        align-items: center;
        color: #ffffff;
        /* Maandishi yote ndani ya section yawe meupe */
    }

    /* Gradient Overlay - Inatengeneza 'opacity' juu ya picha */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        /* Gradient ya bluu iliyokolea kwenda iliyofifia */
        background: linear-gradient(90deg, rgba(1, 26, 64, 0.9) 0%, rgba(1, 26, 64, 0.4) 100%);
        z-index: 1;
        /* Inakaa nyuma ya maandishi lakini juu ya picha */
    }

    /* Kuhakikisha content inakaa juu ya overlay */
    .hero-section .container {
        position: relative;
        z-index: 2;
    }

    /* Styling ya Stat Items - Mstari wa wima na nafasi */
    .stat-item {
        border-left: 2px solid #ffffff;
        padding-left: 15px;
        margin-right: 20px;
    }

    .stat-item h5 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0;
    }

    .stat-item small {
        font-size: 0.85rem;
        opacity: 0.8;
    }

    /* Kurekebisha button ili iwe na muonekano wa kitaalamu */
    .btn-custom {
        padding: 12px 25px;
        font-weight: 600;
    }
    </style>
</head>

<body>

    <!-- INCLUDE NAVBAR -->
    <?php include('shared/navbar.html'); ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container position-relative">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6 text-white">
                    <span class="badge bg-primary mb-2">#1 HVAC SERVICE PLATFORM</span>
                    <h1 class="display-3 fw-bold mb-3">Professional Air Conditioning Installation & Repair Services</h1>
                    <p class="lead mb-4">At Your Doorstep. Find certified HVAC technicians, book maintenance, report AC
                        problems and track your service history easily.</p>

                    <div class="d-flex gap-3 mb-5">
                        <a href="our_services.php" class="btn btn-primary btn-lg px-4">Book Service Now</a>
                        <a href="technicians.php" class="btn btn-outline-light btn-lg px-4">Find Technician</a>
                    </div>

                    <div class="d-flex gap-4">
                        <div class="stat-item">
                            <h5>500+</h5><small>Happy Customers</small>
                        </div>
                        <div class="stat-item">
                            <h5>100+</h5><small>Certified Technicians</small>
                        </div>
                        <div class="stat-item">
                            <h5>1000+</h5><small>Services Completed</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="py-4 shadow-sm bg-white">
        <div class="container">
            <div class="row text-center">

                <div class="col-md-3 border-end">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="fs-2 text-primary"><i class="bi bi-person-badge"></i></div>
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Certified Technicians</h6>
                            <small class="text-muted">Verified & experienced</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 border-end">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="fs-2 text-primary"><i class="bi bi-lightning-charge"></i></div>
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Fast Response</h6>
                            <small class="text-muted">Same day service</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 border-end">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="fs-2 text-primary"><i class="bi bi-tools"></i></div>
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Installation & Repair</h6>
                            <small class="text-muted">Complete AC setup</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="fs-2 text-primary"><i class="bi bi-file-earmark-text"></i></div>
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Service History</h6>
                            <small class="text-muted">Track all services</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- How It Works Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">How It Works</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="p-4 border rounded shadow-sm">
                        <i class="bi bi-pencil-square fs-1 text-primary"></i>
                        <h5>Report Problem</h5>
                        <p class="text-muted">Tell us what's wrong with your AC</p>
                    </div>
                </div>


                <!-- Rudia kwa hatua nyingine -->
                <div class="col-md-3">
                    <div class="p-4 border rounded shadow-sm"><i class="bi bi-person-check fs-1 text-primary"></i>
                        <h5>Choose Technician</h5>
                        <p class="text-muted">Select from certified technicians</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 border rounded shadow-sm"><i class="bi bi-calendar-event fs-1 text-primary"></i>
                        <h5>Book Appointment</h5>
                        <p class="text-muted">Pick a date and time</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 border rounded shadow-sm"><i class="bi bi-check2-circle fs-1 text-primary"></i>
                        <h5>Get Service Done</h5>
                        <p class="text-muted">Technician gets the job done</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Services -->
    <section id="popular-services" class="py-5 bg-light">
        <div class="container">

            <h2 class="fw-bold text-center mb-5">Our Popular Services</h2>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="assets/images/install.jpg" class="card-img-top" alt="AC Installation">
                        <div class="card-body">
                            <h5 class="fw-bold">AC Installation</h5>
                            <ul class="list-unstyled text-muted small">
                                <li>✓ New AC installation</li>
                                <li>✓ AC replacement</li>
                                <li>✓ Site inspection</li>
                            </ul>
                            <a href="#" class="text-primary fw-bold text-decoration-none">Learn More →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="assets/images/repa.jpg" class="card-img-top" alt="AC Repair">
                        <div class="card-body">
                            <h5 class="fw-bold">AC Repair</h5>
                            <ul class="list-unstyled text-muted small">
                                <li>✓ Cooling problems</li>
                                <li>✓ Fault diagnosis</li>
                                <li>✓ Parts replacement</li>
                            </ul>
                            <a href="#" class="text-primary fw-bold text-decoration-none">Learn More →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="assets/images/menta.jpg" class="card-img-top" alt="AC Maintenance">
                        <div class="card-body">
                            <h5 class="fw-bold">AC Maintenance</h5>
                            <ul class="list-unstyled text-muted small">
                                <li>✓ AC cleaning</li>
                                <li>✓ Performance check</li>
                                <li>✓ Preventive maintenance</li>
                            </ul>
                            <a href="#" class="text-primary fw-bold text-decoration-none">Learn More →</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Technician Showcase -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Meet Our Certified Technicians</h2>
            <div class="row g-4">
                <!-- Technician 1 -->
                <div class="col-md-3">
                    <div class="card p-3 border-0 shadow-sm text-center">
                        <img src="assets/images/john.jpg" class="rounded-3 mb-3" width="100%">
                        <h6 class="fw-bold">John Mwangi</h6>
                        <small class="text-muted">8 Years Experience</small>
                        <div class="text-warning my-1"><i class="bi bi-star-fill"></i> 4.9 <small
                                class="text-muted">(120)</small></div>
                        <small class="text-muted">242 Jobs Completed</small>
                    </div>
                </div>
                <!-- Technician 2 -->
                <div class="col-md-3">
                    <div class="card p-3 border-0 shadow-sm text-center">
                        <img src="assets/images/peter.jpg" class="rounded-3 mb-3" width="100%">
                        <h6 class="fw-bold">Peter Hassan</h6>
                        <small class="text-muted">6 Years Experience</small>
                        <div class="text-warning my-1"><i class="bi bi-star-fill"></i> 4.8 <small
                                class="text-muted">(98)</small></div>
                        <small class="text-muted">180 Jobs Completed</small>
                    </div>
                </div>
                <!-- Technician 3 -->
                <div class="col-md-3">
                    <div class="card p-3 border-0 shadow-sm text-center">
                        <img src="assets/images/ali.jpg" class="rounded-3 mb-3" width="100%">
                        <h6 class="fw-bold">Ali Mohamed</h6>
                        <small class="text-muted">5 Years Experience</small>
                        <div class="text-warning my-1"><i class="bi bi-star-fill"></i> 4.9 <small
                                class="text-muted">(150)</small></div>
                        <small class="text-muted">310 Jobs Completed</small>
                    </div>
                </div>
                <!-- Technician 4 -->
                <div class="col-md-3">
                    <div class="card p-3 border-0 shadow-sm text-center">
                        <img src="assets/images/david.jpg" class="rounded-3 mb-3" width="100%">
                        <h6 class="fw-bold">David Kimaro</h6>
                        <small class="text-muted">7 Years Experience</small>
                        <div class="text-warning my-1"><i class="bi bi-star-fill"></i> 4.7 <small
                                class="text-muted">(80)</small></div>
                        <small class="text-muted">160 Jobs Completed</small>
                    </div>
                </div>
            </div>
            <!-- View All Button -->
            <div class="text-center mt-5">
                <a href="technicians.php" class="btn btn-primary px-4 rounded-pill">View All Technicians</a>
            </div>
        </div>
    </section>



    <!-- Emergency CTA Section -->

    <section class="py-5 bg-light">

        <div class="container">

            <div class="cta-emergency rounded-4 shadow overflow-hidden">

                <div class="row align-items-center p-5">

                    <div class="col-lg-7">
                        <h2 class="fw-bold text-white">
                            AC Not Working? Don't Sweat It.
                        </h2>

                        <p class="text-white mb-0">
                            We offer emergency AC repair services.
                            Our technicians are ready to help you!
                        </p>
                    </div>

                    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                        <a href="#" class="btn btn-warning btn-lg px-5">
                            Request Emergency Service
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Customer Reviews -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">What Our Customers Say</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <p class="text-muted">"Excellent service! Technician arrived on time and fixed my AC quickly.
                            Very professional."</p>
                        <strong class="mt-auto">- Grace Mosha.</strong>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <p class="text-muted">"Great experience from booking to service. My AC is working like new
                            again. Highly recommended!"</p>
                        <strong class="mt-auto">- James Kilewe.</strong>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <p class="text-muted">"Very nice platform, easy to book and track service history. I will use
                            again for sure."</p>
                        <strong class="mt-auto">- Amina Hunzi.</strong>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i></div>
                        <p class="text-muted">"Quick response and affordable prices. The technician was friendly and
                            knowledgeable."</p>
                        <strong class="mt-auto">- Brian Omary.</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- INCLUDE FOOTER -->
    <?php include('shared/footer.html'); ?>


    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>