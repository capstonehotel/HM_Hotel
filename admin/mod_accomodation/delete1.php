<?php
echo '<script src="../sweetalert2.all.min.js"></script>';

// Check if 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

   $sql = "SELECT * FROM tblroom WHERE ACCOMID = $id";

// Execute the DELETE statement$sql = "DELETE FROM `tblaccomodation` WHERE `ACCOMID` = '$id'";
if ($connection->query($sql) === TRUE) {
     echo '<script>alert("Deleting unsuccessful.");</script>';
     echo '<script>window.location.href = "index.php";</script>';
 } else {
      $sql1 = "DELETE FROM tblaccomodation WHERE ACCOMID = $id";
     if ($connection->query($sql1) === TRUE) {
    //    echo '<script>alert("Deleting successfully.");</script>';
    //  echo '<script>window.location.href = "index.php";</script>';
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
                            text: "The accomodation has been deleted.",
                            icon: "success"
                        }).then(() => {
                            window.location.href = "delete_process.php?confirm=true&id=' . $id . '";
                        });
                    } else {
                        // User clicked "Cancel", do nothing (no action needed)
                        window.location.href = "index.php";
                    }
                });
            });
            </script>';
     }else{
        echo '<script>alert("Deleting unsuccessful.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
      }
 }

$sql = "SELECT * FROM tblroom WHERE ACCOMID = $id";

// Execute the SELECT query
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    // echo '<script>alert("Accomodation is selected in rooms. Delete unsuccessful.");</script>';
    // echo '<script>window.location.href = "index.php";</script>';
}
else{
    $sql1 = "DELETE FROM tblaccomodation WHERE ACCOMID = $id";
    if ($connection->query($sql1) === TRUE) {
    //   echo '<script>alert("Deleting successfully.");</script>';
    // echo '<script>window.location.href = "index.php";</script>';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this item!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // User clicked "Yes", proceed with deletion
                window.location.href = "index.php?confirm=true&id=' . $id.'";
            } else {
                // User clicked "Cancel", do nothing (no action needed)
                window.location.href = "index.php";
            }
        });
    });
    </script>';
    }else{
    //   echo '<script>alert("Deleting unsuccessful.");</script>';
    //   echo '<script>window.location.href = "index.php";</script>';
    }
}

// Close the connection
$connection->close();
// <script>alert("An error occurred while preparing the DELETE statement.");</script>';
}
?>



