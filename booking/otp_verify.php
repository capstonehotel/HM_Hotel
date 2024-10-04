<?php
session_start(); 
if (isset($_POST['otp'])) {
    $otp = $_POST['otp'];
    var_dump($_SESSION['otp']);
    if ($otp == $_SESSION['otp']) {
        // OTP is valid, return success message
        echo 'valid';
    } else {
        // OTP is invalid, return error message
        echo 'invalid';
    }
}
?>