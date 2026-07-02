<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "aircon_service_booking";


$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);


// Check connection

if($conn->connect_error){

    die("Database Connection Failed: " . $conn->connect_error);

}


// Set charset

$conn->set_charset("utf8mb4");


?>