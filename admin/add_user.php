<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$sql = "SELECT * FROM clinics c ORDER BY c.c_name ASC";
$result = mysqli_query($conn, $sql);

$num_rows = mysqli_num_rows($result);
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>Add Clinic Admin</h3>
                
                <form action="add_user_process.php" method="POST">
                    <table class="table table-borderless">
                        <tr>
                            <td>Full Name</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="fullname" class="form-control" placeholder="Type clinic admin full name here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="username" class="form-control" placeholder="Type clinic admin username here" />
                            </td>
                        </tr>
                        <tr>
                            <td>New Password</td>
                            <td>:</td>
                            <td>
                                <input type="password" name="password" class="form-control" placeholder="Type clinic admin new password here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Clinic</td>
                            <td>:</td>
                            <td>
                                <select name="cid" class="form-control">
                                    <option value="">-- Select clinic --</option>
                                    <?php if (mysqli_num_rows($result) > 0) { for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) { ?>
                                    <option value="<?=$row['c_id'] ?>"><?=strtoupper($row['c_name']) ?></option>
                                    <?php }} ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Phone No. (Optional)</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="phone" class="form-control" placeholder="Type your phone number here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Email (Optional)</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="email" class="form-control" placeholder="Type your email address here" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <button type="button" class="btn btn-dark" onclick="window.location='list_users.php'">Back</button>
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