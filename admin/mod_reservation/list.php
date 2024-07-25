


<div class="container-fluid">
    <form action="controller.php?action=delete" method="POST"> 
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">List of Reservation</h6>
            </div>
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="reservationTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="confirmed-tab" data-toggle="tab" href="#confirmed" role="tab" aria-controls="confirmed" aria-selected="false">Confirmed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="check-in-tab" data-toggle="tab" href="#check-in" role="tab" aria-controls="check-in" aria-selected="false">Check-in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="check-out-tab" data-toggle="tab" href="#check-out" role="tab" aria-controls="check-out" aria-selected="false">Check-out</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                </li>
            </ul>
            
            <div class="tab-content" id="reservationTabsContent">
                <!-- List Tab -->
                <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
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
                                    $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                                              FROM `tblpayment` p, `tblguest` g
                                              WHERE p.`GUESTID` = g.`GUESTID`
                                              ORDER BY p.`STATUS`='pending' DESC";
                                    $result = mysqli_query($connection, $query);
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pending Tab -->
                <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTablePending" width="100%" cellspacing="0">
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
                                    $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                                              FROM `tblpayment` p, `tblguest` g
                                              WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'pending'
                                              ORDER BY p.`TRANSDATE` DESC";
                                    $result = mysqli_query($connection, $query);
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Confirmed Tab -->
                <div class="tab-pane fade" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTableConfirmed" width="100%" cellspacing="0">
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
                                    $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                                              FROM `tblpayment` p, `tblguest` g
                                              WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'confirmed'
                                              ORDER BY p.`TRANSDATE` DESC";
                                    $result = mysqli_query($connection, $query);
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Check-in Tab -->
                <div class="tab-pane fade" id="check-in" role="tabpanel" aria-labelledby="check-in-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTableCheckIn" width="100%" cellspacing="0">
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
                                    $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                                              FROM `tblpayment` p, `tblguest` g
                                              WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'Checkedin'
                                              ORDER BY p.`TRANSDATE` DESC";
                                    $result = mysqli_query($connection, $query);
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Check-out Tab -->
                

                <div class="tab-pane fade" id="check-out" role="tabpanel" aria-labelledby="check-out-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTableCheckOut" width="100%" cellspacing="0">
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
                                    $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                                              FROM `tblpayment` p, `tblguest` g
                                              WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'Checkedout'
                                              ORDER BY p.`TRANSDATE` DESC";
                                    $result = mysqli_query($connection, $query);
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Tab -->
                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table table-striped" id="dataTableCancelled" width="100%" cellspacing="0">
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
                                    $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                                              FROM `tblpayment` p, `tblguest` g
                                              WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'cancelled'
                                              ORDER BY p.`TRANSDATE` DESC";
                                    $result = mysqli_query($connection, $query);
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    $('#dataTable, #dataTablePending, #dataTableConfirmed, #dataTableCheckIn, #dataTableCheckOut, #dataTableCancelled').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "autoWidth": false,
        "columnDefs": [
            { "width": "10%", "targets": [0] },   // First column width
            { "width": "20%", "targets": [1] },   // Second column width
            { "width": "15%", "targets": [2, 3] }, // Third and fourth column width
            { "width": "10%", "targets": [4] },   // Fifth column width
            { "width": "10%", "targets": [5] },   // Sixth column width
            { "width": "15%", "targets": [6] },   // Seventh column width
            { "width": "10%", "targets": [7] }    // Eighth column width
        ]
    });
});

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
