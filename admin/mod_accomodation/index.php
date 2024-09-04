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
			// Handle deletion via AJAX
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				$sql = "DELETE FROM tblaccomodation WHERE ACCOMID = $id";
				if ($connection->query($sql) === TRUE) {
					echo json_encode(['status' => 'success']);
				} else {
					echo json_encode(['status' => 'error']);
				}
				exit;
			}
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


  
