<?php
require_once "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | AirCon Service</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/CSS/style.css">


    <style>
    body {

        background: #f1f8ff;

        font-family: 'Segoe UI', sans-serif;

    }



    .register-wrapper {

        min-height: 100vh;

        display: flex;

        align-items: center;

    }



    .card-box {

        border: none;

        border-radius: 25px;

        overflow: hidden;

        box-shadow: 0 15px 40px rgba(0, 0, 0, .15);

    }



    .left-panel {


        background:

            linear-gradient(rgba(0, 90, 180, .75),

                rgba(0, 90, 180, .75)),

            url("../assets/images/hero.jpg");


        background-size: cover;

        background-position: center;

        color: white;

        min-height: 600px;


        display: flex;

        align-items: center;

        justify-content: center;

        text-align: center;


    }



    .form-area {

        padding: 40px;

    }



    .form-control {

        border-radius: 12px;

        height: 48px;

    }



    textarea.form-control {

        height: 90px;

    }



    .role-fields {

        display: none;

    }



    .btn-register {

        background: #0066cc;

        border: none;

        border-radius: 12px;

        height: 50px;

    }

    .password-field .password-toggle {
        z-index: 5;
        text-decoration: none;
        padding: 0 12px;
    }

    .password-field .password-toggle:hover {
        color: #0066cc !important;
    }
    </style>


</head>


<body>


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





    <div class="container register-wrapper">


        <div class="row justify-content-center w-100">


            <div class="col-lg-10">


                <div class="card card-box">


                    <div class="row g-0">



                        <!-- LEFT -->

                        <div class="col-lg-5 left-panel">


                            <div>


                                <h1 class="fw-bold">

                                    <i class="bi bi-snow"></i>

                                    AirCon Service

                                </h1>


                                <p>

                                    Join our HVAC service platform

                                </p>


                            </div>


                        </div>





                        <!-- FORM -->


                        <div class="col-lg-7 form-area">



                            <h3 class="fw-bold mb-4">

                                Create Account

                            </h3>



                            <?php if(isset($_GET['error'])){ ?>

                            <div class="alert alert-danger">

                                <?=htmlspecialchars($_GET['error'])?>

                            </div>

                            <?php } ?>



                            <form method="POST" action="register_process.php" enctype="multipart/form-data" id="registerForm">





                                <label class="fw-bold">

                                    Account Type

                                </label>


                                <select id="role" name="role" class="form-select mb-3" onchange="toggleRole()" required>


                                    <option value="">Choose</option>


                                    <option value="customer">

                                        Customer

                                    </option>


                                    <option value="technician">

                                        Technician

                                    </option>


                                </select>





                                <div class="row">



                                    <div class="col-md-6 mb-3">

                                        <input class="form-control" name="full_name" placeholder="Full Name" required>

                                    </div>



                                    <div class="col-md-6 mb-3">

                                        <input class="form-control" name="phone" placeholder="Phone Number" required>

                                    </div>



                                    <div class="col-md-6 mb-3">

                                        <input type="email" class="form-control" name="email" placeholder="Email"
                                            required>

                                    </div>




                                    <div class="col-md-6 mb-3">

                                        <div class="position-relative password-field">
                                            <input type="password" class="form-control pe-5" name="password" id="registerPassword"
                                                placeholder="Password" minlength="6" required>
                                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted password-toggle" tabindex="-1" aria-label="Show password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <div class="position-relative password-field">
                                            <input type="password" class="form-control pe-5" name="confirm_password" id="confirmPassword"
                                                placeholder="Confirm Password" minlength="6" required>
                                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted password-toggle" tabindex="-1" aria-label="Show confirm password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="passwordMismatch">
                                            Passwords do not match.
                                        </div>

                                    </div>



                                </div>







                                <!-- CUSTOMER -->

                                <div id="customerFields" class="role-fields">


                                    <h6 class="fw-bold text-primary">

                                        Customer Information

                                    </h6>



                                    <input class="form-control mb-2" name="region" placeholder="Region">



                                    <input class="form-control mb-2" name="district" placeholder="District">



                                    <textarea class="form-control mb-2" name="street_address"
                                        placeholder="Street Address"></textarea>



                                    <label class="small">

                                        Profile Photo

                                    </label>


                                    <input type="file" class="form-control" name="profile_photo">


                                </div>








                                <!-- TECHNICIAN -->


                                <div id="technicianFields" class="role-fields">


                                    <h6 class="fw-bold text-primary">

                                        Technician Information

                                    </h6>




                                    <input class="form-control mb-2" name="company_name" placeholder="Company Name">





                                    <input type="number" class="form-control mb-2" name="years_experience"
                                        placeholder="Years Experience">






                                    <input class="form-control mb-2" name="license_number" placeholder="License Number">





                                    <input class="form-control mb-2" name="national_id" placeholder="National ID">





                                    <input class="form-control mb-2" name="specialization" placeholder="Specialization">





                                    <input class="form-control mb-2" name="service_radius" placeholder="Service Radius">






                                    <label class="small">

                                        Certificate File

                                    </label>


                                    <input type="file" class="form-control" name="certificate_file">


                                </div>






                                <button class="btn btn-primary w-100 mt-4 btn-register">


                                    Register


                                </button>





                                <div class="text-center mt-3">


                                    Already have account?


                                    <a href="login.php">

                                        Login

                                    </a>


                                </div>



                            </form>


                        </div>



                    </div>


                </div>


            </div>


        </div>


    </div>

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









    <script>
    function toggleRole() {


        let role = document.getElementById("role").value;


        document.getElementById("customerFields").style.display = "none";


        document.getElementById("technicianFields").style.display = "none";



        if (role == "customer") {


            document.getElementById("customerFields").style.display = "block";


        }



        if (role == "technician") {


            document.getElementById("technicianFields").style.display = "block";


        }



    }

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

    document.getElementById('registerForm').addEventListener('submit', function(e) {
        var password = document.getElementById('registerPassword');
        var confirm = document.getElementById('confirmPassword');

        if (password.value !== confirm.value) {
            e.preventDefault();
            confirm.classList.add('is-invalid');
            confirm.focus();
            return false;
        }

        confirm.classList.remove('is-invalid');
    });

    document.getElementById('confirmPassword').addEventListener('input', function() {
        var password = document.getElementById('registerPassword').value;
        if (this.value && this.value !== password) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    </script>



</body>

</html>