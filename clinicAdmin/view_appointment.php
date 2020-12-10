<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_appointments.php?error=Access denied");
    die();
}

$booking_id = $_GET['id'];
$sql = "SELECT * FROM bookings b, clinics c, users u "
        . "WHERE b.clinic_id = c.c_id "
        . "AND b.patient_id = u.u_id "
        . "AND b.b_id = '$booking_id'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows <= 0) {
    header("Location: list_appointments.php?error=Invalid ID " . $booking_id);
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
                        <a href="list_appointments.php" class="left">
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
                    <div class="col-md-3 offset-3"><span class="float-right">Full Name : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['u_fullname']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Username : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['u_username']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Phone No. : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['u_phone']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Email Address : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtolower($row['u_email']); ?></strong></div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <?php if (strtoupper($row['b_status']) == 'PENDING') { ?>
                        <?php if (strtoupper($row['b_payment_status']) == 'PAID') { ?>
                        <a onclick="return confirm('Are you sure want to proceed this appointment to doctor\'s queue?')" href="accept_appointment.php?id=<?=$row['b_id'] ?>">
                            <button type="button" class="btn btn-success">Proceed to Queue</button>
                        </a>
                        <?php } ?>
                        <a onclick="return confirm('Are you sure want to decline this appointment?')" href="remove_appointment.php?id=<?=$row['b_id'] ?>">
                            <button type="button" class="btn btn-danger">Decline</button>
                        </a>
                        <?php } ?>
                    </div>
                </div>

            </center>
        </div>
    </div>

    <div style="margin-top: 100px;"></div>
</div>
