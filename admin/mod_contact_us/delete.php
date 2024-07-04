<?php
echo '<script src="../sweetalert2.all.min.js"></script>';
// Check if 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tblcontact WHERE CONTID = $id";

// Execute the DELETE statement
if ($connection->query($sql) === TRUE) {
    // echo '<script>alert("Deleting successfully.");</script>';
    // echo '<script>window.location.href = "index.php";</script>';
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
                Swal.fire({
                    title: "Deleted!",
                    text: "The message has been deleted.",
                    icon: "success"
                }).then(() => {
                    window.location.href = "index.php?confirm=true&id=' . $id . '";
                });
            } else {
                // User clicked "Cancel", do nothing (no action needed)
                window.location.href = "index.php";
            }
        });
    });
    </script>';
} else {
    echo '<script>alert("Deleting unsuccessful.");</script>';
    echo '<script>window.location.href = "index.php";</script>';
}

// Close the connection
$connection->close();
// <script>alert("An error occurred while preparing the DELETE statement.");</script>';
}
?>
