<?php
session_start();

if (isset($_POST['verify_otp'])) {
    $user_otp = $_POST['otp'];

    if ($user_otp == $_SESSION['otp']) {
        echo "OTP verified successfully!";
        // Proceed to next step, e.g., form submission confirmation
    } else {
        echo "Incorrect OTP. Please try again.";
    }
}
?>

<!-- Simple OTP Form -->
<form method="post" action="">
    <label for="otp">Enter OTP:</label>
    <input type="text" name="otp" maxlength="6" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
