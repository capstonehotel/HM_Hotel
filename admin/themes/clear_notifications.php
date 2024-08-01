<?php
session_start();
require_once("../includes/config.php");
//load basic functions next so that everything after can use them
require_once("../includes/functions.php");
//later here where we are going to put our class session
require_once("../includes/session.php");
require_once("../includes/user.php");
require_once("../includes/pagination.php");
require_once("../includes/paginsubject.php");
require_once("../includes/accomodation.php");
require_once("../includes/guest.php");
require_once("../includes/reserve.php"); 
require_once("../includes/setting.php");
//Load Core objects
require_once("../includes/database.php");// Ensure this file contains your DB credentials and connection logic

if (isset($_GET['viewed'])) {
    if ($_GET['viewed'] == 'bookings') {
        $_SESSION['booking_notification_viewed'] = true;
    }

    if ($_GET['viewed'] == 'chat') {
        $email = $_SESSION['email'];
        $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE messages SET is_read = 1 WHERE user_email = '$email' AND is_read = 0";
        $conn->query($sql);

        $conn->close();
    }
}

$response = array('success' => true);
echo json_encode($response);
?>
