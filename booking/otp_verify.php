<?php
if (isset($_POST['otp'])) {
    $otp = $_POST['otp'];
    if ($otp == $_SESSION['otp']) {
        // OTP is valid, return success message
        echo 'valid';
    } else {
        // OTP is invalid, return error message
        echo 'invalid';
    }
}
?>