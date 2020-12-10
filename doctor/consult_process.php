<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: queue.php?error=Access denied");
    die();
}

$u_id = $_SESSION['user']['u_id'];
$dr_name = $_SESSION['user']['u_fullname'];

$b_id = $_GET['id'];
$b_status_datetime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM bookings b, users u "
        . "WHERE b.patient_id = u.u_id "
        . "AND b.b_id = '$b_id' "
        . "AND b.b_status = 'queue' ";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['u_email'];
    $name = $row['u_fullname'];
    $b_id = $row['b_id'];
    $email_url = $_SERVER['HTTP_REFERER'];
    $sql = "UPDATE bookings "
            . "SET b_status = 'consult' "
            . ", b_status_datetime = '$b_status_datetime' "
            . ", doctor_id = '$u_id' "
            . "WHERE b_id = '$b_id'";
    if (mysqli_query($conn, $sql)) {
        $subject = "Clinic Appointment System - Queue Notification";
        $msg = "Dear " . strtoupper($name)
            . ", <br /><br />A doctor named <strong>" . strtoupper($dr_name)
            . "</strong> just accept your booking on <strong>ID " . $b_id
            . "</strong>. Please login into <a href='" . $email_url . "'>this <strong>clinic system</strong></a> to see it.";
        send_email($email, $subject, $msg);
        header("Location: queue.php");
    } else {
        header("Location: queue.php?error=Ops. Error: " . mysqli_error($conn));
    }
} else {
    header("Location: queue.php?error=No appointment with this ID " . $b_id);
}
die();
?>
