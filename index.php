<?php 
require("base_config.php");
require(BASE_DOC."/header.php"); 
session_destroy();
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>
                
                <h3>Log In</h3>

                <form action="login_process.php" method="POST">
                    <table class="table table-borderless">
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="username" class="form-control" placeholder="Type your username here" />
                            </td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>:</td>
                            <td>
                                <input type="password" name="password" class="form-control" placeholder="Type your password here" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <button type="submit" class="btn btn-success">Log In</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                                <br />
                                <br />
                                <a href="<?=BASE_URL ?>/register.php">Patient Registration</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            </td>
                            <td>
                                <?php if (isset($_GET['error'])) { ?>
                                <span class="alert alert-danger"><?=$_GET['error'] ?></span>
                                <?php } ?>
                                <?php if (isset($_GET['success'])) { ?>
                                <span class="alert alert-success"><?=$_GET['success'] ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </form>

            </center>
        </div>
    </div>
</div>
