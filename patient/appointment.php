<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$u_id = $_SESSION['user']['u_id'];
$sql = "SELECT * FROM clinics c, bookings b "
        . "WHERE c.c_id = b.clinic_id "
        . "AND b.patient_id = '$u_id' "
        . "GROUP BY b.b_id "
        . "ORDER BY b.b_datetime DESC";
$result = mysqli_query($conn, $sql);

$num_rows = mysqli_num_rows($result);
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-12 offset-0 card-body">
            <center>

                <?php require("nav_items.php"); ?>

                <h3>List of Appointments</h3>

                <button type="button" class="btn btn-primary" onclick="window.location='add_booking.php'">Book Appointment</button>
                <br />
                <br />
                <?php if (isset($_GET['error'])) { ?>
                <span class="alert alert-danger"><?= $_GET['error'] ?></span>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                <span class="alert alert-success"><?= $_GET['success'] ?></span>
                <?php } ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td><strong>NO.</strong></td>
                            <td><strong>CLINIC</strong></td>
                            <td><strong>APPOINTMENT DATE</strong></td>
                            <td><strong>QUEUE STATUS</strong></td>
                            <td><strong>ACTION</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0) { for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) { ?>
                        <tr>
                            <td><?=$i ?>.</td>
                            <td><?=strtoupper($row['c_name']) ?></td>
                            <td><?=strtoupper($row['b_datetime']) ?></td>
                            <td><?=strtoupper($row['b_status']) ?></td>
                            <td>
                                <a href="add_payment.php?booking=<?=$row['b_id'] ?>">
                                    <button type="button" class="btn btn-success">View</button>
                                </a>
                                <?php if (strtoupper($row['b_status']) == 'PENDING' || strtoupper($row['b_status']) == 'QUEUE') { ?>
                                <a onclick="return confirm('Are you sure want to remove this booking?')" href="remove_appointment.php?id=<?=$row['b_id'] ?>">
                                    <button type="button" class="btn btn-danger">Cancel</button>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>

                Number of appointments: <?=$num_rows ?> booking<?=($num_rows > 1)?('s'):('') ?>

            </center>
        </div>
    </div>
</div>
