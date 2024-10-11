<?php


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $query = "SELECT * FROM tblguest WHERE VERIFICATION_TOKEN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Mark the email as verified
        $update_query = "UPDATE tblguest SET EMAIL_VERIFIED = 1 WHERE VERIFICATION_TOKEN = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Email Verified',
                text: 'Your email has been successfully verified. You can now log in.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'https://mcchmhotelreservation.com/login.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Token',
                text: 'The verification link is invalid or expired.'
            });
        </script>";
    }
}
?>
