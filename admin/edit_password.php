<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");
?>

<style>
    form .row {
        margin-top: 20px;
    }
</style>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>Change Password</h3>
                
                <form action="edit_password_process.php" method="POST">
                    <input name="uid" type="hidden" value="<?=$_SESSION['user']['u_id']; ?>" />
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Username : </span></div>
                        <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?= strtoupper($_SESSION['user']['u_username']); ?></strong></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Current Password : </span></div>
                        <div class="col-md-5">
                            <input name="oldpassword" type="password" class="form-control" placeholder="Type of your current password here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">New Password : </span></div>
                        <div class="col-md-5">
                            <input name="newpassword" type="password" class="form-control" placeholder="Type of your new password here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Confirm New Password : </span></div>
                        <div class="col-md-5">
                            <input name="newpassword2" type="password" class="form-control" placeholder="Type of your new password again here" />
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-dark" onclick="window.location='profile.php'">Back</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-info">Reset</button>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <?php if (isset($_GET['error'])) { ?>
                            <span class="alert alert-danger"><?= $_GET['error'] ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </form>
                
            </center>
        </div>
    </div>
</div>