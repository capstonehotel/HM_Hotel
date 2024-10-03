<?php
if ($_POST['otp'] == $_SESSION['otp']) {
    // OTP verified, proceed with registration
    // Further actions like account creation, login, etc.
    echo "OTP verified for user: " . $_SESSION['username'];
    // Redirect to the next page
    header('Location: next_page.php');
    exit();
} else {
    echo "Invalid OTP. Please try again.";
}
?>

<!-- Simple OTP Form -->
<form method="post" action="" id="otp-form">
    <label for="otp">Enter OTP:</label>
    <input type="text" name="otp" maxlength="6" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>

<!-- Modal for OTP Verification -->
<div class="modal fade" id="otp-modal" tabindex="-1" role="dialog" aria-labelledby="otp-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otp-modal-label">OTP Verification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please enter the OTP sent to your email address.</p>
                <form method="post" action="" id="otp-form-modal">
                    <label for="otp-modal">Enter OTP:</label>
                    <input type="text" name="otp" maxlength="6" required>
                    <button type="submit" name="verify_otp">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Show the modal for OTP verification
        $('#otp-modal').modal('show');
    });
</script>