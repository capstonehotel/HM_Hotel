<?php
session_start();

if (isset($_GET['viewed']) && $_GET['viewed'] == 'bookings') {
    $_SESSION['booking_notification_viewed'] = true;
}


if (isset($_GET['viewed']) && $_GET['viewed'] == 'chat') {
    $email = $_SESSION['email'];
    $sql = "UPDATE messages SET is_read = 1 WHERE user_email = '$email' AND is_read = 0";
    $conn->query($sql);
}

$response = array('success' => true);
echo json_encode($response);
?>
