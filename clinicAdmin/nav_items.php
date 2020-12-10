<h3>Clinic Admin</h3>

<div class="row">
    <div class="col-md-12">
        Welcome, <strong><?=$_SESSION['user']['u_fullname'] ?></strong>!
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!--[ <a href="index.php">Dashboard</a> ]-->
        [ <a href="clinic.php">My Clinic</a> ]
        [ <a href="list_doctors.php">Doctors</a> ]
        [ <a href="list_appointments.php">Appointments</a> ]
        [ <a href="report.php">Report</a> ]
        [ <a href="profile.php">Profile</a> ]
        [ <a href="<?= BASE_URL ?>/logout.php">Log Out</a> ]
    </div>
</div>

<hr />
