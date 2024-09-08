

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-end;">
                <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;" >Back</a>
                <h6 class="m-0 font-weight-bold text-primary ml-10">View Booking</h6>
            </div>
            <div style="display: flex; width: 90%; justify-content: flex-end;">
                <?php
if (!defined('WEB_ROOT')) {
    exit;
}

$code=$_GET['code'];


 
        $query="SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS` ,  `TRANSDATE` , `G_GENDER`, `CONFIRMATIONCODE` ,  `PQTY` ,  `SPRICE` ,`STATUS`
                FROM  `tblpayment` p,  `tblguest` g
                WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE`='".$code."'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) { ?>

                                <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
                                    <?php if ($row['STATUS'] == "Confirmed" ) { ?>
                                        <a href="controller.php?action=cancel&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm ml-2" ><i class="icon-edit">Cancel</a>
                                        <a href="controller.php?action=checkin&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2" ><i class="icon-edit">Check in</a>
                                    <?php } elseif($row['STATUS'] == 'Checkedin') {?>
                                        <a href="controller.php?action=checkout&code=<?php echo $row['CONFIRMATIONCODE'];?>" class="btn btn-warning btn-sm ml-2" ><i class="icon-edit">Check out</a>
                                    <?php } elseif($row['STATUS'] == 'Checkedout') {?>
                                <a href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm ml-2    " ><i class="icon-edit">Delete</a>
                                    <?php } else {?>
                                        <a href="controller.php?action=confirm&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2"  ><i class="icon-edit">Confirm</a>


                                            <?php } ?>
                                 <?php } ?>

                                 <!-- <a href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm " style="margin-left: 3px!important;"><i class="icon-edit">Delete</a>  -->
            
            </div>

        </div>

        <div class="card-body">
            <div class="row" style="width: 100%;">
                <div class="col-md-12 col-sm-12" style="margin-top: 10px;">  
          <div class="box box-solid">
            <div class="">
              <h3 >Guest Information</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav " style="display: block;">
                <li class="active"><a>Firstname:
                  <span class="pull-right"><?php echo $row['G_FNAME'] ; ?></span></a></li>
                <li class="active"><a>Lastname:
                <span class="pull-right"><?php echo $row['G_LNAME'] ; ?></span></a></li>
                <li class="active"><a>Address:
                <?php echo $row['G_ADDRESS'] ; ?> </a></li>
               <li class="active"><a>Gender:
                <?php echo $row['G_GENDER'] ; ?> </a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>

 </div> <br> <hr>
  <?php } 
            }
        



?>
                <?php 
                $query="SELECT * 
                FROM  `tblreservation` r,  `tblguest` g,  `tblroom` rm, tblaccomodation a
                WHERE r.`ROOMID` = rm.`ROOMID` 
                AND a.`ACCOMID` = rm.`ACCOMID` 
                AND g.`GUESTID` = r.`GUESTID`  AND r.`STATUS`<>'Cancelled'
                AND  `CONFIRMATIONCODE` = '".$code."'";
                $result = mysqli_query($connection, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image = '../mod_room/'.$row['ROOMIMAGE'];  
                $day=dateDiff(date($row['ARRIVAL']),date($row['DEPARTURE']));
                 ?>
                 <div class="col-md-6 col-sm-12 " style="margin-top: 10px; text-align: center;"> 
                    <img class="img-responsive img-hover" height="200px" width="250px" src="<?php echo $image ; ?>" alt=""> 
                </div>
                <div class="col-md-6 col-sm-12" style="margin-top: 10px;">
                    <div class="box box-solid">
                        <ul class="nav nav-pills nav-stacked">
                <li><h3>
                    <?php echo $row['ROOM']; ?> [ <small><?php echo $row['ACCOMODATION']; ?></small> ]
                </h3>
                </li>
            </ul>
                 
                <p><strong>Check-in: </strong><?php echo date_format(date_create( $row['ARRIVAL'] ),'m/d/Y');?></p>
                <p><strong>Check-out: </strong><?php echo date_format(date_create( $row['DEPARTURE'] ),'m/d/Y'); ?></p>
                <p><strong>Night(s): </strong><?php echo ($day==0) ? '1' : $day; ?></p>
                <p><strong>Price: &#8369</strong><?php echo $row['RPRICE' ]; ?></p>
                </div>
                </div>
                <br><hr>
             <?php } } ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle button click and make AJAX requests
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const code = this.getAttribute('data-code');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make the AJAX call
                    fetch(`controller.php?action=${action}&code=${code}`, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success');
                            // Optionally refresh part of the page or update UI
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'There was a problem performing the action.', 'error');
                    });
                }
            });
        });
    });
</script>