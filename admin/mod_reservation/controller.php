<?php
// $connection = new mysqli('localhost', 'root', '', 'hmsystemdb');
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

$action = $_GET['action'] ?? '';
$code = $_GET['code'] ?? '';

if (!empty($action) && !empty($code)) {
    switch ($action) {
        case 'confirm':
            confirmBooking($code);
            break;
        case 'cancel':
            cancelBooking($code);
            break;
        case 'checkin':
            checkInBooking($code);
            break;
        case 'checkout':
            checkOutBooking($code);
            break;
        case 'delete':
            deleteBooking($code);
            break;
        default:
            echo 'Invalid action!';
            break;
    }
}

function confirmBooking($code) {
    global $connection;

    $query = "UPDATE `tblreservation` SET `STATUS` = 'Confirmed' WHERE `CONFIRMATIONCODE` = '$code'";
    if (mysqli_query($connection, $query)) {
        echo 'Booking confirmed successfully!';
    } else {
        echo 'Error confirming booking: ' . mysqli_error($connection);
    }
}

function cancelBooking($code) {
    global $connection;

    $query = "UPDATE `tblreservation` SET `STATUS` = 'Cancelled' WHERE `CONFIRMATIONCODE` = '$code'";
    if (mysqli_query($connection, $query)) {
        echo 'Booking cancelled successfully!';
    } else {
        echo 'Error cancelling booking: ' . mysqli_error($connection);
    }
}

function checkInBooking($code) {
    global $connection;

    $query = "UPDATE `tblreservation` SET `STATUS` = 'Checkedin' WHERE `CONFIRMATIONCODE` = '$code'";
    if (mysqli_query($connection, $query)) {
        echo 'Checked in successfully!';
    } else {
        echo 'Error checking in: ' . mysqli_error($connection);
    }
}

function checkOutBooking($code) {
    global $connection;

    $query = "UPDATE `tblreservation` SET `STATUS` = 'Checkedout' WHERE `CONFIRMATIONCODE` = '$code'";
    if (mysqli_query($connection, $query)) {
        echo 'Checked out successfully!';
    } else {
        echo 'Error checking out: ' . mysqli_error($connection);
    }
}

function deleteBooking($code) {
    global $connection;

    $query = "DELETE FROM `tblreservation` WHERE `CONFIRMATIONCODE` = '$code'";
    if (mysqli_query($connection, $query)) {
        echo 'Booking deleted successfully!';
    } else {
        echo 'Error deleting booking: ' . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
