<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

header("Location: queue.php");
die();
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>Dashboard</h3>
                
            </center>
        </div>
    </div>
</div>