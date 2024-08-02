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
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Accommodation List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <a href="index.php?view=add" class="btn btn-sm btn-primary">Add New Accommodation</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="accommodationTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tblaccommodation";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['ACCOMODATION']; ?></td>
                            <td><?php echo $row['ACCOMDESC']; ?></td>
                            <td style="display: flex;">
                                <a class="btn-sm btn btn-primary mr-2" href="index.php?view=edit&id=<?php echo $row['ACCOMID']; ?>">View/Edit</a>
                                <a class="btn-sm btn btn-danger mr-2" href="index.php?view=delete&id=<?php echo $row['ACCOMID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables initialization -->
<script>
    $(document).ready(function() {
        $('#accommodationTable').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "pageLength": 10
        });
    });
</script>