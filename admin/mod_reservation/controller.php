<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect(WEB_ROOT ."admin/login.php");
}

$action = (isset($_POST['action']) && $_POST['action'] != '') ? $_POST['action'] : '';
$code = $_POST['code'];

switch ($action) {
    case 'confirm':
        $sql1 = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM - 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblreservation SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";
        $sql3 = "UPDATE tblpayment SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql3)) {
            echo json_encode(['status' => 'success', 'message' => 'Booking Confirmed Successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error Confirming Booking']);
        }
        break;

    case 'cancel':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";
        $sql3 = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql3)) {
            echo json_encode(['status' => 'success', 'message' => 'Booking Cancelled Successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error Cancelling Booking']);
        }
        break;

    case 'checkin':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2)) {
            echo json_encode(['status' => 'success', 'message' => 'Check-in Successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error during Check-in']);
        }
        break;

    case 'checkout':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";
        $sql3 = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql3)) {
            echo json_encode(['status' => 'success', 'message' => 'Check-out Successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error during Check-out']);
        }
        break;

    case 'delete':
        $sql1 = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2)) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation Deleted Successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error Deleting Reservation']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid Action']);
        break;
}
?>
