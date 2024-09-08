<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-start; width: 100%;">
                <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;">Back</a>
                <h6 class="m-0 font-weight-bold text-primary">View Booking</h6>
            </div>
            <div style="display: flex; justify-content: flex-end; width: 100%;">
                <?php
                if (!defined('WEB_ROOT')) {
                    exit;
                }

                $code = $_GET['code'];

                $query = "SELECT `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `TRANSDATE`, `G_GENDER`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS`
                          FROM `tblpayment` p, `tblguest` g
                          WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE` = '$code'";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) { 
                ?>
                    <?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
                        <div class="action-buttons">
                            <?php if ($row['STATUS'] == "Confirmed") { ?>
                                <button class="btn btn-danger btn-sm ml-2 action-btn" data-action="cancel" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Cancel</button>
                                <button class="btn btn-success btn-sm ml-2 action-btn" data-action="checkin" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Check In</button>
                            <?php } elseif ($row['STATUS'] == "Checkedin") { ?>
                                <button class="btn btn-warning btn-sm ml-2 action-btn" data-action="checkout" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Check Out</button>
                            <?php } elseif ($row['STATUS'] == "Checkedout") { ?>
                                <button class="btn btn-danger btn-sm ml-2 action-btn" data-action="delete" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Delete</button>
                            <?php } else { ?>
                                <button class="btn btn-success btn-sm ml-2 action-btn" data-action="confirm" data-code="<?php echo $row['CONFIRMATIONCODE']; ?>">Confirm</button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } } ?>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>Guest Information</h3>
                    <ul>
                        <li>Firstname: <span class="pull-right"><?php echo $row['G_FNAME']; ?></span></li>
                        <li>Lastname: <span class="pull-right"><?php echo $row['G_LNAME']; ?></span></li>
                        <li>Address: <span class="pull-right"><?php echo $row['G_ADDRESS']; ?></span></li>
                        <li>Gender: <span class="pull-right"><?php echo $row['G_GENDER']; ?></span></li>
                    </ul>
                </div>
            </div>

            <hr>

            <?php
            $query = "SELECT * 
                      FROM `tblreservation` r, `tblguest` g, `tblroom` rm, `tblaccomodation` a
                      WHERE r.`ROOMID` = rm.`ROOMID`
                      AND a.`ACCOMID` = rm.`ACCOMID`
                      AND g.`GUESTID` = r.`GUESTID`
                      AND r.`STATUS` <> 'Cancelled'
                      AND `CONFIRMATIONCODE` = '$code'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $image = '../mod_room/' . $row['ROOMIMAGE'];
                    $day = dateDiff(date($row['ARRIVAL']), date($row['DEPARTURE']));
            ?>

            <div class="row">
                <div class="col-md-6 col-sm-12" style="text-align: center;">
                    <img class="img-responsive img-hover" height="200px" width="250px" src="<?php echo $image; ?>" alt="">
                </div>
                <div class="col-md-6 col-sm-12">
                    <h3><?php echo $row['ROOM']; ?> [ <small><?php echo $row['ACCOMODATION']; ?></small> ]</h3>
                    <p><strong>Check-in: </strong><?php echo date_format(date_create($row['ARRIVAL']), 'm/d/Y'); ?></p>
                    <p><strong>Check-out: </strong><?php echo date_format(date_create($row['DEPARTURE']), 'm/d/Y'); ?></p>
                    <p><strong>Night(s): </strong><?php echo ($day == 0) ? '1' : $day; ?></p>
                    <p><strong>Price: &#8369</strong><?php echo $row['RPRICE']; ?></p>
                </div>
            </div>

            <hr>

            <?php } } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const code = this.getAttribute('data-code');

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${action} this booking?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `controller.php?action=${action}&code=${code}`;
                }
            });
        });
    });
</script>
