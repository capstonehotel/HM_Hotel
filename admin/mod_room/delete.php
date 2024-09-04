<?php
require_once("../../includes/initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['confirm'] === 'true') {
    $id = (int)$_POST['id'];

    if ($id > 0) {
        // Delete from tblreservation
        $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";
        if ($connection->query($sql) === TRUE) {
            // Delete from tblroom
            $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
            if ($connection->query($sql1) === TRUE) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
    // Close connection
    $connection->close();
    exit;
}
?>
