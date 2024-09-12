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

<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Event listener for print button click
        $(document).on('click', '.print-btn', function() {
            var confirmationCode = $(this).data('code'); // Get the confirmation code from button

            // AJAX call to fetch invoice details
            $.ajax({
                url: 'printreport.php', // Fetch data from this file
                type: 'GET',
                data: { code: confirmationCode }, // Send confirmation code as parameter
                dataType: 'json', // Expecting JSON response
                success: function(response) {
                    if (response.success) {
                        // Prepare the HTML structure for the invoice
                        var printContent = `
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
                                    <div class="col-sm-4 invoice-col">
                                        From
                                        <address>
                                            <strong>HM Hotel Reservation</strong><br>
                                            Crossing Bunakan<br>
                                            Bunakan, Madridejos, Cebu<br>
                                            Phone: 09317622381<br>
                                            Email: Hmhotelreservation@gmail.com
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        To
                                        <address>
                                            <strong>` + response.guestName + `</strong><br>
                                            ` + response.guestAddress + `<br>
                                            ` + response.guestCity + `<br>
                                            ` + response.guestNationality + `<br>
                                            ` + response.guestZip + `
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Invoice No.</b> 00` + response.guestId + `<br>
                                        <b>Confirmation ID:</b> ` + response.confirmationCode + `<br>
                                        <b>Transaction Date:</b> ` + response.transactionDate + `
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped">
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
                                                ` + response.roomDetails.map(function(room) {
                                                    return `
                                                        <tr>
                                                            <td>` + room.accommodation + ' ' + room.room + `</td>
                                                            <td>` + room.roomDesc + `<br>` + room.numPerson + `</td>
                                                            <td>&#8369; ` + room.price + `</td>
                                                            <td>` + room.arrivalDate + `</td>
                                                            <td>` + room.departureDate + `</td>
                                                            <td>` + room.nights + `</td>
                                                            <td>&#8369; ` + room.subtotal + `</td>
                                                        </tr>
                                                    `;
                                                }).join('') + `
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
                                                    <td>&#8369; ` + response.totalAmount + `</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>`;

                        // Inject the content into a hidden div for printing
                        $('#printSection').html(printContent);

                        // Use printJS to print the content
                        printJS({
                            printable: 'printSection',
                            type: 'html',
                            css: 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
                        });
                    } else {
                        Swal.fire('Error', 'Failed to load print data.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to fetch print data.', 'error');
                }
            });
        });
    });
</script>

<!-- HTML to hold the print content temporarily -->
<div id="printSection" style="display:none;"></div>
