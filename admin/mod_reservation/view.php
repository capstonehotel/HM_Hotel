 <!-- Your existing head content -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-end;">
                <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;">Back</a>
                <h6 class="m-0 font-weight-bold text-primary ml-10">View Booking</h6>
            </div>
            <div style="display: flex; width: 90%; justify-content: flex-end;">
                <?php
                if (!defined('WEB_ROOT')) {
                    exit;
                }

                $code = $_GET['code'];

                $query = "SELECT `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `TRANSDATE`, `G_GENDER`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                          FROM `tblpayment` p
                          JOIN `tblguest` g ON p.`GUESTID` = g.`GUESTID`
                          WHERE `CONFIRMATIONCODE` = '".$code."'";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>

                        <?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
                            <?php if ($row['STATUS'] == "Confirmed") { ?>
                                <a href="#" class="btn btn-danger btn-sm ml-2" onclick="handleAction('cancel', '<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="icon-edit">Cancel</i></a>
                                <a href="#" class="btn btn-success btn-sm ml-2" onclick="handleAction('checkin', '<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="icon-edit">Check in</i></a>
                            <?php } elseif ($row['STATUS'] == 'Checkedin') { ?>
                                <a href="#" class="btn btn-warning btn-sm ml-2" onclick="handleAction('checkout', '<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="icon-edit">Check out</i></a>
                            <?php } elseif ($row['STATUS'] == 'Checkedout') { ?>
                                <a href="#" class="btn btn-danger btn-sm ml-2" onclick="handleAction('delete', '<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="icon-edit">Delete</i></a>
                            <?php } else { ?>
                                <a href="#" class="btn btn-success btn-sm ml-2" onclick="handleAction('confirm', '<?php echo $row['CONFIRMATIONCODE']; ?>')"><i class="icon-edit">Confirm</i></a>
                            <?php } ?>
                        <?php } ?>

                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="card-body">
            <div class="row" style="width: 100%;">
                <div class="col-md-12 col-sm-12" style="margin-top: 10px;">
                    <div class="box box-solid">
                        <div class="">
                            <h3>Guest Information</h3>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav" style="display: block;">
                                <li class="active"><a>Firstname:
                                    <span class="pull-right"><?php echo $row['G_FNAME']; ?></span></a></li>
                                <li class="active"><a>Lastname:
                                    <span class="pull-right"><?php echo $row['G_LNAME']; ?></span></a></li>
                                <li class="active"><a>Address:
                                    <?php echo $row['G_ADDRESS']; ?> </a></li>
                                <li class="active"><a>Gender:
                                    <?php echo $row['G_GENDER']; ?> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php
                $query = "SELECT * 
                          FROM `tblreservation` r
                          JOIN `tblguest` g ON g.`GUESTID` = r.`GUESTID`
                          JOIN `tblroom` rm ON r.`ROOMID` = rm.`ROOMID`
                          JOIN `tblaccomodation` a ON a.`ACCOMID` = rm.`ACCOMID`
                          WHERE r.`STATUS` <> 'Cancelled' AND `CONFIRMATIONCODE` = '".$code."'";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = WEB_ROOT. 'admin/mod_room/'.$row['ROOMIMAGE'];  
                        $day = dateDiff(date($row['ARRIVAL']), date($row['DEPARTURE']));
                        ?>
                        <div class="col-md-6 col-sm-12" style="margin-top: 10px; text-align: center;">
                            <img class="img-responsive img-hover" height="200px" width="250px" src="<?php echo $image; ?>" alt="">
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-top: 10px;">
                            <div class="box box-solid">
                                <ul class="nav nav-pills nav-stacked">
                                    <li>
                                        <h3>
                                            <?php echo $row['ROOM']; ?> [ <small><?php echo $row['ACCOMODATION']; ?></small> ]
                                        </h3>
                                    </li>
                                </ul>
                                <p><strong>Check-in: </strong><?php echo date_format(date_create($row['ARRIVAL']), 'm/d/Y');?></p>
                                <p><strong>Check-out: </strong><?php echo date_format(date_create($row['DEPARTURE']), 'm/d/Y'); ?></p>
                                <p><strong>Night(s): </strong><?php echo ($day == 0) ? '1' : $day; ?></p>
                                <p><strong>Price: &#8369</strong><?php echo $row['RPRICE']; ?></p>
                            </div>
                        </div>
                        <br><hr>
                    <?php }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
function handleAction(action, code) {
    let url = 'controller.php?action=' + action + '&code=' + code;
    
    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'Operation completed successfully.',
                icon: 'success'
            }).then(() => {
                location.reload(); // Reload the page to update the view
            });
        },
        error: function() {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while processing your request.',
                icon: 'error'
            });
        }
    });
}
</script>
