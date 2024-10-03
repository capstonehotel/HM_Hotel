<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Ensure PHPMailer is installed


    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mcchmhotelreservation.com';       // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'mcchmhotelreservation@gmail.com';  // SMTP username
        $mail->Password = 'bkdb giql jcxw mmcc';      // SMTP password or app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('mcchmhotelreservation@gmail.com', 'Hotel Reservation');
        $mail->addAddress('ungonkathleen@gmail.com', 'kath'); // Add recipient's email

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your OTP for Hotel Reservation';
        $mail->Body    = "Hello kath,<br><br>Your OTP is: <b>1233</b><br><br>Please enter this OTP to proceed.";

        $mail->send();
        echo 'OTP has been sent to your email.';

        // Redirect to the OTP input page (or update front-end accordingly)
        //header("Location: otp_verify.php");

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
