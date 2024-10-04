<?php
// verify-otp.php


$enteredOtp = $_POST['otp'];
$storedOtp = $_SESSION['otp'];

if ($enteredOtp === $storedOtp) {
  echo 'true';
} else {
  echo 'false';
}
?>