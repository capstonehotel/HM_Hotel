<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Payment List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <!-- <a href="index.php?view=add" class="btn btn-sm btn-primary">Add New Accommodation</a> -->
            </div>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
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
                    // Perform AJAX request to delete the record
                    fetch('index.php?view=delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'id=' + id
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire("Deleted!", "The accommodation has been deleted.", "success")
                            .then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Error!", "There was an error deleting the accommodation.", "error");
                        }
                    });
                }
            });
        });
    });
});
</script>
