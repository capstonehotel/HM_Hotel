<?php
require_once("../../includes/initialize.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect("https://mcchmhotelreservation.com/admin/login.php");
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title = "Reservation";
switch ($view) {
    case 'list':
        $content = 'list.php';
        break;
        
    case 'delete':
        // Use AJAX for deletion confirmation
        $content = 'list.php';
        break;

    case 'view':
        $content = 'view.php';
        break;

    default:
        $content = 'list.php';
}
include '../modal.php';
require_once '../themes/backendTemplate.php';
?>
