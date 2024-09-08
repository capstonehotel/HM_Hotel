<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect(WEB_ROOT . "admin/login.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$code = $_GET['code'];

header('Content-Type: application/json'); // Set response type to JSON

switch ($action) {
    case 'delete':
        // Delete reservation and payment
        $sql1 = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2)) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation has been successfully deleted.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete reservation.']);
        }
        break;

    case 'confirm':
        // Update reservation status to 'Confirmed'
        $sql = "UPDATE tblreservation SET status = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation has been confirmed.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to confirm reservation.']);
        }
        break;

    case 'cancel':
        // Update reservation status to 'Cancelled'
        $sql = "UPDATE tblreservation SET status = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation has been cancelled.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to cancel reservation.']);
        }
        break;

    case 'checkin':
        // Update reservation status to 'Checked In'
        $sql = "UPDATE tblreservation SET status = 'Checked In' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation has been checked in.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to check in reservation.']);
        }
        break;

    case 'checkout':
        // Update reservation status to 'Checked Out'
        $sql = "UPDATE tblreservation SET status = 'Checked Out' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation has been checked out.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to check out reservation.']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
?>
