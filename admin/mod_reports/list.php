<div class="container-fluid">
    <form id="actionForm" action="" method="POST">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">List of Checked-out Reservations</h6>
            </div>
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
                                          ORDER BY p.`TRANSDATE` DESC";
                                $result = mysqli_query($connection, $query);
                                $number = 0;
                                while ($row = mysqli_fetch_assoc($result)) { $number ++;?>
                                    <tr>
                                        <td align="center"><?php echo $number; ?></td>
                                        <td align="center"><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></td>
                                        <td align="center"><?php echo $row['TRANSDATE']; ?></td>
                                        <td align="center"><?php echo $row['CONFIRMATIONCODE']; ?></td>
                                        <td align="center"><?php echo $row['PQTY']; ?></td>
                                        <!-- <td align="center"><?php echo $row['SPRICE']; ?></td> -->
                                        <td align="center"><?php echo $row['STATUS']; ?></td>
                                        <td align="center">
                                            <input type="hidden" name="code" id="codeInput" value="">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="handlePrint('<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="fa fa-print"></i> Print</button>
                                            <?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete('<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="icon-edit"></i> Delete</button>
                                            <?php } ?>
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

<script>
    function handlePrint(code) {
        var form = document.getElementById('actionForm');
        form.action = 'printreport.php';
        form.method = 'GET';
        document.getElementById('codeInput').value = code;
        form.target = '_blank';
        form.submit();
    }

    function handleDelete(code) {
        var form = document.getElementById('actionForm');
        form.action = 'controller.php?action=delete';
        form.method = 'POST';
        document.getElementById('codeInput').value = code;
        form.target = '';
        form.submit();
    }
</script>
