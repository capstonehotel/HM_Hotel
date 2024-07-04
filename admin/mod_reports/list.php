
<div class="container-fluid">
  <div class="card shadow mb-4">
      <div class="card-header py-3"  style="display: flex;align-items: center;">
          <h6 class="m-0 font-weight-bold text-primary">Reports | Date: <?php echo date('m/d/Y'); ?></h6>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="row mb-4" >
            <div class="col-md-2 col-sm-12 mb-2">
              <select name="room" class="form-control">
            <?php 
              $sql = "SELECT * FROM tblroom ORDER BY ROOMID";
              $result = $connection->query($sql);
              while ($row = $result->fetch_assoc()) {
             ?>
                <option value="<?php echo $row['ROOMID'] ?>"><?php echo $row['ROOM'] ?> | <?php echo $row['ROOMDESC'] ?></option>
            <?php } ?>
              </select>
            </div>
            <div class="col-md-2 col-sm-12 mb-2">
              <select name="status" class="form-control">
                <option value="Checkedin">Checkedin</option>
                <option value="Checkedout">Checkedout</option>
                <option value="Arrival">Arrival</option>
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
              </select>
            </div>
            <div class="col-md-3 col-sm-12 mb-2">
              <input class="form-control  " size="20" type="date" value="<?php echo (isset($_POST['start'])) ? $_POST['start'] : date('Y-m-d'); ?>" Placeholder="Check In" name="start" id="from" data-date="" data-date-format="yyyy-mm-dd" data-link-field="any" data-link-format="yyyy-mm-dd">
            </div>
            <div class="col-md-3 col-sm-12 mb-2">
              <input class="form-control" size="20" type="date" value="<?php echo (isset($_POST['end'])) ? $_POST['end'] : date('Y-m-d'); ?>"  name="end" id="end" data-date="" data-date-format="yyyy-mm-dd" data-link-field="any" data-link-format="yyyy-mm-dd">
            </div>
            <div class="col-md-2 col-sm-12 mb-2">
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
        <div class="table-responsive" style="width: 100%;">
          <?php if(isset($_POST['submit'])){ ?>
          <table class="table table-striped" width="100%" cellspacing="0">
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

                $end = date('Y-m-d', strtotime($end . ' +1 day'));
                $start = date('Y-m-d', strtotime($start . ' +1 day'));


                $sql = "SELECT * FROM tblreservation tr INNER JOIN tblpayment tp ON tr.CONFIRMATIONCODE = tp.CONFIRMATIONCODE INNER JOIN tblroom r ON tr.ROOMID = r.ROOMID INNER JOIN tblaccomodation a ON r.ACCOMID = a.ACCOMID INNER JOIN tblguest g ON tr.GUESTID = g.GUESTID WHERE tr.TRANSDATE BETWEEN '$start' AND '$end' AND tr.ROOMID = '$room' AND tr.STATUS = '$status' ";
                $result = mysqli_query($connection, $sql);
$total = 0;
                if ($result) {
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
                      <td><?php echo ($days==0) ? '0' : $days;?></td>
                      <td>&#8369 <?php echo $row['RPRICE'];?></td>
                    </tr>
                    <?php }
                    } else {
                        echo "No reservations found within the specified date range.";
                    }
                } else {
                    echo "Error: " . mysqli_error($connection);
                } ?>
              
            <tr>
              <td colspan="5"></td>
              <td colspan="1"> TOTAL</td>
              <td colspan="1">&#8369 <?php echo $total ?></td>
            </tr>
            </tbody>
            </table>
            <div style="width: 100%; display: flex; justify-content: flex-end;" >
              <form action="printreport.php" method="POST" target="_blank">
                <input type="hidden" name="room" value="<?php echo $room ?>">
                <input type="hidden" name="status" value="<?php echo $status ?>">
                <input type="hidden" name="start" value="<?php echo  $start?>">
                <input type="hidden" name="end" value="<?php echo $end ?>">
                <button type="submit" class="btn btn-primary"  ><i class="fa fa-print"></i> Print</button>
              </form>
            </div>
        </div>
        <?php }
            ?>
      </div>
  </div>
</div>