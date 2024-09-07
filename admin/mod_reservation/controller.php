<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])) {
    exit(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$code = isset($_GET['code']) ? $_GET['code'] : '';

$response = ['status' => 'error', 'message' => 'Action not recognized'];

switch ($action) {
    case 'delete':
        // Actual deletion logic
        $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql) && mysqli_query($connection, $sql2)) {
            $response = ['status' => 'success', 'message' => 'The reservation has been deleted.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error deleting the reservation.'];
        }
        break;

    case 'confirm':
        // Update confirmation logic
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM - 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql1 = "UPDATE tblreservation SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE ='$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql) === TRUE && $connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Booking confirmed successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error confirming the booking.'];
        }
        break;

    case 'checkin':
        // Update check-in logic
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE ='$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Booking checked in successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error checking in the booking.'];
        }
        break;

    case 'checkout':
        // Update check-out logic
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE ='$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE && $connection->query($sql) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Booking checked out successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error checking out the booking.'];
        }
        break;

    case 'cancel':
        // Update cancel logic
        $sql1 = "UPDATE tblreservation SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE ='$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE && $connection->query($sql) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Booking cancelled successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error cancelling the booking.'];
        }
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
