<?php

session_start();

require_once __DIR__ . "/../config/db.php";



if($_SERVER['REQUEST_METHOD'] !== 'POST'){

    header("Location: register.php");
    exit;

}



$role = $_POST['role'];

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$passwordRaw = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($passwordRaw !== $confirmPassword) {
    header("Location: register.php?error=Passwords do not match");
    exit;
}

if (strlen($passwordRaw) < 6) {
    header("Location: register.php?error=Password must be at least 6 characters");
    exit;
}

$password = password_hash($passwordRaw, PASSWORD_DEFAULT);



/*
CHECK EMAIL
*/

$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s",$email);
$check->execute();

$result = $check->get_result();


if($result->num_rows > 0){

    header("Location: register.php?error=Email already exists");
    exit;

}



/*
DEFAULT STATUS

customer = active
technician = pending verification
*/

$status = ($role=="technician") ? "pending" : "active";



/*
INSERT USER
*/

$stmt = $conn->prepare("
INSERT INTO users
(full_name,email,phone,password,role,status)

VALUES(?,?,?,?,?,?)
");


$stmt->bind_param(
"ssssss",
$full_name,
$email,
$phone,
$password,
$role,
$status
);



$stmt->execute();



$user_id = $conn->insert_id;




/*
CUSTOMER DATA
*/

if($role=="customer"){


$region = $_POST['region'] ?? null;

$district = $_POST['district'] ?? null;

$street = $_POST['street_address'] ?? null;
$profilePhoto = null;

if (!empty($_FILES['profile_photo']['name'])) {
    $uploadDir = __DIR__ . '/../assets/uploads/profiles/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
    $filename = 'profile_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadDir . $filename)) {
        $profilePhoto = 'assets/uploads/profiles/' . $filename;
    }
}



$stmt = $conn->prepare("
INSERT INTO customers
(user_id,region,district,street_address,profile_photo)

VALUES(?,?,?,?,?)
");


$stmt->bind_param(
"issss",
$user_id,
$region,
$district,
$street,
$profilePhoto
);


$stmt->execute();



}





/*
TECHNICIAN DATA
*/

if($role=="technician"){



$company = $_POST['company_name'];

$experience = $_POST['years_experience'];

$license = $_POST['license_number'];

$national = $_POST['national_id'];

$special = $_POST['specialization'];

$radius = $_POST['service_radius'];
$certificate = null;

if (!empty($_FILES['certificate_file']['name'])) {
    $uploadDir = __DIR__ . '/../assets/uploads/certificates/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $ext = strtolower(pathinfo($_FILES['certificate_file']['name'], PATHINFO_EXTENSION));
    $filename = 'certificate_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    if (move_uploaded_file($_FILES['certificate_file']['tmp_name'], $uploadDir . $filename)) {
        $certificate = 'assets/uploads/certificates/' . $filename;
    }
}




$stmt=$conn->prepare("
INSERT INTO technicians

(user_id,
company_name,
years_experience,
license_number,
national_id,
specialization,
certificate_file,
service_radius)

VALUES(?,?,?,?,?,?,?,?)

");



$stmt->bind_param(
"isisssss",
$user_id,
$company,
$experience,
$license,
$national,
$special,
$certificate,
$radius
);



$stmt->execute();



}




header("Location: login.php?msg=Registration successful");

exit;

?>