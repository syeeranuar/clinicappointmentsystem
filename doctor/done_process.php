<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: queue.php?error=Access denied");
    die();
}

$u_id = $_SESSION['user']['u_id'];

$b_id = $_GET['id'];
$b_status_datetime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM bookings b "
        . "WHERE b.b_id = '$b_id' "
        . "AND b.b_status = 'consult' ";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows > 0) {
    $sql = "UPDATE bookings "
            . "SET b_status = 'done' "
            . ", b_status_datetime = '$b_status_datetime' "
            . ", doctor_id = '$u_id' "
            . "WHERE b_id = '$b_id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: queue.php");
    } else {
        header("Location: queue.php?error=Ops. Error: " . mysqli_error($conn));
    }
} else {
    header("Location: queue.php?error=No appointment with this ID " . $b_id);
}
die();
?>