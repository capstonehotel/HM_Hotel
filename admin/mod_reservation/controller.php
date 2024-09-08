<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect(WEB_ROOT . "admin/login.php");
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$code = $_GET['code'];
$response = ['success' => false, 'message' => 'Something went wrong!'];

switch ($action) {
    case 'delete':
        $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql) && mysqli_query($connection, $sql2)) {
            $response = ['success' => true, 'message' => 'Reservation deleted successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to delete reservation.'];
        }
        break;

    case 'cancel':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql)) {
            $response = ['success' => true, 'message' => 'Booking cancelled successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to cancel booking.'];
        }
        break;

    case 'checkin':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2)) {
            $response = ['success' => true, 'message' => 'Checked in successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to check in.'];
        }
        break;

    case 'checkout':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql)) {
            $response = ['success' => true, 'message' => 'Checked out successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to check out.'];
        }
        break;
}

echo json_encode($response);
?>
