<?php

require_once "config/db.php";


$full_name = "System Admin";
$email = "admin@aircon.com";
$phone = "0700000000";
$password = password_hash("Admin@123", PASSWORD_DEFAULT);
$role = "admin";
$status = "active";


$sql = "INSERT INTO users
(full_name,email,phone,password,role,status)

VALUES

(?,?,?,?,?,?)";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "ssssss",
    $full_name,
    $email,
    $phone,
    $password,
    $role,
    $status
);


if($stmt->execute()){

    echo "Admin created successfully";

}else{

    echo "Error: ".$conn->error;

}

?>