<?php
unset($_SESSION['user']);
require("base_config.php");
require(BASE_DOC."/header.php");
session_destroy();
$msg = isset($_GET['msg']) && !empty($_GET['msg']) ? $_GET['msg'] : 'You have log out';
header("Location: index.php?success=".$msg)
?>
