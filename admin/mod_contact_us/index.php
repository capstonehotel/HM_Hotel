<?php
// require_once("../../includes/initialize.php");
// load config file first 
require_once("../../includes/config.php");
//load basic functions next so that everything after can use them
require_once("../../includes/functions.php");
//later here where we are going to put our class session
require_once("../../includes/session.php");
require_once("../../includes/user.php");
require_once("../../includes/pagination.php");
require_once("../../includes/paginsubject.php");
require_once("../../includes/accomodation.php");
require_once("../../includes/guest.php");
require_once("../../includes/reserve.php"); 
require_once("../../includes/setting.php");
//Load Core objects
require_once("../../includes/database.php");
 if (!isset($_SESSION['ADMIN_ID'])){
 	redirect(WEB_ROOT ."admin/login.php");
 }
//checkAdmin();
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title ="Reservation";
switch ($view) {
	case 'list' :
		$content    = 'list.php';		
		break;
		
		case 'delete' :
	
		
			if (isset($_GET['id'])&& !isset($_GET['confirm'])) {
				$id = $_GET['id'];
			
					// Confirm delete action with SweetAlert
					echo '<script src="../sweetalert2.all.min.js"></script>';
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
									// Perform deletion if confirmed
									window.location.href = "delete.php?true&id=' . $id . '&confirm=true";
								} else {
									// Redirect back if cancelled
									window.location.href = "index.php";
								}
							});
						});
						</script>';
			}
					$content    = '';		
					break;

    case 'view' :
		$content    = 'view.php';		
		break;

	default :
		$content    = 'list.php';		
}
  include '../modal.php';
require_once '../backendTemplate.php';


?>


  
