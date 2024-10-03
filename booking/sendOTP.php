<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Ensure PHPMailer is installed
// Include PHPMailer files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    // Store form data in session
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['last'] = $_POST['last'];
    $_SESSION['email'] = $_POST['username'];

    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp; // Store OTP in session

    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';       // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'mcchmhotelreservation@gmail.com';  // SMTP username
        $mail->Password = 'bkdb giql jcxw mmcc';      // SMTP password or app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('mcchmhotelreservation@gmail.com', 'Hotel Reservation');
        $mail->addAddress($_SESSION['email'], $_SESSION['name']); // Add recipient's email

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your OTP for Hotel Reservation';
        $mail->Body    = "Hello {$_POST['name']},<br><br>Your OTP is: <b>{$otp}</b><br><br>Please enter this OTP to proceed.";

        $mail->send();
        echo 'OTP has been sent to your email.';

        // Redirect to the OTP input page (or update front-end accordingly)
        header("Location: https://mcchmhotelreservation.com/booking/index.php?view=logininfo.php");

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
