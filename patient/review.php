<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: clinics.php?error=Access denied");
    die();
}

$c_id = $_GET['id'];
$sql = "SELECT * FROM clinics c WHERE c.c_id = '$c_id'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows <= 0) {
    header("Location: clinics.php?error=No clinic with that ID ".$c_id);
    die();
}
$row = mysqli_fetch_assoc($result);

$sqlr = "SELECT * FROM reviews r, users u "
        . "WHERE r.user_id = u.u_id "
        . "AND r.clinic_id = '$c_id' "
        . "GROUP BY r.r_id "
        . "ORDER BY r.r_datetime DESC";
$resultr = mysqli_query($conn, $sqlr);
$num_rowsr = mysqli_num_rows($resultr);

$resultrx = mysqli_query($conn, $sqlr);
$num_rowsrx = mysqli_num_rows($resultrx);
$avg_star = 0;
$total_star = 0;
$count_star = 0;
if ($num_rowsrx > 0) {
    while ($rowrx = mysqli_fetch_assoc($resultrx)) {
        $num_star = $rowrx['r_rating'];
        $total_star += $num_star;
        $count_star += 1;
    }
    $avg_star = (int) ($total_star / $count_star);
}
?>

<style>
    .comments {
        margin-top: 10px;
        border-style: solid;
        border-width: 1px;
        border-radius: 15px;
        padding: 15px;
        text-align: justify;
        border-color: rgba(0, 0, 0, 0.2);
    }
    .footer-comment {
        font-size: 12px;
        font-style: italic;
        margin-top: 7px;
    }
</style>

<div class="container" style="padding-top: 1%;">
    <div class="row card" style="padding-bottom: 100px;">
        <div class="col-md-10 offset-1 card-body">
            <center>

                <?php require("nav_items.php"); ?>

                <div class="row">
                    <div class="col-md-2">
                        <a href="clinics.php" class="left">
                            <button type="button" class="btn btn-dark left">Back</button>
                        </a>
                    </div>
                </div>

                <h3>Clinic Detail</h3>

                <?php if (isset($_GET['success'])) { ?>
                <span class="alert alert-success"><?= $_GET['success'] ?></span>
                <?php } ?>

                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Clinic Name : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['c_name']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Clinic Logo : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <a href="<?=$row['c_logo']; ?>" target="_blank">
                                <img src="<?=$row['c_logo']; ?>" class="img-thumbnail" style="max-height: 100px; max-width: 100px;" />
                            </a>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Average Rating : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <?php for ($star=1; $star<=$avg_star; $star++) { ?>
                            <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                            <?php } ?>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Address : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['c_address']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Notes / Speciality : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($row['c_notes']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Location : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <a href="https://www.google.com/maps/place/<?=$row['c_lat']; ?>,<?=$row['c_lon']; ?>" target="_blank">
                                Click here <br />
                                <img src="<?=BASE_URL; ?>/assets/images/google-maps-icon01.png" class="img-thumbnail" style="max-height: 50px; max-width: 50px;" />
                            </a>
                        </strong>
                    </div>
                </div>

                <hr />

                <h3>Clinic Reviews</h3>

                <?php if (isset($_GET['error'])) { ?>
                    <span class="alert alert-danger"><?= $_GET['error'] ?></span>
                <?php } ?>

                <form action="review_process.php" method="POST">
                    <input type="hidden" name="cid" value="<?=$c_id ?>" />
                    <input type="hidden" name="uid" value="<?=$_SESSION['user']['u_id'] ?>" />
                    <div class="row">
                        <div class="col-md-2 offset-1"><span class="float-right">Your comment : </span></div>
                        <div class="col-md-6">
                            <textarea name="comment" class="form-control" placeholder="What is your review about this clinic?"></textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-1"><span class="float-right">Your rating : </span></div>
                        <div class="col-md-6" style="text-align: left;">
                            <table>
                                <tr><td style="padding: 10px;">
                                  <label style="margin: 0px; padding: 0px; cursor: pointer; width: 100%;">
                                    <input type="radio" name="rating" value="1" checked />
                                        &nbsp;
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                </td></label></tr>
                                <tr><td style="padding: 10px;">
                                  <label style="margin: 0px; padding: 0px; cursor: pointer; width: 100%;">
                                    <input type="radio" name="rating" value="2" />
                                        &nbsp;
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                </td></label></tr>
                                <tr><td style="padding: 10px;">
                                  <label style="margin: 0px; padding: 0px; cursor: pointer; width: 100%;">
                                    <input type="radio" name="rating" value="3" />
                                        &nbsp;
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                </td></label></tr>
                                <tr><td style="padding: 10px;">
                                  <label style="margin: 0px; padding: 0px; cursor: pointer; width: 100%;">
                                    <input type="radio" name="rating" value="4" />
                                        &nbsp;
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                </td></label></tr>
                                <tr><td style="padding: 10px;">
                                  <label style="margin: 0px; padding: 0px; cursor: pointer; width: 100%;">
                                    <input type="radio" name="rating" value="5" />
                                        &nbsp;
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                    <img src="../assets/images/star-icon-01.png" style="max-width: 20px;" />
                                </td></label></tr>
                            </table>
                        </div>
                    </div>
                </form>

                <?php if ($num_rowsr > 0) { while ($rowr = mysqli_fetch_assoc($resultr)) { $num_star = $rowr['r_rating']; ?>
                <div class="row comments">
                    <div class="col-md-10 offset-1">
                        <strong><?=str_replace('\n', '<br />', $rowr['r_comment']) ?></strong>
                        <?php for ($star=1; $star<=$num_star; $star++) { ?>
                        <img src="../assets/images/star-icon-01.png" style="max-width: 10px;" />
                        <?php } ?>
                        <br />
                        <div class="footer-comment">Last review: <?=$rowr['r_datetime'] ?>, by <?=$rowr['u_fullname'] ?></div>
                    </div>
                </div>
                <?php }} else { ?>
                <div class="row comments">
                    <div class="col-md-10 offset-1">
                        <center>.. No reviews yet ..</center>
                    </div>
                </div>
                <?php } ?>

            </center>
        </div>
    </div>
</div>
