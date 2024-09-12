<!-- Include SweetAlert2 and Print.js -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.css" />

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
    .table-responsive {
        display: none; /* Hide table initially */
    }
    /* Print section styling */
    #printSection {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Checked-Out Reservations</h6>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active">
                <div class="card-body">
                    <div class="table-responsive" style="width: 100%;">
                        <table class="table table-striped" id="dataTableCheckout" width="100%" cellspacing="0">
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
                                          WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'checkedout' 
                                          ORDER BY p.`TRANSDATE` DESC";
                                $result = mysqli_query($connection, $query);
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
                                                <button type="button" class="btn btn-sm btn-primary print-btn" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>"><i class="icon-print"></i> Print</button>
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
        </div>
    </div>
</div>

<!-- Hidden Print Section -->
<div id="printSection">
    <div class="wrapper">
        <section class="invoice">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-building"></i> HM Hotel Reservation
                    </h2>
                </div>
            </div>
            <div class="row invoice-info">
                <!-- Fill the print section content using JavaScript -->
                <div class="col-sm-4 invoice-col" id="guestInfo">
                    <!-- Guest Info here -->
                </div>
                <div class="col-sm-4 invoice-col" id="invoiceInfo">
                    <!-- Invoice Info here -->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped" id="printTable">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Checked in</th>
                                <th>Checked out</th>
                                <th>Night(s)</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table data will be injected via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <p class="lead">Total Amount</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td id="totalAmount"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTables for check-out tab
    $('#dataTableCheckout').DataTable({
        "paging": true,
        "searching": true,
        "lengthChange": true,
        "pageLength": 10
    });

    // Show table after initialization
    $('.table-responsive').show();

    // Event listener for deleting a reservation
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
                            'The check-out reservation has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after deletion
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

    // Print button event
    $(document).on('click', '.print-btn', function() {
        var confirmationCode = $(this).data('code');

        // AJAX call to fetch the data for the given confirmation code
        $.ajax({
            url: 'printreport.php',
            type: 'GET',
            data: { code: confirmationCode },
            success: function(response) {
                // Inject the fetched data into the print section
                $('#printSection #guestInfo').html($(response).find('#guestInfo').html());
                $('#printSection #invoiceInfo').html($(response).find('#invoiceInfo').html());
                $('#printSection #printTable tbody').html($(response).find('#printTable tbody').html());
                $('#printSection #totalAmount').html($(response).find('#totalAmount').html());

                // Use Print.js to print the section
                printJS({
                    printable: 'printSection',
                    type: 'html',
                    css: 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
                });
            }
        });
    });
});
</script>
