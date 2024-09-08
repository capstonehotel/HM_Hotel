<?php
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect(WEB_ROOT . "admin/login.php");
}

// Fetch reservation data from the database
$reservations = getReservations(); // Replace with your actual function to get reservations
?>


    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <table id="reservationsTable">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo $reservation['CONFIRMATIONCODE']; ?></td>
                <td><?php echo $reservation['NAME']; ?></td>
                <td><?php echo $reservation['STATUS']; ?></td>
                <td>
                    <button class="btn-action" data-action="confirm" data-code="<?php echo $reservation['CONFIRMATIONCODE']; ?>">Confirm</button>
                    <button class="btn-action" data-action="cancel" data-code="<?php echo $reservation['CONFIRMATIONCODE']; ?>">Cancel</button>
                    <button class="btn-action" data-action="checkin" data-code="<?php echo $reservation['CONFIRMATIONCODE']; ?>">Check In</button>
                    <button class="btn-action" data-action="checkout" data-code="<?php echo $reservation['CONFIRMATIONCODE']; ?>">Check Out</button>
                    <button class="btn-action" data-action="delete" data-code="<?php echo $reservation['CONFIRMATIONCODE']; ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).on('click', '.btn-action', function() {
            var action = $(this).data('action');
            var code = $(this).data('code');
            var url = 'controller.php?action=' + action + '&code=' + code;

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to " + action + " this reservation.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Success!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page to reflect changes
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'An error occurred while processing your request.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
