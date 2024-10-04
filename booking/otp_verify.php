<?php
// session_start(); // Start the session at the beginning

// Check if the form was submitted and OTP was entered
if (isset($_POST['submit']) && isset($_POST['otp'])) {
    
  // Check if OTP session key exists
  if (isset($_SESSION['otp'])) {
      
    if ($_POST['otp'] == $_SESSION['otp']) {
        // OTP verified, proceed with registration or other actions
        echo "OTP verified for user: " . $_SESSION['username'];
        // // Redirect to payment page
        // header('Location: index.php?view=payment');
        // exit();
        // header('Location: logininfo.php');
     
    }
      } else {
          echo "Invalid OTP. Please try again.";
      }
      
  } else {
      echo "OTP session expired. Please request a new OTP.";
  
} else {
  echo "Please enter the OTP.";
}
?>