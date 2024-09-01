<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

if (!isset($_SESSION['monbela_cart'])) {
  # code...
  redirect(WEB_ROOT.'index.php');
}

function createRandomPassword() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";

    srand((double)microtime()*1000000);

    $i = 0;

    $pass = '' ;
    while ($i <= 7) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $pass = $pass . $tmp;

        $i++;

    }

    return $pass;

}

 $confirmation = createRandomPassword();
$_SESSION['confirmation'] = $confirmation;



// $arival    = $_SESSION['from']; 
// $departure = $_SESSION['to'];
// echo $name      = $_SESSION['name']; 
// echo $last      = $_SESSION['last'];
// echo $nationality   = $_SESSION['nationality'];
// // echo // $city      = $_SESSION['city'] ;
// echo $address   =  $_SESSION['city'] . ' ' . $_SESSION['address'];
// echo $zip       = $_SESSION['zip'] ;
// echo $phone     = $_SESSION['phone'];
// echo $username     = $_SESSION['username'];
// echo $company     = $_SESSION['company'];
// echo $caddress     = $_SESSION['caddress'];
// echo $password  = $_SESSION['pass'];
// echo $dbirth   = $_SESSION['dbirth'];


 $count_cart = count($_SESSION['monbela_cart']);

if(isset($_POST['btnsubmitbooking'])){
  // $message = $_POST['message'];

 


//    $count_cart = count($_SESSION['monbela_cart']);

//   for ($i=0; $i < $count_cart  ; $i++) {     
//   $mydb->setQuery("SELECT * FROM room where roomNo=". $_SESSION['monbela_cart'][$i]['monbelaroomid']);
//   $rmprice = $mydb->executeQuery();
//   while($row = mysql_fetch_assoc($rmprice)){
//     $rate = $row['price']; 
//   }  
// }
//   $payable= $rate*$days;
//   $_SESSION['pay']= $payable;

if(!isset($_SESSION['GUESTID'])){

  // var_dump($_SESSION);exit;

$guest = New Guest();
$guest->G_AVATAR          = $_SESSION['image'];
$guest->G_FNAME          = $_SESSION['name'];    
$guest->G_LNAME          = $_SESSION['last'];  
$guest->G_CITY           = $_SESSION['city'];
$guest->G_ADDRESS        = $_SESSION['address'] ;        
$guest->DBIRTH           = date_format(date_create($_SESSION['dbirth']), 'Y-m-d');   
$guest->G_PHONE          = $_SESSION['phone'];    
$guest->G_NATIONALITY    = $_SESSION['nationality'];          
$guest->G_COMPANY        = $_SESSION['company'];      
$guest->G_CADDRESS       = $_SESSION['caddress'];        
$guest->G_TERMS          = 1;    
$guest->G_UNAME          = $_SESSION['username'];    
$guest->G_PASS           = sha1($_SESSION['pass']);    
$guest->ZIP              = $_SESSION['zip'];
$guest->create(); 
  $lastguest=$guest->id; 
   
$_SESSION['GUESTID'] =   $lastguest;

}
 
    $count_cart = count($_SESSION['monbela_cart']);
  

    for ($i=0; $i < $count_cart  ; $i++) { 

            // $rm = new Room();
            // $result = $rm->single_room($_SESSION['monbela_cart'][$i]['monbelaroomid']);

            // if($result->ROOMNUM>0){

            //   $room = new Room(); 
            //   $room->ROOMNUM    = $room->ROOMNUM - 1; 
            //   $room->update($_SESSION['monbela_cart'][$i]['monbelaroomid']); 
      
            // }
            

            $reservation = new Reservation();
            $reservation->CONFIRMATIONCODE  = $_SESSION['confirmation'];
            $reservation->TRANSDATE         = date('Y-m-d h:i:s'); 
            $reservation->ROOMID            = $_SESSION['monbela_cart'][$i]['monbelaroomid'];
            $reservation->ARRIVAL           = date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckin']), 'Y-m-d');  
            $reservation->DEPARTURE         = date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckout']), 'Y-m-d'); 
            $reservation->RPRICE            = $_SESSION['monbela_cart'][$i]['monbelaroomprice'];  
            $reservation->GUESTID           = $_SESSION['GUESTID']; 
            $reservation->PRORPOSE          = 'Travel';
            $reservation->STATUS            = 'Pending';
            $reservation->create(); 

            
            @$tot += $_SESSION['monbela_cart'][$i]['monbelaroomprice'];
            }

           $item = count($_SESSION['monbela_cart']);

      $sql = "INSERT INTO `tblpayment` (`TRANSDATE`,`CONFIRMATIONCODE`,`PQTY`, `GUESTID`, `SPRICE`,`MSGVIEW`,`STATUS`)
       VALUES ('" .date('Y-m-d h:i:s')."','" . $_SESSION['confirmation'] ."',".$item."," . $_SESSION['GUESTID'] . ",".$tot.",0,'Pending')" ;
        // mysql_query($sql);





     $mydb->setQuery($sql);
     $msg = $mydb->executeQuery();

    //   $lastreserv=mysql_insert_id(); 
    //   $mydb->setQuery("INSERT INTO `comments` (`firstname`, `lastname`, `email`, `comment`) VALUES('$name','$last','$email','$message')");
    //   $msg = $mydb->executeQuery();
    //   message("New [". $name ."] created successfully!", "success");

  //  unsetSessions();

            unset($_SESSION['monbela_cart']);
            // unset($_SESSION['confirmation']);
            unset($_SESSION['pay']);
            unset($_SESSION['from']);
            unset($_SESSION['to']);
            $_SESSION['activity'] = 1;

            

echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Booking is successfully submitted!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '" . WEB_ROOT . "index.php';
        });
    </script>";
}
?>
<div class="card rounded" style="padding: 10px;">
    <div  class="pagetitle">   
        <h1  >Billing Details 
        </h1> 
    </div>
    <nav aria-label="breadcrumb" >
      <ol class="breadcrumb" style="margin-top: 10px;">
        <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/booking/">Booking Cart</a></li> 
        <li class="breadcrumb-item active" aria-current="page">Billing Details </li>
      </ol>
    </nav>
      <div class="container">
        <div class="row">
            <form action="index.php?view=payment" method="post"  name="personal" >

            <div class="col-md-8 col-sm-4">

                <div class="col-md-12">
                  <label>Name:</label>
                  <?php echo $_SESSION['name'] . ' '. $_SESSION['last']; 
                        echo $count_cart;
                   ?>
                </div>
                <div class="col-md-12">
                  <label>Address:</label>
                  <?php echo isset($_SESSION['city']) ? $_SESSION['city']: ' '. ' ' .( isset($_SESSION['address'])  ? $_SESSION['address'] : ' '); ?> 
                </div>
                <div class="col-md-12"> 
                <label>Phone #:</label>
                 <?php echo $_SESSION['phone'] ; ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-2">
              <div class="col-md-12">
                <label>Transaction Date:</label>
               <?php echo date("m/d/Y") ; ?>
              </div>
               <div class="col-md-12">
                <label>Transaction Id:</label>
               <?php echo $_SESSION['confirmation']; ?>
              </div>
              
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                          <td>Room</td>
                          <td>Checked in</td>
                          <td>Checked out</td>
                          <td>Price</td>
                          <td>Night(s)</td>
                          <td>Subtotal</td>
                        </tr>
                      </thead> 
                      <?php
