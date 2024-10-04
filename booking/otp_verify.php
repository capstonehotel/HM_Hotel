<?php
session_start();
if (isset($_POST['otp'])) {
    $userOtp = $_POST['otp'];
    var_dump($userOtp); // Verify that the user-input OTP is being received correctly
    if (isset($_SESSION['otp']) && $_SESSION['otp'] !== '') {
        var_dump($_SESSION['otp']); // Verify that the OTP is being retrieved correctly from the session
        if ($userOtp == $_SESSION['otp']) {
            // OTP is valid, return success message
            echo 'valid';
        } else {
            // OTP is invalid, return error message
            echo 'invalid';
        }
    } else {
        echo 'OTP not found in session or OTP is empty'; // Handle the case where the OTP is not found in the session or OTP is empty
    }
}
?>