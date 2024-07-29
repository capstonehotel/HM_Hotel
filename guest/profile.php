<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>

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
  
$guest = New Guest();
$res = $guest->single_guest($_SESSION['GUESTID']);

?>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">My Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="guest/update.php">
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">First Name:</label>
                <input name="name" type="text" value="<?php echo $res->G_FNAME; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Last Name:</label>
                <input name="last" type="text" value="<?php echo $res->G_LNAME; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
  <div class="mb-3">
    <label for="exampleFormControlSelect1" class="form-label">Gender:</label>
    <select name="gender" class="form-control" id="exampleFormControlSelect1">
      <option value="Male" <?php if ($res->G_GENDER == 'Male') echo 'selected'; ?>>Male</option>
      <option value="Female" <?php if ($res->G_GENDER == 'Female') echo 'selected'; ?>>Female</option>
    </select>
  </div>
</div>
<div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">City:</label>
                <input name="last" type="text" value="<?php echo $res->G_CITY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Address:</label>
                <input name="last" type="text" value="<?php echo $res->G_ADDRESS; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Date of Birth:</label>
                <input name="last" type="text" value="<?php echo $res->G_DBIRTH; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone:</label>
                <input name="last" type="text" value="<?php echo $res->G_PHONE; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nationality:</label>
                <input name="last" type="text" value="<?php echo $res->G_NATIONALITY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Company:</label>
                <input name="last" type="text" value="<?php echo $res->G_COMPANY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Address:</label>
                <input name="last" type="text" value="<?php echo $res->G_CADDRESS; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Zip Code:</label>
                <input name="last" type="text" value="<?php echo $res->ZIP; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>


<!-- <div class="container " style="max-width: 1000px; padding: 20px; margin-top: 20px;">
  <form class="form-horizontal" action="guest/update.php" method="post" onsubmit="return personalInfo()" name="personal" >
    <div class="row card">
      <section class="content-header">
        <h1>
          My Account 
         
        </h1>
      </section>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">First Name:</label>
        <input name="name" type="text"  value="<?php echo $res->G_FNAME; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Last Name:</label>
        <input name="last" type="text" value="<?php echo $res->G_LNAME; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
      <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Gender:</label>
        <input name="gender" type="text" value="<?php echo $res->G_GENDER; ?>" class="form-control" id="exampleFormControlInput1" placeholder="GENDER">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">City:</label>
        <input name="city" type="text" value="<?php echo $res->G_CITY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Address:</label>
        <input name="address" type="text" value="<?php echo $res->G_ADDRESS; ?>"  class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Date of Birth:</label>
        <input type="text" name="dbirth" value="<?php echo  date($res->DBIRTH); ?>"  class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Phone:</label>
        <input name="phone" type="text" value="<?php echo $res->G_PHONE; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Nationality:</label>
        <input name="nationality" type="text" value="<?php echo $res->G_NATIONALITY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Company:</label>
        <input  name="company" type="text" value="<?php echo $res->G_COMPANY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Address:</label>
        <input name="caddress" type="text" value="<?php echo $res->G_CADDRESS; ?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Zip Code:</label>
        <input name="zip" type="text" value="<?php echo $res->ZIP; ?>"  class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
     <!-- </div> -->

     <div class="col-md-12 col-sm-12">
       
         <input name="submit" type="submit" value="Save"  class="btn btn-primary" onclick="return personalInfo();"/>
      
     </div>
     </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>


<script type="text/javascript">
 $('.date_pickerfrom').datetimepicker({
  format: 'mm/dd/yyyy',
   startDate : '01/01/2000', 
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1, 
    startView: 2,
    minView: 2,
    forceParse: 0 

    });


$('.date_pickerto').datetimepicker({
  format: 'mm/dd/yyyy',
   startDate : '01/01/2000', 
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1, 
    startView: 2,
    minView: 2,
    forceParse: 0   

    });



$(document).ready( function() {

    $('.gallery-item').hover( function() {
        $(this).find('.img-title').fadeIn(400);
    }, function() {
        $(this).find('.img-title').fadeOut(100);
    });
  
});



$('.dbirth').datetimepicker({
  format: 'mm/dd/yyyy',
   startDate : '01/01/1960', 
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1, 
    startView: 2,
    minView: 2,
    forceParse: 0   

    });



  //Validates Personal Info
        function personalInfo(){
        var a=document.forms["personal"]["name"].value;
        var b=document.forms["personal"]["last"].value;
         var b1=document.forms["personal"]["gender"].value;
        var c=document.forms["personal"]["city"].value;
        var d=document.forms["personal"]["address"].value;
        var e=document.forms["personal"]["dbirth"].value;  
        var f=document.forms["personal"]["zip"].value; 
        var g=document.forms["personal"]["phone"].value;
        var h=document.forms["personal"]["username"].value;
        var i=document.forms["personal"]["password"].value;


        // var atpos=f.indexOf("@");
        // var dotpos=f.lastIndexOf(".");
        // if (atpos<1 || dotpos<atpos+2 || dotpos+2>=f.length)
        //   {
        //   alert("Not a valid e-mail address");
        //   return false;
        //   }
        // if( f != g ) {
        // alert("email does not match");
        //   return false;
        // }
         if (document.personal.condition.checked == false)
        {
        alert ('pls. agree the term and condition of this hotel');
        return false;
        }
        if ((a=="Firstname" || a=="") || (b=="lastname" || b=="") || (b1=="gender" || b1=="") (c=="City" || c=="") || (d=="address" || d=="") || (e=="dateofbirth" || e=="") || (f=="Zip" || f=="") || (g=="Phone" || g=="")|| (h=="username" || h=="") || (j=="password" || j==""))
          {
          alert("all field are required!");
          return false;
          }


   
        
        // else
        // {
        // return true;
        // }

        }
</script>
<script>
    $(document).ready(function() {
      $('#profileModal').on('show.bs.modal', function (e) {
        var modal = $(this);
        modal.find('.modal-body').load('guest/profile.php', function() {
          // Adjust form field sizes if necessary
          $('.form-control').css('width', '100%');
        });
      });
    });
  </script>
<!-- </html> -->