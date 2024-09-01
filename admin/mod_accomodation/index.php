<?php
require_once("../../includes/initialize.php");



 if (!isset($_SESSION['ADMIN_ID'])){
 	redirect("../login.php");
 }
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title ="Room Type";
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
    case 'view' :
		$content    = 'view.php';		
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

default:
	$content = 'list.php';        
}

/*$thisFile = str_replace('\\', '/', __FILE__);
$docRoot =$_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'config/config.php'), '', $thisFile);
$srvRoot  = str_replace('config/config.php','', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
//define('ADMIN_INDEX_PATH', dirname(__FILE__));
define('ADMIN_INDEX_PATH', $_SERVER['SERVER_NAME']);
define( 'SEP', DIRECTORY_SEPARATOR );
ECHO WEB_ROOT;
//require_once (WEB_ROOT.'backendTemplate.php');*/
  include '../modal.php';
require_once '../themes/backendTemplate.php';
?>


  
