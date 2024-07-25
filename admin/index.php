<?php
// require_once("../includes/initialize.php");
// load config file first 
require_once("../includes/config.php");
//load basic functions next so that everything after can use them
require_once("../includes/functions.php");
//later here where we are going to put our class session
require_once("../includes/session.php");
require_once("../includes/user.php");
require_once("../includes/pagination.php");
require_once("../includes/paginsubject.php");
require_once("../includes/accomodation.php");
require_once("../includes/guest.php");
require_once("../includes/reserve.php"); 
require_once("../includes/setting.php");
//Load Core objects
require_once("../includes/database.php");

 if (!isset($_SESSION['ADMIN_ID'])){
 	redirect('login.php');
 	return true;
 }


 
$content='home.php';

include 'themes/backendTemplate.php';

?>
