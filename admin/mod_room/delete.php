<?php
echo '<script src="../sweetalert2.all.min.js"></script>';

if (isset($_GET['id']) && !isset($_GET['confirm'])) {
    $id = $_GET['id'];
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
                $.ajax({
                    url: "delete.php",
                    type: "POST",
                    data: { id: ' . $id . ' },
                    success: function(response) {
                        if(response === "success") {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The room has been deleted.",
                                icon: "success"
                            }).then(() => {
                                window.location.href = "index.php";
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: "There was an error deleting the room.",
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an error deleting the room.",
                            icon: "error"
                        });
                    }
                });
            } else {
                window.location.href = "index.php";
            }
        });
    });
    </script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Make sure to use parameterized queries to prevent SQL injection
    $stmt = $connection->prepare("DELETE FROM tblreservation WHERE ROOMID = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->close();
        $stmt1 = $connection->prepare("DELETE FROM tblroom WHERE ROOMID = ?");
        $stmt1->bind_param("i", $id);
        if ($stmt1->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        $stmt1->close();
    } else {
        echo 'error';
    }


    $connection->close();
}
?>
