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
                
                <h3>Edit My Clinic</h3>
                
                <form action="edit_clinic_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="cid" value="<?=$_SESSION['user']['c_id']; ?>" />
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Clinic Name : </span></div>
                        <div class="col-md-5">
                            <input name="cname" type="text" value="<?= strtoupper($_SESSION['user']['c_name']); ?>" class="form-control" placeholder="Type the clinic name here" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Clinic Logo : </span></div>
                        <div class="col-md-5">
                            <strong class="float-left" style="text-align: left;">
                                <a href="<?= $_SESSION['user']['c_logo']; ?>" target="_blank">
                                    <img src="<?= $_SESSION['user']['c_logo']; ?>" class="img-thumbnail" style="max-height: 100px; max-width: 100px;" />
                                </a>
                                <input type="file" name="clogo" class="img-thumbnail" />
                                <input type="hidden" name="c_logo" value="<?= $_SESSION['user']['c_logo']; ?>" />
                            </strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Address : </span></div>
                        <div class="col-md-5">
                            <textarea name="caddress" class="form-control" placeholder="Type the clinic address here" rows="5"><?= strtoupper($_SESSION['user']['c_address']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Notes / Speciality : </span></div>
                        <div class="col-md-5">
                            <textarea name="cnotes" class="form-control" placeholder="Type the clinic expertise here" rows="4"><?= strtoupper($_SESSION['user']['c_notes']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-3"><span class="float-right">Location : </span></div>
                        <div class="col-md-5">
                            <input name="clat" type="text" value="<?= $_SESSION['user']['c_lat']; ?>" class="form-control" placeholder="Type the clinic latitude here" />
                            <input name="clon" type="text" value="<?= $_SESSION['user']['c_lon']; ?>" class="form-control" placeholder="Type the clinic longitude here" />
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-dark" onclick="window.location='clinic.php'">Back</button>
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