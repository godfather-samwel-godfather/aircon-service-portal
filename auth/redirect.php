<?php

function redirectByRole(string $role): string
{

    switch($role){

        case "admin":
            return "../admin/dashboard.php";


        case "customer":
            return "../customer/dashboard.php?page=home";


        case "technician":
            return "../technician/dashboard.php";


        default:
            return "../auth/login.php";

    }

}



function redirectAfterLogin(string $role, ?string $redirectKey = null): string
{


    if($role === "customer" && $redirectKey){

        $allowed = [

            "create_appointment" => "../customer/dashboard.php?page=create_appointment",

            "view_appointments" => "../customer/dashboard.php?page=view_appointments"

        ];


        if(isset($allowed[$redirectKey])){

            return $allowed[$redirectKey];

        }

    }



    return redirectByRole($role);

}

?>