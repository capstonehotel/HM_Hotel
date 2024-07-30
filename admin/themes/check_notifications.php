<?php
session_start();

$response = array('newBooking' => false);

// Check if there are new bookings that the admin hasn't viewed
if (!isset($_SESSION['booking_notification_viewed']) || $_SESSION['booking_notification_viewed'] == false) {
    $response['newBooking'] = true;
}

echo json_encode($response);
?>
