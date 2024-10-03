// otp_verify.php
<?php
session_start();
if ($_POST['otp'] == $_SESSION['otp']) {
    echo "OTP verified for user: " . $_SESSION['username'];
    // Further actions like account creation, login, etc.
} else {
    echo "Invalid OTP. Please try again.";
}
?>

<!-- Simple OTP Form -->
<form method="post" action="">
    <label for="otp">Enter OTP:</label>
    <input type="text" name="otp" maxlength="6" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
