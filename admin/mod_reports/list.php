<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checked-Out Reservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
            display: block; /* Ensure table is visible */
        }
        @media print {
            @page {
                margin: 0.5in;
            }
            body {
                margin: 0;
            }
            .modal-content {
                border: none;
            }
            .modal-footer {
                display: none;
            }
        }
    </style>
</head>
<body>
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
                                    require_once("../../includes/initialize.php");

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

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body" id="printModalContent">
            <!-- Print content will be dynamically loaded here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="printBtn">Print</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Initialize DataTables -->
    <script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#dataTableCheckout').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "pageLength": 10
        });

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

        // Event listener for printing content
        $(document).on('click', '.print-btn', function() {
            var confirmationCode = $(this).data('code');
            $.ajax({
                url: 'printreport.php',
                type: 'GET',
                data: { code: confirmationCode },
                success: function(response) {
                    $('#printModalContent').html(response);
                    $('#printModal').modal('show');
                },
                error: function() {
                    Swal.fire('Error!', 'Error loading print content.', 'error');
                }
            });
        });

        // Trigger print when print button is clicked in the modal
        $('#printBtn').on('click', function() {
            var printContents = document.getElementById('printModalContent').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

            // Close the modal after printing
            $('#printModal').modal('hide');
        });
    });
    </script>
</body>
</html>
