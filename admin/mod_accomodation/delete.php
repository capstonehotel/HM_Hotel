<?php
// load config file first 
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
require_once("../../includes/database.php");
// Ensure your database connection is properly established
// $connection = new mysqli('127.0.0.1', 'u510162695_hmsystemdb', '1Hmsystemdb', 'u510162695_hmsystemdb', '3306');
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
// Check if 'id' is set in the query string
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = $_GET['id'];

    // Attempt to delete the record from tblaccomodation table
    $sql = "DELETE FROM tblaccomodation WHERE ACCOMID = $id";
    
    if ($connection->query($sql) === TRUE) {
        // echo 'Executed PHP Code';
        // Deletion successful
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Deleted!",
                    text: "The reservation has been deleted.",
                    icon: "success"
                }).then(() => {
                    window.location.href = "index.php";
                });
            });
            </script>';
    } else {
        // Deletion unsuccessful
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "Error on deleting the reservation.",
                    icon: "error"
                }).then(() => {
                    window.location.href = "index.php";
                });
            });
            </script>';
    }
} 

// Close the database connection
$connection->close();
?>
