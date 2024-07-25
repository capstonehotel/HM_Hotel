<?php  
// require_once ("../../includes/initialize.php");  
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
$room = New Room();
$cur = $room->single_room($_POST['ROOMID']);
 
?>

<div class="modal-dialog" style="width:50%">
<div class="modal-content">
	<!-- <div class="modal-header">
		<button  class="close" id="btnclose" data-dismiss="modal" type=
		"button">x</button>
	</div> -->
<div class="modal-body">  
<form class="form-horizontal well span6" action="controller.php?action=editimage" enctype="multipart/form-data" method="POST">

	<table class="table table-hover" border="0" width="50">
			<caption><h3 align="left">Modify Image</h3></caption>
		<tr>
		<td width="80">
			<input name="id" type="hidden" value="<?php echo $cur->ROOMID; ?>">
			<img src="<?php echo $cur->ROOMIMAGE; ?>" width="550" height="300" /></td>
		</tr>

		<tr>
		<td width="80">
			<input id="image" name="image" type="file"></td>
		</tr>
		<tr>
		<td  width="80"><input type="button" value="x Close" class="btn btn-default" onclick="window.location.href='index.php'" >  
		 <button class="btn btn-primary" name="save" type="submit" >Save</button>

		</td>
		</tr>
	
		</table>
		  </form>
	 </div><!--  modal body -->
</div> <!-- modal content -->
</div> <!-- modal dialog -->	
