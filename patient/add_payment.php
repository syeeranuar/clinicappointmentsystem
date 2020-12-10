<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (!isset($_GET['booking']) || empty($_GET['booking'])) {
    header("Location: add_booking.php?error=Access denied");
    die();
}

$booking_id = $_GET['booking'];
$sql = "SELECT * FROM bookings b, clinics c "
        . "WHERE b.clinic_id = c.c_id "
        . "AND b.b_id = '$booking_id'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows <= 0) {
    header("Location: add_booking.php?error=Invalid ID " . $booking_id);
    die();
}
$row = mysqli_fetch_assoc($result);

$sqlPayments = "SELECT * FROM payments p "
        . "WHERE p.booking_id = '$booking_id' "
        . "ORDER BY p.p_datetime ASC";
$resultPayments = mysqli_query($conn, $sqlPayments);
$numRowsPayments = mysqli_num_rows($resultPayments);
$totalPayments = 0.00;
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>

                <?php require("nav_items.php"); ?>

                <div class="row">
                    <div class="col-md-2">
                        <a href="appointment.php" class="left">
                            <button type="button" class="btn btn-dark left">Back</button>
                        </a>
                    </div>
                </div>

                <h3>Appointment Detail</h3>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Booking ID : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;">BOOK-<?=$row['b_id']; ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Booking Time : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=$row['b_datetime']; ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Booking Status : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['b_status']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Last Update : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=$row['b_status_datetime']; ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Clinic Name : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <?=strtoupper($row['c_name']); ?>
                            <br />
                            <a href="<?= $row['c_logo'] ?>" target="_blank">
                                <img src="<?= $row['c_logo'] ?>" class="img-thumbnail" style="max-height: 100px; max-width: 100px; margin-top: 10px;" />
                            </a>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Clinic Address : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <a href="https://www.google.com/maps/place/<?=$row['c_lat'] ?>,<?=$row['c_lon'] ?>" target="_blank">
                                <?=strtoupper($row['c_address']); ?>
                            </a>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Specialities / Notes : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['c_notes']); ?></strong></div>
                </div>

            </center>
        </div>
    </div>

    <div style="margin-top: 100px;"></div>
</div>
