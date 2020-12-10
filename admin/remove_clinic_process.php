<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

// Composer uploader.
require(__DIR__.'/../vendor/autoload.php');
include '../config/settings.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM clinics c WHERE c.c_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        
        $c_logo = "";
        for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) {
            $c_logo = $row['c_logo'];
        };
        $path1 = explode("/", $c_logo);
        $path2 = explode(".", $path1[sizeof($path1)-1]);
        $public_id = $path2[0];
        
        $sql = "SELECT user_id FROM clinics_users WHERE clinic_id = '$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $u_id = $row['user_id'];
                $sqlInner = "DELETE FROM users WHERE u_id = '$u_id' AND u_type IN ('clinic admin', 'doctor')";
                mysqli_query($conn, $sqlInner);
            }
        }

        $sql = "DELETE FROM clinics WHERE c_id = '$id'";
        if (mysqli_query($conn, $sql)) {
            $sql = "DELETE FROM clinics_users WHERE clinic_id = '$id'";
            if (mysqli_query($conn, $sql)) {
                
                \Cloudinary\Uploader::destroy("clinic_appointment_system_syera/clinic_logo/" . $public_id);

                header("Location: list_clinics.php?success=Success remove the clinic");
            } else {
                header("Location: list_clinics.php?error=Failed remove the clinic. Error: ".mysqli_error($conn));
            }
        } else {
            header("Location: list_clinics.php?error=Failed remove the clinic. Error: ".mysqli_error($conn));
        }
    } else {
        header("Location: list_clinics.php?error=No clinic with this ID - $id");
    }
} else {
    header("Location: list_clinics.php?error=Error remove the clinic");
}
die();
?>