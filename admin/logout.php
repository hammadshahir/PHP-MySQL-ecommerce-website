<?php 
ob_start();
session_start();
include 'inc/config.php'; 
unset($_SESSION['user']);
header("location: login.php"); 
?>