$payable = 0;
if (isset( $_SESSION['monbela_cart'])){ 
$count_cart = count($_SESSION['monbela_cart']);


for ($i=0; $i < $count_cart  ; $i++) {  

  $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND ROOMID=" . $_SESSION['monbela_cart'][$i]['monbelaroomid'];
   $mydb->setQuery($query);
   $cur = $mydb->loadResultList(); 
    foreach ($cur as $result) { 


?>

      
        <tr>
          <td><?php echo  $result->ROOM.' '. $result->ROOMDESC; ?></td>
          <td><?php echo  date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckin']),"m/d/Y"); ?></td>
          <td><?php echo  date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckout']),"m/d/Y"); ?></td>
          <td><?php echo  ' &#8369 '. $result->PRICE; ?></td>
          <td><?php echo   $_SESSION['monbela_cart'][$i]['monbeladay']; ?></td>
          <td><?php echo ' &#8369 '.   $_SESSION['monbela_cart'][$i]['monbelaroomprice']; ?></td>
        </tr>
<?php
       $payable += $_SESSION['monbela_cart'][$i]['monbelaroomprice'] ;
      }

    } 
     $_SESSION['pay'] = $payable;
 } 
 ?> 
      </tbody>
                 </table>
            </div>
                <div id="confirmModal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" >
            <div class="modal-body">
                <p>Are you sure you want to submit the booking?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary" align="right" name="btnsubmitbooking">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="row"> 
  <h3 align="right">Total: &#8369 <?php echo   $_SESSION['pay'] ;?></h3>
</div>
    <div class="pull-right flex-end" align="right">
       <button  type="button" class="btn btn-primary" align="right"   onclick="showConfirmAlert()" >Submit Booking</button>
    </div>
</form>
  </div>  
        </div>
      </div>
</div>
<style>
        .swal2-cancel {
            background-color: red;
            color: white;
            margin-left: 10px;
        }
        .swal2-cancel:hover, .swal2-cancel:focus {
            background-color: #b22222; /* Slightly darker red */
            color: white;
        }
    </style>
<script>
function showConfirmAlert() {
    Swal.fire({
        title: 'Are you sure you want to submit the booking?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-default'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form to submit the booking
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = ''; // Set the form action if needed
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'btnsubmitbooking';
            input.value = '1'; // Set the value if needed
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
