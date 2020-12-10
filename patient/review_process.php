<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (!isset($_POST['cid']) || empty($_POST['cid'])) {
    header("Location: clinics.php?error=Access denied");
    die();
}
$c_id = $_POST['cid'];

foreach ($_POST as $key => $val) {
    if ($val == "" || $val == null) {
        header("Location: review.php?id=$c_id&error=Ops! Do not leave blank");
        die();
    }
}

$clinic_id = $_POST['cid'];
$user_id = $_POST['uid'];
$r_comment = $_POST['comment'];
$r_rating = $_POST['rating'];
$r_datetime = date('Y-m-d H:i:s');
$sql = "INSERT INTO reviews(r_comment, r_rating, user_id, r_datetime, clinic_id) "
        . "VALUES('$r_comment', '$r_rating', '$user_id', '$r_datetime', '$clinic_id')";
if (mysqli_query($conn, $sql)) {
    header("Location: review.php?id=$c_id");
} else {
    header("Location: review.php?id=$c_id&error=Ops. Error: " . mysqli_error($conn));
}
die();
?>
