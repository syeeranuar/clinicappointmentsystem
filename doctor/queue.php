<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$u_id = $_SESSION['user']['u_id'];
$c_id = $_SESSION['user']['c_id'];
$sql = "SELECT * FROM bookings b, users u "
        . "WHERE b.patient_id = u.u_id "
        . "AND b.clinic_id = '$c_id' "
        . "AND b.b_status != 'pending' "
        . "GROUP BY b.b_id "
        . "ORDER BY b.b_datetime ASC ";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-12 offset-0 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>Queue</h3>
                
                <?php if (isset($_GET['error'])) { ?>
                <span class="alert alert-danger"><?= $_GET['error'] ?></span>
                <?php } ?>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td width="3%"><strong>NO.</strong></td>
                            <td width="20%"><strong>APPOINTMENT DATE/TIME</strong></td>
                            <td><strong>PATIENT</strong></td>
                            <td width="15%"><strong>STATUS</strong></td>
                            <td width="15%"><strong>ACTION</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0) { for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) { ?>
                        <tr>
                            <td><?=$i ?>.</td>
                            <td><?=$row['b_datetime'] ?></td>
                            <td>
                                <?=strtoupper($row['u_fullname']) ?><br />
                                <?=strtoupper($row['u_phone']) ?><br />
                                <?=strtolower($row['u_email']) ?><br />
                            </td>
                            <td><?=strtoupper($row['b_status']) ?></td>
                            <td>
                                <?php if (strtoupper($row['b_status']) == 'QUEUE') { ?>
                                <a onclick="return confirm('Are you sure want to consult this patient <?=strtoupper($row['u_fullname']) ?>?')" href="consult_process.php?id=<?=$row['b_id'] ?>">
                                    <button type="button" class="btn btn-primary">Consult</button>
                                </a>
                                <?php } else {
                                    $doctor_id = $row['doctor_id'];
                                    $sqld = "SELECT * FROM users u "
                                            . "WHERE u.u_id = '$doctor_id' "
                                            . "AND u.u_type = 'doctor'";
                                    $resultd = mysqli_query($conn, $sqld);
                                    $num_rowsd = mysqli_num_rows($resultd);
                                    $doctor_name = "N/A";
                                    if ($num_rowsd > 0) {
                                        $rowd = mysqli_fetch_assoc($resultd);
                                        $doctor_name = strtoupper($rowd['u_fullname']);
                                    }
                                ?>
                                <div class="alert-danger">
                                    <?=strtoupper($row['b_status']) ?> with <?=$doctor_name ?>
                                </div>
                                <?php if (strtoupper($row['b_status']) == 'CONSULT' && $u_id == $doctor_id) { ?>
                                <br />
                                <a onclick="return confirm('Are you done consulting this patient <?=strtoupper($row['u_fullname']) ?>?')" href="done_process.php?id=<?=$row['b_id'] ?>">
                                    <button type="button" class="btn btn-success">Mark as Done</button>
                                </a>
                                <?php }} ?>
                            </td>
                        </tr>
                        <?php }} else { ?>
                        <tr>
                            <td colspan="5" align="center">
                                <i>.. No queue yet ..</i>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                Number of appointment: <?=$num_rows ?> appointment<?=($num_rows > 1)?('s'):('') ?>
                
            </center>
        </div>
    </div>
</div>