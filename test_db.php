<?php
require_once('includes/config.php');

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($connection) {
    echo "Database connection successful.";
} else {
    echo "Database connection failed: " . mysqli_connect_error();
}
?>
