<?php
session_start();
require_once("../../includes/config.php");
//load basic functions next so that everything after can use them
require_once("../../includes/functions.php");
//later here where we are going to put our class session
require_once("../../includes/session.php");
require_once("../../includes/user.php");
require_once("../../includes/pagination.php");
require_once("../../includes/paginsubject.php");
require_once("../../includes/accomodation.php");
require_once("../../includes/guest.php");
require_once("../../includes/reserve.php"); 
require_once("../../includes/setting.php");
//Load Core objects
require_once("../../includes/database.php"); // Ensure this file contains your DB credentials and connection logic

$response = array('newBooking' => false);

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if there are new bookings today that the admin hasn't viewed
$query = "SELECT COUNT(*) as newBookings FROM tblreservation WHERE DATE(TRANSDATE) = CURDATE() AND STATUS = 'pending'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($data['newBookings'] > 0 && (!isset($_SESSION['booking_notification_viewed']) || $_SESSION['booking_notification_viewed'] == false)) {
    $response['newBooking'] = true;
}

echo json_encode($response);

$conn->close();
?>
