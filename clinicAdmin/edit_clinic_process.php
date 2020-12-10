<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

// Composer uploader.
require(__DIR__.'/../vendor/autoload.php');
include '../config/settings.php';

foreach ($_POST as $key => $val) {
    if (($val == "" || $val == null) && $key != 'clat' && $key != 'clon' && $key != 'cnotes') {
        header("Location: edit_clinic.php?error=Ops! Do not leave blank");
        die();
    }
}

$c_id = $_POST['cid'];
$c_name = $_POST['cname'];
$c_address = $_POST['caddress'];
$c_notes = $_POST['cnotes'];
$c_lat = $_POST['clat'];
$c_lon = $_POST['clon'];
$c_logo = $_POST['c_logo'];
$clogo = $_FILES['clogo'];

if ($clogo['error'] == 0) {
    $imageFileType = $clogo['type'];
    $fileType = explode("/", $imageFileType);
    if ($fileType[0] == 'image') {
        
        // remove old image.
        $path1 = explode("/", $c_logo);
        $path2 = explode(".", $path1[sizeof($path1)-1]);
        $public_id = $path2[0];
        \Cloudinary\Uploader::destroy("clinic_appointment_system_syera/clinic_logo/".$public_id);
        
        // upload new image.
        $results = \Cloudinary\Uploader::upload($clogo['tmp_name'], [
                    "folder" => "clinic_appointment_system_syera/clinic_logo/"
        ]);
        
        if (isset($results['secure_url']) && !empty($results['secure_url'])) {
            $c_logo = $results['secure_url'];
        } else {
            header("Location: edit_clinic.php?error=Ops. Something wrong with the files server");
            die();
        }
    } else {
        header("Location: edit_clinic.php?error=Ops. Please upload image type only");
        die();
    }
}

$sql = "UPDATE clinics c SET c.c_name = '$c_name', c.c_address = '$c_address', "
        . "c.c_notes = '$c_notes', c.c_lat = '$c_lat', c.c_lon = '$c_lon', "
        . "c.c_logo = '$c_logo' "
        . "WHERE c.c_id = '$c_id'";

if (mysqli_query($conn, $sql)) {
    header("Location: clinic.php?success=Success update your clinic");
} else {
    header("Location: edit_clinic.php?error=Ops. Error: ".mysqli_error($conn));
}
die();
?>