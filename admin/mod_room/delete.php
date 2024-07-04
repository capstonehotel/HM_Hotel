<?php
echo '<script src="../sweetalert2.all.min.js"></script>';

if (isset($_GET['id']) && !isset($_GET['confirm'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";
    if ($connection->query($sql) === TRUE) {
        $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
        if ($connection->query($sql1) === TRUE) {
            
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
                            text: "The room has been deleted.",
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
    
}
    }
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";

    if ($connection->query($sql) === TRUE) {
        $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
        if ($connection->query($sql1) === TRUE) {
            echo '<script>
            swal({
                title: "Deleted Successfully!",
                text: "The record has been deleted.",
                icon: "success"
            }).then(() => {
                window.location.href = "index.php";
            });
            </script>';
        } else {
            echo '<script>
            swal({
                title: "Error!",
                text: "Deleting unsuccessful.",
                icon: "error"
            }).then(() => {
                window.location.href = "index.php";
            });
            </script>';
        }
    } else {
        echo '<script>
        swal({
            title: "Error!",
            text: "Deleting unsuccessful.",
            icon: "error"
        }).then(() => {
            window.location.href = "index.php";
        });
        </script>';
    }

    $connection->close();
}
?>
