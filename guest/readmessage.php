<?php
require_once("../includes/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title . ' | HM Hotel Reservation' :  ' HM Hotel Reservation' ; ?></title>
 
    
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/style.css">  
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/css/responsive.css">    

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/css/bootstrap.css">  

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/fonts/css/font-awesome.min.css"> 

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/css/custom-navbar.min.css"> 

<!-- DataTables CSS -->
<!-- <link href="<?php echo WEB_ROOT; ?>css/dataTables.bootstrap.css" rel="stylesheet"> -->
 
 <link href="<?php echo WEB_ROOT; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
 <link href="<?php echo WEB_ROOT; ?>css/datepicker.css" rel="stylesheet" media="screen">

 <link href="<?php echo WEB_ROOT; ?>/css/galery.css" rel="stylesheet" media="screen">
 <link href="<?php echo WEB_ROOT; ?>/css/ekko-lightbox.css" rel="stylesheet">
</head>
<body onload="window.print();">
<div class="wrapper">
  
  <?php 

  require_once("../includes/initialize.php");
 $query ="SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `G_CITY` , `ZIP`, `G_NATIONALITY`,`CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE` FROM `tblguest` g ,`tblreservation` r WHERE g.`GUESTID`=r.`GUESTID` and `CONFIRMATIONCODE` ='".$_GET['code']."'";
 $result = mysqli_query($connection, $query);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {

     ?>
    <form action="<?php echo WEB_ROOT;; ?>/guest/readprint.php?>" method="POST" target="_blank">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-building"></i>  HM Hotel Reservation
            <!-- <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small> -->
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong> HM Hotel Reservation </strong><br>
            Crossing Bunakan<br>
            Bunakan,Madridejos, Cebu<br>
            Phone: 09317622381<br>
            Email: Hmhotelreservation@gmail.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?> 
            </strong><br>
            <?php echo $row['G_ADDRESS']; ?>
            <?php echo $row['G_CITY']; ?>
              <br>
             <?php echo $row['G_NATIONALITY']; ?>
            <br>
            <?php echo $row['ZIP']; ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <!-- <br/> -->
        
         <b> <p style="background-color:white;color:black;">Invoice No.</b>00<?php echo $row['GUESTID']; ?></p> 
          <!-- <br> -->
          <b>Confirmation ID:</b> <p style="background-color:white;color:black;">  <?php echo $row['CONFIRMATIONCODE']; ?></p> 
          <input type="hidden" name="code" value="<?php echo $row['CONFIRMATIONCODE']; ?>">
<!-- <br> -->
          <b>Transaction Date:</b><?php echo $row['TRANSDATE']; ?> 
<br>
          <!-- <b>Account ID:</b><?php echo $row['GUESTID']; ?>  -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  <?php 
 }
}
 $query1 ="SELECT * FROM `tblaccomodation` A,`tblroom`  RM, `tblreservation` RS  WHERE  A.`ACCOMID`=RM.`ACCOMID` AND RM.`ROOMID`=RS.`ROOMID`  and `CONFIRMATIONCODE` ='".$_GET['code']."'";
  $result1 = mysqli_query($connection, $query1);
if ($result1) {
  while ($row1 = mysqli_fetch_assoc($result1)) {


     ?>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Room</th>
              <th>Description</th>
              <th>Price</th>
              <th>Checked in</th>
              <th>Checked out</th>
              <th>Night(s)</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php   
          $days =  dateDiff(date($row1['ARRIVAL']),date($row1['DEPARTURE']));
             ?>

            <tr> 
              <td> <?php echo $row1['ACCOMODATION']; ?> <?php echo $row1['ROOM']; ?></td>
              <td> <?php echo $row1['ROOMDESC']; ?> <br> <?php echo $row1['NUMPERSON']; ?> </td>
              <td> &#8369 <?php echo $row1['PRICE']; ?></td>
              <td><?php echo date_format(date_create($row1['ARRIVAL']),'m/d/Y');?> </td>
              <td><?php echo date_format(date_create($row1['DEPARTURE']),'m/d/Y');?> </td>
              <td><?php echo ($days==0) ? '1' : $days;?> </td>
              <td> &#8369 <?php echo $row1['RPRICE']; ?></td>
            </tr>
            
            
            <?php 
              @$tot += $row1['RPRICE'];
            } } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
         <!--  <p class="lead">Payment Methods:</p>
          <img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total Amount</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <td> &#8369 <?php echo @$tot ; ?></td>
              </tr>
         <!--      <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr> -->
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <!-- <a href="<?php echo WEB_ROOT; ?>guest/readprint.php?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          <!-- <button type="submit"  ><i class="fa fa-print"></i> Print</button> -->
  <!--         <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button> -->
        </div>
      </div>
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 
</div>
<!-- ./wrapper -->
</body>
</html>