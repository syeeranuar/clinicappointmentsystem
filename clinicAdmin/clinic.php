<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>My Clinic</h3>
                
                <?php if (isset($_GET['success'])) { ?>
                <span class="alert alert-success"><?= $_GET['success'] ?></span>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Clinic Name : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['c_name']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Clinic Logo : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <a href="<?=$_SESSION['user']['c_logo']; ?>" target="_blank">
                                <img src="<?=$_SESSION['user']['c_logo']; ?>" class="img-thumbnail" style="max-height: 100px; max-width: 100px;" />
                            </a>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Address : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['c_address']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Notes / Speciality : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['c_notes']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Location : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <a href="https://www.google.com/maps/place/<?=$_SESSION['user']['c_lat']; ?>,<?=$_SESSION['user']['c_lon']; ?>" target="_blank">
                                Click here <br />
                                <img src="<?=BASE_URL; ?>/assets/images/google-maps-icon01.png" class="img-thumbnail" style="max-height: 50px; max-width: 50px;" />
                            </a>
                        </strong>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-12">
                        <a href="edit_clinic.php">
                            <button type="button" class="btn btn-primary">Edit Profile</button>
                        </a>
                    </div>
                </div>
                
            </center>
        </div>
    </div>
</div>