<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;">Back</a>
            <h6 class="m-0 font-weight-bold text-primary ml-10">View Booking</h6>
            <div style="display: flex; width: 90%; justify-content: flex-end;">
                <?php
                $code = $_GET['code'];
                $query = "SELECT ... FROM tblreservation WHERE CONFIRMATIONCODE = '".$code."'";
                // Fetch data and display buttons based on status (Confirm, Cancel, Check-in, Check-out)
                ?>
                <button id="deleteBtn" class="btn btn-danger btn-sm ml-2">Delete</button>
                <!-- Other buttons for actions like Confirm, Check-in, Check-out -->
            </div>
        </div>
    </div>
</div>

<script src="../sweetalert2.all.min.js"></script>
<script>
    document.getElementById('deleteBtn').addEventListener('click', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request
                fetch('controller.php?action=delete&code=<?php echo $code; ?>')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Error!', 'An error occurred while deleting.', 'error'));
            }
        });
    });

    // You can similarly bind other buttons (e.g. Confirm, Check-in, Check-out) with SweetAlert for inline actions.
</script>
