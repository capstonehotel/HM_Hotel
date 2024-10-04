<?php
session_start(); // Start the session at the beginning

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Set header for JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if(isset($_POST['name'], $_POST['last'], $_POST['username'])) {
        $name = trim($_POST['name']);
        $last = trim($_POST['last']);
        $email = trim($_POST['username']);

        // Basic validation
        if(empty($name) || empty($last) || empty($email)){
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit();
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
            exit();
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp; // Store OTP in session
        $_SESSION['username'] = $email; // Store email in session

        // Send OTP via PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';       
            $mail->SMTPAuth = true;
            $mail->Username = 'mcchmhotelreservation@gmail.com';  
            $mail->Password = 'bkdb giql jcxw mmcc'; // Consider using environment variables for security
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('mcchmhotelreservation@gmail.com', 'Hotel Reservation');
            $mail->addAddress($email, "$name $last"); 

            // Content
            $mail->isHTML(true);                                
            $mail->Subject = 'Your OTP for Hotel Reservation';
            $mail->Body    = "Hello $name,<br><br>Your OTP is: <b>$otp</b><br><br>Please enter this OTP to proceed.";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'OTP has been sent to your email.']);
        } catch (Exception $e) {
            // Log the error in server logs instead of exposing it to the user
            error_log("Mailer Error: " . $mail->ErrorInfo);
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP. Please try again later.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
