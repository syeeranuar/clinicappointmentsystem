<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$sql = "SELECT * FROM users u "
        . "LEFT JOIN clinics_users cu ON cu.user_id = u.u_id "
        . "LEFT JOIN clinics c ON c.c_id = cu.clinic_id "
        . "WHERE u.u_type = 'clinic admin' ";
$search = "";
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= "AND (UPPER(c.c_name) LIKE UPPER('%$search%') OR "
            . "UPPER(u.u_fullname) LIKE UPPER('%$search%') OR "
            . "UPPER(u.u_username) LIKE UPPER('%$search%') OR "
            . "(UPPER('APPROVED') LIKE UPPER('%$search%') AND u.u_approved = 1) OR "
            . "(UPPER('PENDING') LIKE UPPER('%$search%') AND u.u_approved = 0)) ";
}
$sql .= "ORDER BY u.u_approved ASC, c.c_name ASC, u.u_fullname ASC";
$result = mysqli_query($conn, $sql);

$num_rows = mysqli_num_rows($result);
?>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-12 offset-0 card-body">
            <center>
                
                <?php require("nav_items.php"); ?>
                
                <h3>List of Clinic Admins</h3>
                
                <button type="button" class="btn btn-primary" onclick="window.location='add_user.php'">Add Clinic Admin</button>
                <br />
                <br />
                <?php if (isset($_GET['error'])) { ?>
                <span class="alert alert-danger"><?= $_GET['error'] ?></span>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                <span class="alert alert-success"><?= $_GET['success'] ?></span>
                <?php } ?>
                
                <form action="list_users.php" method="POST">
                    <table class="table table-borderless">
                        <tr>
                            <td width="5%"><strong>Search</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td width="30%">
                                <input type="text" name="search" class="form-control" placeholder="Search here" value="<?=$search ?>" />
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" onclick="location.href='list_users.php'" class="btn btn-dark">Clear</button>
                            </td>
                        </tr>
                    </table>
                </form>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td><strong>NO.</strong></td>
                            <td><strong>CLINIC</strong></td>
                            <td><strong>FULL NAME</strong></td>
                            <td><strong>USERNAME</strong></td>
                            <td><strong>STATUS</strong></td>
                            <td><strong>ACTION</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0) { for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) { ?>
                        <tr>
                            <td><?=$i ?>.</td>
                            <td><?=strtoupper($row['c_name']) ?></td>
                            <td><?=strtoupper($row['u_fullname']) ?></td>
                            <td><?=strtoupper($row['u_username']) ?></td>
                            <td><?=($row['u_approved']=="1")?("<span style='color: green;'>APPROVED</span>"):("<span style='color: red;'>PENDING</span>") ?></td>
                            <td>
                                <?php if ($row['u_approved'] == "0") { ?>
                                <a href="approve_user_process.php?id=<?=$row['u_id'] ?>">
                                    <button type="button" class="btn btn-success">Approve</button>
                                </a>
                                <?php } ?>
                                <a onclick="return confirm('Are you sure want to delete this?')" href="remove_user_process.php?id=<?=$row['u_id'] ?>">
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
                
                Number of users: <?=$num_rows ?> user<?=($num_rows > 1)?('s'):('') ?>
                
            </center>
        </div>
    </div>
</div>