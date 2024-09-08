<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])) {
    redirect(WEB_ROOT . "admin/login.php");
}

$code = $_GET['code']; // Assuming this is passed via GET
$sql = "SELECT * FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
$result = $connection->query($sql);
$reservation = $result->fetch_assoc();

// Other logic related to displaying reservation details here...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="../sweetalert2.min.css">
    <script src="../sweetalert2.all.min.js"></script>
</head>
<body>

<h2>Reservation Details for Confirmation Code: <?php echo $code; ?></h2>
<!-- Display reservation details here -->
<p>Status: <?php echo $reservation['STATUS']; ?></p>
<!-- Add more details as needed -->

<div class="actions">
    <button id="confirmBtn" class="btn-confirm">Confirm</button>
    <button id="cancelBtn" class="btn-cancel">Cancel</button>
    <button id="checkinBtn" class="btn-checkin">Check In</button>
    <button id="checkoutBtn" class="btn-checkout">Check Out</button>
    <button id="deleteBtn" class="btn-delete">Delete</button>
</div>

<script>
document.getElementById('confirmBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to confirm this reservation.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, confirm it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            performAction('confirm', '<?php echo $code; ?>');
        }
    });
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to cancel this reservation.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            performAction('cancel', '<?php echo $code; ?>');
        }
    });
});

document.getElementById('checkinBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to check in this reservation.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, check in!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            performAction('checkin', '<?php echo $code; ?>');
        }
    });
});

document.getElementById('checkoutBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to check out this reservation.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, check out!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            performAction('checkout', '<?php echo $code; ?>');
        }
    });
});

document.getElementById('deleteBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this reservation. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            performAction('delete', '<?php echo $code; ?>');
        }
    });
});

function performAction(action, code) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Action performed successfully.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to perform the action.',
                    icon: 'error'
                });
            }
        }
    };
    xhttp.open('POST', 'controller.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`action=${action}&code=${code}`);
}
</script>

</body>
</html>
