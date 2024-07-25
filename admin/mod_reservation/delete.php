<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php"); // Ensure this file includes your database connection

$connection = new mysqli('localhost', 'root', '', 'hmsystemdb');

// Include SweetAlert script
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';


if (isset($_GET['confirm']) && $_GET['confirm'] == 'true' && isset($_GET['id'])) {
    $id = $connection->real_escape_string($_GET['id']);
    if ($id > 0) {
        $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$id'";
        
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$id'";
        
        if ($connection->query($sql) === TRUE && $connection->query($sql2) === TRUE) {
            echo '<script>
                Swal.fire({
                    title: "Deleted!",
                    text: "The Reservation has been deleted.",
                    icon: "success"
                }).then(() => {
                    window.location.href = "index.php";
                });
            </script>';
        } else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "There was an error deleting the reservation.",
                    icon: "error"
                }).then(() => {
                    window.location.href = "index.php";
                });
            </script>';
        }
    }
}
?>
