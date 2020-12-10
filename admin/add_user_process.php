<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

foreach ($_POST as $key=>$val) {
    if (($val == "" || $val == null) && $key != "phone" && $key != "email") {
        header("Location: add_user.php?error=Ops! Do not leave blank");
        die();
    }
}

$u_fullname = $_POST['fullname'];
$u_username = $_POST['username'];
$u_password = $_POST['password'];
$u_type = 'clinic admin'; //$_POST['type'];
$c_id = $_POST['cid'];
$u_phone = $_POST['phone'];
$u_email = $_POST['email'];

$u_approved = '1'; //$u_type == 'patient' ? '1' : '0';
$sql = "INSERT INTO users(u_fullname, u_username, u_password, u_type, u_approved, u_phone, u_email) "
        . "VALUES('$u_fullname', '$u_username', '$u_password', '$u_type', '$u_approved', '$u_phone', '$u_email')";

if (mysqli_query($conn, $sql)) {
    $u_id = mysqli_insert_id($conn);
    $sql = "INSERT INTO clinics_users(user_id, clinic_id) VALUES('$u_id', '$c_id')";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_users.php?success=Success register the user");
    } else {
        header("Location: add_user.php?error=Ops. Error: ".mysqli_error($conn));
    }
} else {
    header("Location: add_user.php?error=Ops. Error: ".mysqli_error($conn));
}
die();
?>