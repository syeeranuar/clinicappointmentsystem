<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$sql = "SELECT * FROM clinics c ";
$search = "";
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= "WHERE (UPPER(c.c_name) LIKE UPPER('%$search%') OR "
            . "UPPER(c.c_address) LIKE UPPER('%$search%') OR "
            . "UPPER(c.c_notes) LIKE UPPER('%$search%')) ";
}
$sql .= "ORDER BY c.c_name ASC ";
$result = mysqli_query($conn, $sql);

$num_rows = mysqli_num_rows($result);
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-12 offset-0 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>List of Clinics</h3>
                
                <button type="button" class="btn btn-primary" onclick="window.location='add_clinic.php'">Add Clinic</button>
                <br />
                <br />
                <?php if (isset($_GET['error'])) { ?>
                <span class="alert alert-danger"><?= $_GET['error'] ?></span>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                <span class="alert alert-success"><?= $_GET['success'] ?></span>
                <?php } ?>
                
                <form action="list_clinics.php" method="POST">
                    <table class="table table-borderless">
                        <tr>
                            <td width="5%"><strong>Search</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td width="30%">
                                <input type="text" name="search" class="form-control" placeholder="Search here" value="<?=$search ?>" />
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" onclick="location.href='list_clinics.php'" class="btn btn-dark">Clear</button>
                            </td>
                        </tr>
                    </table>
                </form>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td><strong>NO.</strong></td>
                            <td><strong>NAME</strong></td>
                            <td width="40%"><strong>LOCATION ADDRESS</strong></td>
                            <td><strong>SPECIALITIES / NOTES</strong></td>
                            <td><strong>ACTION</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0) { for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) { ?>
                        <tr>
                            <td><?=$i ?>.</td>
                            <td><?=strtoupper($row['c_name']) ?>
                                <br />
                                <a href="<?=$row['c_logo'] ?>" target="_blank">
                                    <img src="<?=$row['c_logo'] ?>" class="img-thumbnail" style="max-height: 100px; max-width: 100px; margin-top: 10px;" />
                                </a>
                            </td>
                            <td>
                                <a href="https://www.google.com/maps/place/<?=$row['c_lat'] ?>,<?=$row['c_lon'] ?>" target="_blank">Open google maps</a>
                                <?=($row['c_address']!=""&&$row['c_address']!=null?'<br />'.strtoupper($row['c_address']):'') ?>
                            </td>
                            <td><?=($row['c_notes']!=""&&$row['c_notes']!=null?strtoupper($row['c_notes']):'N/A') ?></td>
                            <td>
                                <a onclick="return confirm('Are you sure want to delete this?')" href="remove_clinic_process.php?id=<?=$row['c_id'] ?>">
                                    <button type="button" class="btn btn-danger">X</button>
                                </a>
                            </td>
                        </tr>
                        <?php }} else { ?>
                        <tr>
                            <td colspan="6">
                                <center><i>.. No Data ..</i></center>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                Number of clinic: <?=$num_rows ?> clinic<?=($num_rows > 1)?('s'):('') ?>
                
            </center>
        </div>
    </div>
</div>