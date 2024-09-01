<?php
require_once("../../includes/initialize.php");

 if (!isset($_SESSION['ADMIN_ID'])){
 	redirect("../login.php");
 }
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title ="Room";
switch ($view) {
	case 'list' :
		$content    = 'list.php';		
		break;

	case 'add' :
		$content    = 'add.php';		
		break;

	case 'edit' :
		$content    = 'edit.php';		
		break;

	case 'editpic' :
	$content    = 'editpic.php';		
	break;
    case 'view' :
		$content    = 'view.php';		
		break;
	case 'delete' :
		// Include SweetAlert if it's not already included
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if (isset($_GET['id']) && !isset($_GET['confirm'])) {
    $id = (int)$_GET['id']; // Ensure $id is an integer for safety

    // Render SweetAlert JavaScript
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won\'t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion by redirecting with confirm=true
                    window.location.href = "delete.php?id=' . $id . '&confirm=true";
                } else {
                    // User cancelled the action
                    Swal.fire({
                        title: "Cancelled",
                        text: "The deletion has been cancelled.",
                        icon: "info"
                    }).then(() => {
                        window.location.href = "index.php";
                    });
                }
            });
        });
    </script>';
}

		$content    = 'delete.php';		
		break;
	default :
		$content    = 'list.php';		
}
  
require_once '../themes/backendTemplate.php';
?>


  
