<?php
// require_once("../../includes/initialize.php");
// load config file first 

require_once("../../includes/database.php");
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = (int)$_GET['id']; // Ensure $id is an integer for safety

    if ($id > 0) {
        // Perform deletion from tblreservation
        $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";
        if ($connection->query($sql) === TRUE) {
            // Perform deletion from tblroom
            $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
            if ($connection->query($sql1) === TRUE) {
                // Show success message
                // echo 'Executed PHP Code';
           
                echo '<script>
                    Swal.fire({
                        title: "Deleted!",
                        text: "The room has been deleted.",
                        icon: "success"
                    }).then(() => {
                        window.location.href = "index.php";
                    });
                </script>';
            } else {
                // Handle SQL error
                echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "There was an error deleting the room.",
                        icon: "error"
                    }).then(() => {
                        window.location.href = "index.php";
                    });
                </script>';
            }
        } else {
            // Handle SQL error
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
