<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-end;">
                <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;" >Back</a>
                <h6 class="m-0 font-weight-bold text-primary ml-10">View Booking</h6>
            </div>
            <div style="display: flex; width: 90%; justify-content: flex-end;">
                <?php
if (!defined('WEB_ROOT')) {
    exit;
}

$code = $_GET['code'];

$query = "SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS` ,  `TRANSDATE` , `G_GENDER`, `CONFIRMATIONCODE` ,  `PQTY` ,  `SPRICE` ,`STATUS`
          FROM  `tblpayment` p,  `tblguest` g
          WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE`='$code'";
$result = mysqli_query($connection, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { ?>
        <?php if($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
            <?php if ($row['STATUS'] == "Confirmed") { ?>
                <button class="btn btn-danger btn-sm ml-2 action-btn" data-action="cancel" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Cancel</button>
                <button class="btn btn-success btn-sm ml-2 action-btn" data-action="checkin" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Check in</button>
            <?php } elseif($row['STATUS'] == 'Checkedin') { ?>
                <button class="btn btn-warning btn-sm ml-2 action-btn" data-action="checkout" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Check out</button>
            <?php } elseif($row['STATUS'] == 'Checkedout') { ?>
                <button class="btn btn-danger btn-sm ml-2 action-btn" data-action="delete" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Delete</button>
            <?php } ?>
        <?php } ?>
<?php }
} ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.action-btn').forEach(button => {
    button.addEventListener('click', function() {
        const action = this.getAttribute('data-action');
        const code = this.getAttribute('data-code');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to controller.php
                fetch('controller.php?action=' + action + '&code=' + code)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    });
            }
        });
    });
});
</script>
