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

// Four steps to closing a session
// (i.e. logging out)

// 1. Find the session
// session_start();

// 2. Unset all the session variables
unset( $_SESSION['ADMIN_ID'] );
unset( $_SESSION['ADMIN_UNAME'] );
unset( $_SESSION['ADMIN_USERNAME'] );
unset( $_SESSION['ADMIN_UPASS'] );
unset( $_SESSION['ADMIN_UROLE'] );

 	
// 4. Destroy the session
redirect(WEB_ROOT ."/admin/index.php");
?>