<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (isset($_POST['cid']) && !empty($_POST['cid'])) {

    $b_datetime = $_POST['bdatetime'];
    if ($b_datetime == "") {
        header("Location: add_booking.php?error=Do not leave blank on appointment date");
        die();
    }
    $todaytime = strtotime(date('Y-m-d H:i:s'));
    $chosentime = strtotime($b_datetime);
    $difftime = $chosentime - $todaytime;
    if ($difftime <= 60) {
        header("Location: add_booking.php?error=Appointment date and time should be at least 1 hour ahead");
        die();
    }

    $c_id = $_POST['cid'];
    $patient_id = $_SESSION['user']['u_id'];
    $patient_name = $_SESSION['user']['u_fullname'];
    $b_status = 'queue';
    $b_payment_status = 'paid';
    $b_status_datetime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO bookings(patient_id, b_datetime, b_status, b_status_datetime, b_payment_status, clinic_id) "
            . "VALUES('$patient_id', '$b_datetime', '$b_status', '$b_status_datetime', '$b_payment_status', '$c_id')";
    if (mysqli_query($conn, $sql)) {
        $b_id = mysqli_insert_id($conn);
        $sql = "SELECT u.u_fullname, u.u_email
            FROM users u, clinics_users cu
            WHERE u.u_id = cu.user_id AND cu.clinic_id = '$c_id'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) {
                $email = $row['u_email'];
                $name = $row['u_fullname'];
                $subject = "Clinic Appointment System - Queue Notification";
                $msg = "Dear " . strtoupper($name)
                    . ", <br /><br />A user named <strong>" . strtoupper($patient_name)
                    . "</strong> just book at your clinic. Please check booking <strong>ID " . $b_id
                    . "</strong> in the queue in <a href='" . $email_url . "'>this <strong>clinic system</strong></a>.";
                send_email($email, $subject, $msg);
            }
        }
        header("Location: appointment.php");
    } else {
        header("Location: add_booking.php?error=".mysqli_error($conn));
    }
} else {
    header("Location: add_booking.php?error=Undefined clinic id");
}
die();
?>
