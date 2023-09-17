<?php
session_start(); 

require('./../dbconnect.php');

if (isset($_SESSION['id'])) {
    session_destroy();
    header("Location:"."/auth/sign_in.php"); 
    exit(); 
}
?>