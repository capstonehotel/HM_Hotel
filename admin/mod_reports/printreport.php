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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title . ' | ' :  'HM Hotel Reservation' ; ?></title>


<link href="<?php echo WEB_ROOT; ?>/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo WEB_ROOT; ?>/admin/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/admin/css/jquery.dataTables.css">
<link href="<?php echo WEB_ROOT; ?>/admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>/admin/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>/admin/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>/admin/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/admin/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/admin/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
</head> 

 <body onload="window.print();"  style="margin-top:100px; width: 100vh;" >
<div class="wrapper"> 
 
    <form action="" method="POST" >
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
      <div class="">
        <table class="table table-striped" width="90%" cellspacing="0">
            <thead>
              <tr>
                <th>Invoice No.</th>
                <th>Guest</th>
                <th>Room</th>
                <th>Price</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Night(s)</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
      <?php 

      $start = $_POST['start'];
                $end = $_POST['end'];
                $room = $_POST['room'];
                $status = $_POST['status'];
              
                
  $sql = "SELECT * FROM tblreservation tr INNER JOIN tblpayment tp ON tr.CONFIRMATIONCODE = tp.CONFIRMATIONCODE INNER JOIN tblroom r ON tr.ROOMID = r.ROOMID INNER JOIN tblaccomodation a ON r.ACCOMID = a.ACCOMID INNER JOIN tblguest g ON tr.GUESTID = g.GUESTID WHERE tr.TRANSDATE BETWEEN '$start' AND '$end' AND tr.ROOMID = '$room' AND tr.STATUS = '$status' ";

  $result = mysqli_query($connection, $sql);
  $total = 0;
  if (mysqli_num_rows($result) > 0) { 
    while ($row = mysqli_fetch_assoc($result)) {
                        $days =  dateDiff(date($row['ARRIVAL']),date($row['DEPARTURE']));
                        $total += $row['RPRICE'] ;
  ?>

            <tr> 
                      <td>000<?php echo $row['RESERVEID'];?></td>
                      <td><?php echo $row['G_FNAME'];?> <?php echo $row['G_LNAME'];?></td>
                      <td><?php echo $row['ACCOMODATION'];?> <?php echo $row['ROOM'];?></td>
                      <td>&#8369 <?php echo $row['PRICE'];?></td>
                      <td><?php echo date_format(date_create($row['ARRIVAL']),'m/d/Y');?></td>
                      <td><?php echo date_format(date_create($row['DEPARTURE']),'m/d/Y');?></td>
                      <td><?php echo ($days==0) ? '1' : $days;?></td>
                      <td>&#8369 <?php echo $row['RPRICE'];?></td>
                    </tr>
                    <?php 
                    } ?>
            <tr>
              <td colspan="5"></td>
              <td colspan="1"> TOTAL</td>
              <td colspan="1">&#8369 <?php echo $total ?></td>
            </tr>
            </tbody>
            </table>
        </div>
        <?php }
            ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row" style="margin-top:50px">
        <!-- accepted payments column -->
   
      </div>

            <?php
             
              $id = $_SESSION['ADMIN_ID' ];
              $sql = "SELECT * FROM `tbluseraccount` WHERE `USERID` = '$id'";

              $result = mysqli_query($connection, $sql);
            ?>




      <!-- /.row -->
       <div class="col-xs-12 text-center" style="margin-top:100px">
       Issued by: <u>
                    <?php
                      while($row = mysqli_fetch_assoc($result)){
                        echo $row['UNAME'];
                      }
                    ?>
                  </u>
             <br><b>HM Head Department</b> 
        </div>



    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>

 
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 
</div>
<!-- ./wrapper --> 
</body>
<script>
  (function(){
    setTimeout(() => {
      window.close();
    }, 1200);
  })();
</script>
</html> 