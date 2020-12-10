<?php 
require("base_config.php");
require(BASE_DOC."/header.php");

$u_username = $_POST['username'];
$u_password = $_POST['password'];

foreach ($_POST as $val) {
    if ($val == "" || $val == null) {
        header("Location: ".BASE_URL."/index.php?error=Ops! Do not leave blank");
        die();
    }
}

$sql = "SELECT * FROM users u 
        LEFT JOIN clinics_users cu ON cu.user_id = u.u_id 
        LEFT JOIN clinics c ON c.c_id = cu.clinic_id 
        WHERE u.u_username = '$u_username' AND u.u_password = '$u_password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    if ($row = mysqli_fetch_assoc($result)) {
        $u_type = $row['u_type'];
        $_SESSION['user'] = $row;
        $_SESSION['logged_in'] = true;
        $u_approved = $row['u_approved'];
        if ($u_approved == '0') {
            header("Location: ".BASE_URL."/index.php?error=Your account have not been approved yet. Please consult your system administrator");
        } else {
            switch ($u_type) {
                case 'administrator':
                    header("Location: ".BASE_URL."/admin/index.php");
                    break;
                case 'clinic admin':
                    header("Location: ".BASE_URL."/clinicAdmin/index.php");
                    break;
                case 'doctor':
                    header("Location: ".BASE_URL."/doctor/index.php");
                    break;
                case 'patient':
                    header("Location: ".BASE_URL."/patient/index.php");
                    break;
                default:
                    header("Location: ".BASE_URL."/index.php?error=Invalid user type for this account");
            }
        }
    } else {
        header("Location: ".BASE_URL."/index.php?error=Invalid username or password");
    }
} else {
    header("Location: ".BASE_URL."/index.php?error=Invalid username or password");
}
?>