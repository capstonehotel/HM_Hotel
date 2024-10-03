<?php
session_start();

if (isset($_POST['submit'])) {
    $enteredOtp = $_POST['otp'];

    // Check if entered OTP matches the one stored in the session
    if ($enteredOtp == $_SESSION['otp']) {
        echo "OTP verified successfully!";
        
        // Proceed with the registration or further process
        // Redirect to payment or confirmation page
        redirect('index.php?view=payment');

    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
