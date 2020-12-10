<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM bookings WHERE b_id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: list_appointments.php?success=Success cancel the booking");
    } else {
        header("Location: list_appointments.php?error=Failed cancel the booking. Error: ".mysqli_error($conn));
    }
    
} else {
    header("Location: list_appointments.php?error=Error cancel the booking");
}
die();
?>