<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-end;">
                <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;">Back</a>
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
                          WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE` = '$code'";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($_SESSION['ADMIN_UROLE'] == "Administrator") {
                            if ($row['STATUS'] == "Confirmed") {
                                echo '<button class="btn btn-danger btn-sm ml-2 action-button" data-action="cancel" data-code="' . $row['CONFIRMATIONCODE'] . '">Cancel</button>';
                                echo '<button class="btn btn-success btn-sm ml-2 action-button" data-action="checkin" data-code="' . $row['CONFIRMATIONCODE'] . '">Check in</button>';
                            } elseif ($row['STATUS'] == 'Checkedin') {
                                echo '<button class="btn btn-warning btn-sm ml-2 action-button" data-action="checkout" data-code="' . $row['CONFIRMATIONCODE'] . '">Check out</button>';
                            } elseif ($row['STATUS'] == 'Checkedout') {
                                echo '<button class="btn btn-danger btn-sm ml-2 action-button" data-action="delete" data-code="' . $row['CONFIRMATIONCODE'] . '">Delete</button>';
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle button click and make AJAX requests
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const code = this.getAttribute('data-code');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make the AJAX call
                    fetch(`controller.php?action=${action}&code=${code}`, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success');
                            // Optionally refresh part of the page or update UI
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'There was a problem performing the action.', 'error');
                    });
                }
            });
        });
    });
</script>
