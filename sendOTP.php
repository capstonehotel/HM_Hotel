<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure you have installed PHPMailer via composer or manually

if (isset($_POST['submit'])) {

    // Store form data
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['last'] = $_POST['last'];
    $_SESSION['email'] = $_POST['username'];
    // Other session values...

    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp; // Store OTP in session

    // Send OTP to email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                      // Send using SMTP
        $mail->Host       = 'mcchmhotelreservation.comm';   // Set your SMTP server
        $mail->SMTPAuth   = true;                             // Enable SMTP authentication
        $mail->Username   = 'mcchmhotelreservation@gmail.com';         // SMTP username
        $mail->Password   = 'bkdb giql jcxw mmcc';            // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption
        $mail->Port       = 587;                              // TCP port to connect

        //Recipients
        $mail->setFrom('mcchmhotelreservation@gmail.com', 'HM Hotel Reservation');
        $mail->addAddress($_POST['username']);                // User's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Dear " . $_POST['name'] . ",<br><br>Your OTP code is <b>" . $otp . "</b>.<br><br>Regards,<br>Hotel Name";

        $mail->send();
        echo 'OTP has been sent to your email.';

        // Redirect to OTP verification
        echo "<script>
                document.getElementById('otp-section').style.display = 'block';
                document.getElementById('email-msg').style.display = 'block';
              </script>";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Rest of the file upload and form submission code...
}
