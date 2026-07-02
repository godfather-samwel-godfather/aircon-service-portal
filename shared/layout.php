<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

include __DIR__ . "/head.php";

?>

<body>


    <?php include __DIR__ . "/topnav.php"; ?>


    <div class="d-flex dashboard-wrapper">


        <?php

        $role = $_SESSION['role'] ?? null;

        if ($role === "admin") {
            include __DIR__ . "/../sidebars/admin.php";
        } elseif ($role === "technician") {
            include __DIR__ . "/../sidebars/technician.php";
        } elseif ($role === "customer") {
            include __DIR__ . "/../sidebars/customer.php";
        } else {
            echo "Unauthorized access";
        }

        ?>





        <!-- CONTENT AREA -->

        <section class="main-content flex-grow-1 p-4">


            <?php


        if(isset($page_content) && file_exists($page_content)){


            include $page_content;


        }else{


            echo "<h4>Page not found</h4>";


        }


        ?>


        </section>



    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>