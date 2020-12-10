<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

foreach ($_POST as $key => $val) {
    if (($val == "" || $val == null) && $key != 'notes' && $key != 'phone' && $key != 'email') {
        header("Location: edit_profile.php?error=Ops! Do not leave blank");
        die();
    }
}

$u_id = $_POST['uid'];
$u_fullname = $_POST['fullname'];
$u_username = $_POST['username'];
$u_notes = $_POST['notes'];
$u_phone = $_POST['phone'];
$u_email = $_POST['email'];

$sql = "UPDATE users u "
        . "SET u.u_fullname = '$u_fullname', "
        . "u.u_username = '$u_username', "
        . "u.u_phone= '$u_phone', "
        . "u.u_email = '$u_email', "
        . "u.u_notes = '$u_notes' "
        . "WHERE u.u_id = '$u_id'";
if (mysqli_query($conn, $sql)) {
    $sql = "SELECT * FROM users u 
        LEFT JOIN clinics_users cu ON cu.user_id = u.u_id 
        LEFT JOIN clinics c ON c.c_id = cu.clinic_id 
        WHERE u.u_id = '$u_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['user'] = $row;
            header("Location: profile.php?success=Success change your profile");
        } else {
            header("Location: edit_profile.php?error=Ops. No data with that ID");
        }
    } else {
        header("Location: edit_profile.php?error=Ops. No data with that ID");
    }
} else {
    header("Location: edit_profile.php?error=Ops. Error: ".mysqli_error($conn));
}
die();
?>