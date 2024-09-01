<?php
require_once("../../includes/initialize.php");
 established
// $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
// Check if 'id' is set in the query string
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = $_GET['id'];

    // Attempt to delete the record from tblaccomodation table
    $sql = "DELETE FROM tbluseraccount WHERE USERID = $id";
    
    if ($connection->query($sql) === TRUE) {
        // Deletion successful
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Deleted!",
                    text: "The user has been deleted.",
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
