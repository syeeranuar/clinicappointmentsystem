<?php 
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$id = $_GET['id'];
$sql = "UPDATE users u SET u.u_approved = '1' WHERE u.u_id = '$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: list_users.php?success=User has been update");
} else {
    header("Location: list_users.php?error=".mysqli_error($conn));
}
?>