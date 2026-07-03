<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow">

    <div class="container-fluid">



        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/ACSS/airconservices_booking/admin/dashboard.php">
            <img src="/ACSS/airconservices_booking/assets/images/logoo.jpg" width="50" height="50" class="rounded-circle me-3 shadow-sm">

            <span class="d-flex flex-column lh-1">
                <span class="fs-4">AirCon</span>
                <small class="text-primary">Service</small>
            </span>
        </a>





        <!-- Search -->

        <form class="d-none d-md-flex mx-auto w-50">


            <input class="form-control" type="search" placeholder="Search services, bookings...">


            <button class="btn btn-light ms-2">

                <i class="bi bi-search"></i>

            </button>


        </form>





        <!-- Right Side -->

        <div class="d-flex align-items-center gap-4 text-white">


            <!-- Notifications -->

            <div class="position-relative">


                <i class="bi bi-bell-fill fs-5"></i>


                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">


                    <?= $notification_count ?? 0 ?>


                </span>


            </div>





            <!-- User -->

            <div class="dropdown">


                <a class="text-white text-decoration-none dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown">


                    <i class="bi bi-person-circle fs-3"></i>


                </a>



                <ul class="dropdown-menu dropdown-menu-end">


                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-person"></i>

                            Profile

                        </a>

                    </li>



                    <li>

                        <hr class="dropdown-divider">

                    </li>




                    <li>

                        <a class="dropdown-item text-danger" href="/ACSS/airconservices_booking/auth/logout.php">

                            <i class="bi bi-box-arrow-right"></i>

                            Logout

                        </a>

                    </li>


                </ul>


            </div>



        </div>



    </div>

</nav>