<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Additional styling and scripts -->
<style>
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }
    .table thead th {
        text-align: center;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">List of Reservations</h6>
        </div>
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="reservationTabs" role="tablist">
            <?php 
            $tabs = ['list', 'pending', 'confirmed', 'check-in', 'check-out', 'cancelled'];
            foreach ($tabs as $tab) { ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($tab == 'list') ? 'active' : ''; ?>" id="<?php echo $tab; ?>-tab" data-toggle="tab" href="#<?php echo $tab; ?>" role="tab" aria-controls="<?php echo $tab; ?>" aria-selected="<?php echo ($tab == 'list') ? 'true' : 'false'; ?>"><?php echo ucfirst($tab); ?></a>
                </li>
            <?php } ?>
        </ul>
        
        <div class="tab-content" id="reservationTabsContent">
            <?php 
            $queries = [
                "list" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` ORDER BY p.`STATUS`='pending' DESC, p.`TRANSDATE` DESC",
                "pending" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'pending' ORDER BY p.`TRANSDATE` DESC",
                "confirmed" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'confirmed' ORDER BY p.`TRANSDATE` DESC",
                "check-in" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'checkedin' ORDER BY p.`TRANSDATE` DESC",
                "check-out" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'checkedout' ORDER BY p.`TRANSDATE` DESC",
                "cancelled" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'cancelled' ORDER BY p.`TRANSDATE` DESC"
            ];

            foreach ($tabs as $tab) { ?>
                <div class="tab-pane fade <?php echo ($tab == 'list') ? 'show active' : ''; ?>" id="<?php echo $tab; ?>" role="tabpanel" aria-labelledby="<?php echo $tab; ?>-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTable<?php echo ucfirst($tab); ?>" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Guest</th>
                                        <th>Transaction Date</th>
                                        <th>Confirmation Code</th>
                                        <th>Total Rooms</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $result = mysqli_query($connection, $queries[$tab]);
                                    if (!$result) {
                                        echo "<tr><td colspan='8'>Query failed: " . mysqli_error($connection) . "</td></tr>";
                                    } else {
                                        $number = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $number++;
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $number; ?></td>
                                                <td align="center"><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></td>
                                                <td align="center"><?php echo $row['TRANSDATE']; ?></td>
                                                <td align="center"><?php echo $row['CONFIRMATIONCODE']; ?></td>
                                                <td align="center"><?php echo $row['PQTY']; ?></td>
                                                <td align="center"><?php echo $row['SPRICE']; ?></td>
                                                <td align="center"><?php echo $row['STATUS']; ?></td>
                                                <td align="center">
                                                    <a href="index.php?view=view&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-sm btn-primary"><i class="icon-edit"></i> View</a>
                                                    <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['CONFIRMATIONCODE']; ?>"><i class="icon-edit"></i> Delete</button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } 
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Initialize DataTables -->
<script>
   $(document).ready(function() {
    <?php foreach ($tabs as $tab) { ?>
        $('#dataTable<?php echo ucfirst($tab); ?>').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "pageLength": 10
        });
    <?php } ?>

    // Use event delegation for dynamically generated rows
    $(document).on('click', '.delete-btn', function() {
        var confirmationCode = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete.php',
                    type: 'GET',
                    data: { id: confirmationCode, confirm: 'true' },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The reservation has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the table
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the reservation.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

</script>
