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
                
                <h3>Add Clinic</h3>
                
                <form action="add_clinic_process.php" method="POST" enctype="multipart/form-data">
                    <table class="table table-borderless">
                        <tr>
                            <td>Clinic Name</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="cname" class="form-control" placeholder="Type the clinic name here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Logo / Image</td>
                            <td>:</td>
                            <td>
                                <input type="file" name="clogo" class="img-thumbnail" placeholder="Upload the clinic logo here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Specialities / Notes</td>
                            <td>:</td>
                            <td>
                                <textarea name="cnotes" class="form-control" placeholder="Type the clinic notes or its specialities here"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>
                                <textarea name="caddress" class="form-control" placeholder="Type the clinic address here"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="clat" class="form-control" placeholder="Type the clinic latitude here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="clon" class="form-control" placeholder="Type the clinic longitude here" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <button type="button" class="btn btn-dark" onclick="window.location='list_clinics.php'">Back</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            </td>
                            <td>
                                <?php if (isset($_GET['error'])) { ?>
                                <span class="alert alert-danger"><?=$_GET['error'] ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </form>
                
            </center>
        </div>
    </div>
</div>