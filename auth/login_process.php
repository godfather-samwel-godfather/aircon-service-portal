<?php

session_start();


require_once "../config/db.php";

require_once "redirect.php";



if($_SERVER['REQUEST_METHOD'] !== 'POST'){

    header("Location: login.php");
    exit;

}



$email = trim($_POST['email'] ?? '');
$passwordRaw = $_POST['password'] ?? '';
$rememberMe = !empty($_POST['remember_me']);



$stmt = $conn->prepare(
    "SELECT * FROM users WHERE email=?"
);


$stmt->bind_param("s",$email);


$stmt->execute();


$result = $stmt->get_result();





if($result->num_rows == 0){


    header("Location: login.php?error=Invalid email or password");

    exit;

}




$user = $result->fetch_assoc();





if(!password_verify($passwordRaw,$user['password'])){


    header("Location: login.php?error=Invalid email or password");

    exit;

}






if($user['status'] == "blocked"){


    header("Location: login.php?error=Account blocked");

    exit;

}






/*
CREATE SESSION
*/


$_SESSION['user_id'] = $user['id'];

$_SESSION['name'] = $user['full_name'];

$_SESSION['role'] = $user['role'];

if ($rememberMe) {
    setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/', '', false, true);
} else {
    setcookie('remember_email', '', time() - 3600, '/', '', false, true);
}







/*
TECHNICIAN APPROVAL CHECK
*/


if($user['role'] == "technician"){


    $tech = $conn->prepare(
        "SELECT verification_status 
         FROM technicians 
         WHERE user_id=?"
    );


    $tech->bind_param("i",$user['id']);


    $tech->execute();


    $techResult = $tech->get_result();


    $technician = $techResult->fetch_assoc();




    if(!$technician || $technician['verification_status'] != "approved"){


        header("Location: /ACSS/airconservices_booking/technician/pending.php");

        exit;


    }


}





/*
REDIRECT BY ROLE
*/


$url = redirectAfterLogin(
    $user['role'],
    $_GET['redirect'] ?? null
);



header("Location: ".$url);


exit;



?>