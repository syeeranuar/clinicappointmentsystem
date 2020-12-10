<?php
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1 || $_SESSION['user']['u_type'] != 'doctor') {
    session_destroy();
    header("Location: ".BASE_URL."/index.php?error=Access denied");
}
?>