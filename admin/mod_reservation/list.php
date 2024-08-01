<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Custom CSS to ensure consistent table styling -->
<style>
    .table td, .table th {
        white-space: nowrap; /* Prevents wrapping of table cell contents */
        vertical-align: middle; /* Ensures vertical alignment */
    }

    .table thead th {
        text-align: center; /* Centers the header text */
    }

    .btn-sm {
        padding: 0.25rem 0.5rem; /* Ensures small padding for action buttons */
    }
</style>

<div class="container-fluid">
    <form action="controller.php?action=delete" method="POST">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">List of Reservation</h6>
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
                    "list" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` ORDER BY p.`STATUS`='pending' DESC",
                    "pending" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'pending' ORDER BY p.`TRANSDATE` DESC",
                    "confirmed" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'confirmed' ORDER BY p.`TRANSDATE` DESC",
                    "check-in" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'checkedin' ORDER BY p.`TRANSDATE` DESC",
                    "check-out" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'checkedout' ORDER BY p.`TRANSDATE` DESC",
                    "cancelled" => "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` FROM `tblpayment` p, `tblguest` g WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'cancelled' ORDER BY p.`TRANSDATE` DESC"
                ];

                foreach ($tabs as $tab) { 
                    ?>
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
                                                        <a href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm"><i class="icon-edit"></i> Delete</a>
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
    </form>
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
    });
</script>
