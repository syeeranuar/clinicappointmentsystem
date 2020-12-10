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
                
                <h3>Profile</h3>
                
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Full Name : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['u_fullname']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Username : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['u_username']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Password : </span></div>
                    <div class="col-md-5">
                        <strong class="float-left" style="text-align: left;">
                            <?php for ($i=0; $i<strlen($_SESSION['user']['u_password']); $i++) { echo "*"; } ?>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Account Role : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['u_type']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Phone No. : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['u_phone']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Email Address : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtolower($_SESSION['user']['u_email']); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-3"><span class="float-right">Major / Speciality : </span></div>
                    <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?=strtoupper($_SESSION['user']['u_notes']); ?></strong></div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-12">
                        <a href="edit_profile.php">
                            <button type="button" class="btn btn-primary">Edit Profile</button>
                        </a>
                        <a href="edit_password.php">
                            <button type="button" class="btn btn-dark">Change Password</button>
                        </a>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-12">
                        <?php if (isset($_GET['success'])) { ?>
                            <span class="alert alert-success"><?= $_GET['success'] ?></span>
                        <?php } ?>
                    </div>
                </div>
                
            </center>
        </div>
    </div>
</div>