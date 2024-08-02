<?php

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
// Check if 'id' is set in the query string
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = $_GET['id'];
    // Attempt to delete the record from tblaccomodation table
    $sql = "DELETE FROM tblcontact WHERE CONTID = $id";
    
    if ($connection->query($sql) === TRUE) {
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
} else {
    // Redirect to index.php if 'id' is not set
    header("Location: index.php");
    exit;
}

// Close the database connection
$connection->close();
?>
