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
		
	if ($_POST['DESCRIPTION'] == "") {
		$messageStats = false;
			message("field required to fill!", "error");
			redirect("index.php?view=add");
		
	}else{$setting = new Setting();
		
		$type 		= $_POST['type'];

		$res = $setting->find_all_setting($type);
		
		
		if ($res >=1) {
			message("The Description type is already exist!", "error");
			redirect("index.php?view=add");
		}else{
			
			$setting->DESCRIPTION = $_POST['DESCRIPTION']; 
			$setting->TYPE = $type;
			
			 $istrue = $setting->create(); 
			 if ($istrue == 1){
			 	message("New [". $acc_name ."] created successfully!", "success");
			 	redirect('index.php');
			 	
			 }
		}	 

		
	}	
}
function doEdit(){
	if ($_POST['DESCRIPTION'] == "" ) {
		$messageStats = false;
			message("All fields required!", "error");
			redirect("index.php?view=edit&id=".$_SESSION['id']);
		
	}else{
		$setting = new Setting();
 

			$type 		= $_POST['type'];
			$setting->DESCRIPTION = $_POST['DESCRIPTION']; 
			$setting->TYPE = $type; 
			$setting->update($_POST['ID']); 
				
			 	message("New [". $type ."] Updated successfully!", "success");
			 	unset($_SESSION['id']);
			 	redirect('index.php');
			

		
	}	
		
}

function doDelete(){
	 @$id=$_POST['selector'];
		  $key = count($id);
		//multi delete using checkbox as a selector
		
	for($i=0;$i<$key;$i++){
	 
		$setting = new Setting();
		$setting->delete($id[$i]);
	}

		message("User already Deleted!","info");
		redirect('index.php');

}

?>