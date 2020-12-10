<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

// Composer uploader.
require(__DIR__.'/../vendor/autoload.php');
include '../config/settings.php';

if (!isset($_POST['booking_id']) || empty($_POST['booking_id'])) {
    header("Location: add_booking.php?error=Access denied");
    die();
}
$booking_id = $_POST['booking_id'];

foreach ($_POST as $key => $val) {
    if ($val == "" || $val == null) {
        header("Location: add_payment.php?booking=$booking_id&error=Ops! Do not leave blank");
        die();
    }
}

$purl = $_FILES['purl'];
$p_price = $_POST['pprice'];
$p_datetime = date('Y-m-d H:i:s');

if ($purl['error'] != 0) {
    header("Location: add_payment.php?booking=$booking_id&error=Ops! Please upload something");
    die();
}
if (!is_numeric($p_price)) {
    header("Location: add_payment.php?booking=$booking_id&error=Ops! Invalid format for the paid price");
    die();
}

$imageFileType = $purl['type'];
$fileType = explode("/", $imageFileType);

$results = \Cloudinary\Uploader::upload($purl['tmp_name'], [
    "folder" => "clinic_appointment_system_syera/payments/"
]);

if (isset($results['secure_url']) && !empty($results['secure_url'])) {
    $p_url = $results['secure_url'];

    $sql = "INSERT INTO payments(booking_id, p_url, p_price, p_datetime) "
            . "VALUES('$booking_id', '$p_url', '$p_price', '$p_datetime')";
    if (mysqli_query($conn, $sql)) {
        
        $sql = "UPDATE bookings SET b_payment_status = 'paid' WHERE b_id = '$booking_id'";
        if (mysqli_query($conn, $sql)) {
            
            header("Location: add_payment.php?booking=$booking_id&success=Success booking for the appointment");
        } else {
            header("Location: add_payment.php?booking=$booking_id&error=Ops. Error: " . mysqli_error($conn));
        }
    } else {
        header("Location: add_payment.php?booking=$booking_id&error=Ops. Error: " . mysqli_error($conn));
    }
} else {
    header("Location: add_payment.php?booking=$booking_id&error=Ops. Something wrong with the files server");
}
die();
?>