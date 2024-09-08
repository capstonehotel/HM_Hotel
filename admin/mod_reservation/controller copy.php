<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';
$code = $_GET['code'];

switch ($action) {
    case 'delete':
        $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql) && mysqli_query($connection, $sql2)) {
            echo 'Deleted booking successfully.';
        } else {
            echo 'Error deleting booking.';
        }
        break;

    case 'confirm':
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM - 1 WHERE r.ROOMID = rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql1 = "UPDATE tblreservation SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql) && $connection->query($sql1) && $connection->query($sql2)) {
            echo 'Confirmed booking successfully.';
        } else {
            echo 'Error confirming booking.';
        }
        break;

    case 'cancel':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID = rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql1) && $connection->query($sql2) && $connection->query($sql)) {
            echo 'Cancelled booking successfully.';
        } else {
            echo 'Error cancelling booking.';
        }
        break;

    case 'checkin':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql1) && $connection->query($sql2)) {
            echo 'Checked in successfully.';
        } else {
            echo 'Error checking in.';
        }
        break;

    case 'checkout':
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID = rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql1) && $connection->query($sql2) && $connection->query($sql)) {
            echo 'Checked out successfully.';
        } else {
            echo 'Error checking out.';
        }
        break;
}
?>
