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

    .table-responsive {
        overflow-x: auto; /* Allows horizontal scrolling if needed */
        margin: 0 auto; /* Center aligns the table container */
    }

    .btn-group {
        display: flex; /* Ensures buttons are displayed in a row */
        gap: 5px; /* Adds space between buttons */
    }

    .btn-sm {
        padding: 0.25rem 0.5rem; /* Ensures small padding for action buttons */
    }
</style>

<div class="container-fluid">
    <form action="controller.php?action=delete" method="POST"> 
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">List of Checked-out Reservations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Guest</th>
                                <th>Transaction Date</th>
                                <th>Confirmation Code</th>
                                <th>Total Rooms</th>
                                <!-- <th>Total Price</th> -->
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `STATUS`
                                          FROM `tblpayment` p, `tblguest` g
                                          WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'Checkedout'
                                          ORDER BY p.`TRANSDATE` DESC"; // Adjust query to fetch only checked-out reservations
                                $result = mysqli_query($connection, $query);
                                $number = 0;
                                while ($row = mysqli_fetch_assoc($result)) { $number++; ?>
                                    <tr>
                                        <td align="center"><?php echo $number; ?></td>
                                        <td align="center"><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></td>
                                        <td align="center"><?php echo $row['TRANSDATE']; ?></td>
                                        <td align="center"><?php echo $row['CONFIRMATIONCODE']; ?></td>
                                        <td align="center"><?php echo $row['PQTY']; ?></td>
                                        <!-- <td align="center"><?php echo $row['SPRICE']; ?></td> -->
                                        <td align="center"><?php echo $row['STATUS']; ?></td>
                                        <td align="center">
                                            <div class="btn-group" role="group">
                                                <form action="printreport.php" method="GET" target="_blank">
                                                    <input type="hidden" name="code" value="<?php echo $row['CONFIRMATIONCODE']; ?>">
                                                    <button class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</button>
                                                </form>
                                                <?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
                                                    <a class="btn btn-sm btn-danger" href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>"><i class="icon-edit"></i> Delete</a>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "pageLength": 10
        });
    });
</script>
