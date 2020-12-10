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
                
                <h3>Edit Profile</h3>
                
                <form action="edit_profile_process.php" method="POST">
                    <input name="uid" type="hidden" value="<?=$_SESSION['user']['u_id']; ?>" />
                    <div class="row">
                        <div class="col-md-2 offset-4"><span class="float-right">Full Name : </span></div>
                        <div class="col-md-5">
                            <input name="fullname" type="text" value="<?= strtoupper($_SESSION['user']['u_fullname']); ?>" class="form-control" placeholder="Type your full name here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-4"><span class="float-right">Username : </span></div>
                        <div class="col-md-5">
                            <input name="username" type="text" value="<?=$_SESSION['user']['u_username']; ?>" class="form-control" placeholder="Type your username here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-4"><span class="float-right">Phone No. (Optional) : </span></div>
                        <div class="col-md-5">
                            <input name="phone" type="text" value="<?=$_SESSION['user']['u_phone']; ?>" class="form-control" placeholder="Type your phone number here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-4"><span class="float-right">Email Address (Optional) : </span></div>
                        <div class="col-md-5">
                            <input name="email" type="text" value="<?=$_SESSION['user']['u_email']; ?>" class="form-control" placeholder="Type your email address here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-4"><span class="float-right">Account Role : </span></div>
                        <div class="col-md-5"><strong class="float-left" style="text-align: left;"><?= strtoupper($_SESSION['user']['u_type']); ?></strong></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-4"><span class="float-right">Notes : </span></div>
                        <div class="col-md-5">
                            <textarea name="notes" class="form-control" placeholder="Type your notes / speciality here"><?= strtoupper($_SESSION['user']['u_notes']); ?></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-dark" onclick="window.location='profile.php'">Back</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-info">Reset</button>
                            <button type="button" class="btn btn-link" id="btn-clear">Clear</button>
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

<script>
    $(document).ready(function() {
        $("#btn-clear").click(function() {
            $("input, textarea").val("");
            $("input[type='text']").first().focus();
        });
    });
</script>