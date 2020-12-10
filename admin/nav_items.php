<h3>Administrator</h3>

<div class="row">
    <div class="col-md-12">
        Welcome, <strong><?=$_SESSION['user']['u_fullname'] ?></strong>!
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!--[ <a href="index.php">Dashboard</a> ]-->
        [ <a href="list_clinics.php">Clinics</a> ]
        [ <a href="list_users.php">Clinic Admins</a> ]
        [ <a href="profile.php">Profile</a> ]
        [ <a href="<?= BASE_URL ?>/logout.php">Log Out</a> ]
    </div>
</div>

<hr />