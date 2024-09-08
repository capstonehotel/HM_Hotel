<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])) {
    redirect(WEB_ROOT . "admin/login.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$code = $_GET['code'];

echo '<script src="../sweetalert2.all.min.js"></script>';

switch ($action) {
    case 'delete':
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won\'t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform deletion if confirmed using AJAX
                        performDelete("' . $code . '");
                    } else {
                        // Stay on the current page if canceled
                        window.location.href = "index.php";
                    }
                });
            });

            function performDelete(code) {
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The reservation has been deleted.",
                                icon: "success"
                            }).then(() => {
                                window.location.href = "index.php";
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: "Failed to delete the reservation.",
                                icon: "error"
                            });
                        }
                    }
                };
                xhttp.open("POST", "delete_process.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("action=confirm_delete&code=" + code);
            }
        </script>';
        break;

    case 'confirm_delete':
        // Perform the actual deletion process
        $code = $_POST['code'];
        $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

        if (mysqli_query($connection, $sql) && mysqli_query($connection, $sql2)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'confirm':
        // Logic for confirming booking with SweetAlert feedback
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM - 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql1 = "UPDATE tblreservation SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql) === TRUE && $connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Confirm Booking Successfully.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error on Confirming Booking.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        }
        break;

    case 'cancel':
        // Logic for canceling booking with SweetAlert feedback
        $sql1 = "UPDATE tblreservation SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE && $connection->query($sql) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Cancelled Booking Successfully.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error on Cancelling Booking.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        }
        break;

    case 'checkin':
        // Logic for checking in booking with SweetAlert feedback
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Check-in Booking Successfully.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error on Check-in Booking.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        }
        break;

    case 'checkout':
        // Logic for checking out booking with SweetAlert feedback
        $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND CONFIRMATIONCODE = '$code'";
        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE = '$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE && $connection->query($sql) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Check-out Booking Successfully.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error on Check-out Booking.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
        }
        break;
}
?>
