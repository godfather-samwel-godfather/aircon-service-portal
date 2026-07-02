<!DOCTYPE html>
<html>

<head>

    <title>Login | AirCon</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/CSS/style.css">



    <style>
    body {

        min-height: 100vh;

        display: flex;

        flex-direction: column;

    }


    .login-card {

        border-radius: 15px;

        overflow: hidden;

    }


    .login-image {

        background-image: url("../assets/images/hero.jpg");

        background-size: cover;

        background-position: center;

        min-height: 500px;

    }

    .password-field .password-toggle {
        z-index: 5;
        text-decoration: none;
        padding: 0 12px;
    }

    .password-field .password-toggle:hover {
        color: #0d6efd !important;
    }
    </style>


</head>


<body class="bg-light">



    <!-- HEADER YAKO IWE HAPA -->
    <!-- NAVBAR -->
    <!-- INCLUDE NAVBAR -->
    <header class="bg-white shadow-sm sticky-top">

        <nav class="navbar navbar-expand-lg navbar-light container-fluid px-4 py-3">

            <!-- Logo -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../home.php">
                <img src="../assets/images/logoo.jpg" width="60" height="60" class="rounded-circle me-3 shadow-sm">

                <span class="d-flex flex-column lh-1">
                    <span class="fs-4">AirCon</span>
                    <small class="text-primary">Service</small>
                </span>
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>


            <!-- Links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                <ul class="navbar-nav align-items-center gap-3 fw-semibold">

                    <li class="nav-item">
                        <a class="nav-link" href="../home.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../our_services.php">Our Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../how_it_works.php">How it Works</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../technicians.php">Technicians</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../about_us.php">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../contact_us.php">Contact</a>
                    </li>


                    <li class="nav-item">
                        <span class="text-primary fw-bold">
                            <i class="bi bi-telephone-fill"></i>
                            +255 712 345 678
                        </span>
                    </li>


                    <li class="nav-item">
                        <a class="btn btn-outline-primary btn-sm px-3" href="register.php">
                            Register
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3" href="login.php">
                            LOGIN PANEL
                        </a>
                    </li>

                </ul>

            </div>

        </nav>

    </header>


    <div class="container my-5">


        <div class="row justify-content-center">


            <div class="col-md-9">



                <div class="card shadow login-card">


                    <div class="row g-0">



                        <!-- IMAGE LEFT -->

                        <div class="col-md-6 login-image">


                        </div>




                        <!-- LOGIN FORM RIGHT -->

                        <div class="col-md-6 p-5">


                            <h2 class="fw-bold text-center mb-3">

                                Welcome Back

                            </h2>



                            <p class="text-muted text-center mb-4">

                                Login to your AirCon account

                            </p>

                            <?php if (!empty($_GET['error'])): ?>
                            <div class="alert alert-danger py-2 small">
                                <?= htmlspecialchars($_GET['error']) ?>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($_GET['msg'])): ?>
                            <div class="alert alert-success py-2 small">
                                <?= htmlspecialchars($_GET['msg']) ?>
                            </div>
                            <?php endif; ?>

                            <?php $rememberEmail = $_COOKIE['remember_email'] ?? ''; ?>

                            <form action="login_process.php" method="POST">



                                <div class="mb-3">


                                    <label class="form-label">

                                        Email Address

                                    </label>


                                    <input type="email" name="email" class="form-control" placeholder="Enter your email"
                                        value="<?= htmlspecialchars($rememberEmail) ?>" required>


                                </div>






                                <div class="mb-3">

                                    <label class="form-label">Password</label>

                                    <div class="position-relative password-field">
                                        <input type="password" name="password" id="loginPassword" class="form-control pe-5"
                                            placeholder="Enter your password" required>
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted password-toggle" tabindex="-1" aria-label="Show password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe"
                                            value="1" <?= $rememberEmail ? 'checked' : '' ?>>
                                        <label class="form-check-label small" for="rememberMe">
                                            Remember me
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100 py-2">


                                    <i class="bi bi-box-arrow-in-right"></i>

                                    Login


                                </button>




                            </form>






                            <div class="text-center mt-4">


                                Don't have an account?


                                <a href="register.php" class="fw-bold text-decoration-none">

                                    Register

                                </a>



                            </div>




                        </div>



                    </div>



                </div>



            </div>


        </div>


    </div>





    <!-- FOOTER YAKO IWE HAPA -->
    <!-- INCLUDE FOOTER -->
    <!-- ================= FOOTER ================= -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">

        <div class="container">

            <div class="row gy-4">

                <!-- Company -->
                <div class="col-lg-4 col-md-6">

                    <a class="text-decoration-none text-white d-flex align-items-center mb-3" href="home.php">
                        <i class="bi bi-snowflake fs-2 text-primary me-2"></i>

                        <div>
                            <h4 class="mb-0 fw-bold">AirCon</h4>
                            <small class="text-secondary">Service Platform</small>
                        </div>
                    </a>

                    <p class="text-light">
                        Professional HVAC installation, repair and maintenance
                        booking platform. Find certified technicians, schedule
                        appointments and track your service history with ease.
                    </p>

                    <div class="mt-3">

                        <a href="#" class="text-white fs-5 me-3">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="#" class="text-white fs-5 me-3">
                            <i class="bi bi-twitter-x"></i>
                        </a>

                        <a href="#" class="text-white fs-5 me-3">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="#" class="text-white fs-5">
                            <i class="bi bi-linkedin"></i>
                        </a>

                    </div>

                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">

                    <h5 class="fw-bold mb-3">Quick Links</h5>

                    <ul class="list-unstyled">

                        <li class="mb-2">
                            <a href="../home.php" class="text-light text-decoration-none">Home</a>
                        </li>

                        <li class="mb-2">
                            <a href="../our_services.php" class="text-light text-decoration-none">Services</a>
                        </li>

                        <li class="mb-2">
                            <a href="../technicians.php" class="text-light text-decoration-none">Technicians</a>
                        </li>

                        <li class="mb-2">
                            <a href="../about_us.php" class="text-light text-decoration-none">About Us</a>
                        </li>

                        <li class="mb-2">
                            <a href="../contact_us.php" class="text-light text-decoration-none">Contact</a>
                        </li>

                    </ul>

                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">

                    <h5 class="fw-bold mb-3">Our Services</h5>

                    <ul class="list-unstyled">

                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            AC Installation
                        </li>

                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            AC Repair
                        </li>

                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Preventive Maintenance
                        </li>

                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Emergency HVAC Support
                        </li>

                    </ul>

                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">

                    <h5 class="fw-bold mb-3">Contact Us</h5>

                    <p>
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                        Dar es Salaam, Tanzania
                    </p>

                    <p>
                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                        info@airconservice.com
                    </p>

                    <p>
                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                        +255 712 345 678
                    </p>

                    <p>
                        <i class="bi bi-clock-fill text-primary me-2"></i>
                        Mon - Sun : 24/7 Support
                    </p>

                </div>

            </div>

            <hr class="border-secondary my-4">

            <!-- Bottom -->
            <div class="row align-items-center">

                <div class="col-md-6 text-center text-md-start">

                    <small class="text-secondary">
                        © 2026 AirCon Service Platform. All Rights Reserved.
                    </small>

                </div>

                <div class="col-md-6 text-center text-md-end">

                    <a href="#" class="text-secondary text-decoration-none me-3">
                        Privacy Policy
                    </a>

                    <a href="#" class="text-secondary text-decoration-none me-3">
                        Terms & Conditions
                    </a>

                    <a href="#" class="text-secondary text-decoration-none">
                        FAQs
                    </a>

                </div>

            </div>

        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.querySelectorAll('.password-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.closest('.password-field').querySelector('input');
            var icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });
    </script>

</body>


</html>