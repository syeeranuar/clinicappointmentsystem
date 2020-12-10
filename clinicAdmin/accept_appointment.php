<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $b_id = $_GET['id'];
    $b_status_datetime = date('Y-m-d H:i:s');
    $sql = "UPDATE bookings "
            . "SET b_status = 'queue' "
            . ", b_status_datetime = '$b_status_datetime' "
            . "WHERE b_id = '$b_id' ";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_appointment.php?id=$b_id");
    } else {
        header("Location: view_appointment.php?id=$b_id&error=Failed proceeding this appointment to queue. Error: ".mysqli_error($conn));
    }
    
} else {
    header("Location: list_appointments.php?error=Access denied");
}
die();
?>