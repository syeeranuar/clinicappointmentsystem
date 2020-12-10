<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

// Composer uploader.
require(__DIR__.'/../vendor/autoload.php');
include '../config/settings.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $p_id = $_GET['id'];
    
    $sql = "SELECT * FROM payments p WHERE p.p_id = '$p_id'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $p_url = $row['p_url'];
        $booking_id = $row['booking_id'];
        $path1 = explode("/", $p_url);
        $path2 = explode(".", $path1[sizeof($path1)-1]);
        $public_id = $path2[0];
        
        $sql = "DELETE FROM payments WHERE p_id = '$p_id'";
        if (mysqli_query($conn, $sql)) {
            
            $sql = "SELECT * FROM payments p WHERE p.booking_id = '$booking_id'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows <= 0) {
                $sql = "UPDATE bookings SET b_payment_status = 'pending' WHERE b_id = '$booking_id'";
                mysqli_query($conn, $sql);
            }
            
            \Cloudinary\Uploader::destroy("clinic_appointment_system_syera/payments/" . $public_id);
            
            header("Location: add_payment.php?booking=$booking_id&success=Success remove the payment");
        } else {
            header("Location: add_payment.php?booking=$booking_id&error=Failed remove the payment. Error: " . mysqli_error($conn));
        }
    } else {
        header("Location: add_payment.php?booking=$booking_id&error=No payment with this ID - $p_id");
    }
} else {
    header("Location: add_payment.php?booking=$booking_id&error=Error remove the payment");
}
die();
?>