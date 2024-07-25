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
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break;


	}
function doInsert(){
		
	if ($_POST['UNAME'] == "" OR $_POST['USERNAME'] == "" OR $_POST['UPASS'] == "") {
		$messageStats = false;
			message("All fields required!", "error");
			redirect("index.php?view=add");
		
	}else{

		$user = new User();
		$acc_name		= $_POST['UNAME']; 
		$res = $user->find_all_user($acc_name);
		
		
		if ($res >=1) {
			message("Account name already exist!", "error");
			redirect("index.php?view=add");
		}else{
			
			
			$user = new User(); 
			$user->UNAME 		= $_POST['UNAME'];
			$user->USER_NAME 	= $_POST['USERNAME'];
			$user->UPASS 		= sha1($_POST['UPASS']);
			$user->ROLE 		=  $_POST['ROLE'];
			$user->PHONE 		= $_POST['PHONE'];
			$istrue = $user->create(); 

			 if ($istrue == 1){
			 	message("New [".$_POST['UNAME']."] created successfully!", "success");
			 	redirect('index.php');
			 	
			 }
		}	 

		
	}	
}
function doEdit(){
	if ($_POST['UNAME'] == "" OR $_POST['USERNAME'] == "" OR $_POST['UPASS'] == "") {
		$messageStats = false;
			message("All fields required!", "error");
			redirect("index.php?view=edit&id=".$_SESSION['id']);
		
	}else{
			$user = new User(); 
			$user->UNAME 		= $_POST['UNAME'];
			$user->USER_NAME 	= $_POST['USERNAME'];
			$user->UPASS 		= sha1($_POST['UPASS']);
			$user->ROLE 		=  $_POST['ROLE'];
			$user->PHONE 		= $_POST['PHONE'];
			
			$user->update($_POST['USERID']); 
				
			 	message("[".  $_POST['UNAME'] ."] Upadated successfully!", "success");
			 	// unset($_SESSION['id']);
			 	redirect('index.php');
			

		
	}	
		
}

function doDelete(){
	 @$id=$_POST['selector'];
		  $key = count($id);
		//multi delete using checkbox as a selector
		
	for($i=0;$i<$key;$i++){
	 
		$user = new User();
		$user->delete($id[$i]);
	}

		message("User already Deleted!","info");
		redirect('index.php');

}

?>