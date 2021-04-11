<?php 
session_start();

if (!isset($_SESSION['admin'])){
    header("Location: request_login.php");
}
session_destroy();
unset($_SESSION['admin']);
header("Location: request_login.php");
?>