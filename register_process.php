<?php 
require("base_config.php");
require(BASE_DOC."/header.php");

$u_fullname = $_POST['fullname'];
$u_username = $_POST['username'];
$u_password = $_POST['password'];
$u_phone = $_POST['phone'];
$u_email = $_POST['email'];
$u_type = 'patient'; //$_POST['type'];

foreach ($_POST as $key=>$val) {
    if (($val == "" || $val == null) && $key != "phone" && $key != "email") {
        header("Location: ".BASE_URL."/register.php?error=Ops! Do not leave blank");
        die();
    }
}

$u_approved = $u_type == 'patient' ? '1' : '0';
$sql = "INSERT INTO users(u_fullname, u_username, u_password, u_type, u_approved, u_phone, u_email) "
        . "VALUES('$u_fullname', '$u_username', '$u_password', '$u_type', '$u_approved', '$u_phone', '$u_email')";

if (mysqli_query($conn, $sql)) {
    header("Location: ".BASE_URL."/index.php?success=Success register. Please log in");
} else {
    header("Location: ".BASE_URL."/register.php?error=Ops. Error: ".mysqli_error($conn));
}
?>