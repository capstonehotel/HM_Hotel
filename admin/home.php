
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


 if (!isset($_SESSION['ADMIN_ID'])){
    redirect('login.php');
    return true;
 }
// Initialize the connection (assuming $connection is available)
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Queries for dashboard statistics
$queries = [
    'totalRooms' => "SELECT count(*) as 'Total' FROM `tblroom` WHERE ROOM != ''",
    'totalReservations' => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS != ''",
    'cancelledReservations' => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Cancelled'",
    'bookingsToday' => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE DATE(TRANSDATE) = DATE(NOW())",
    'confirmedReservations' => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Confirmed'",
    'checkedInGuests' => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedin'",
    'checkedOutGuests' => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedout'"
];

$stats = [];
foreach ($queries as $key => $query) {
    $result = mysqli_query($connection, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stats[$key] = $row['Total'];
    } else {
        $stats[$key] = 'Error';
    }
}
?>
<div class="col-xl-4 col-md-6 mb-4" >
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Rooms</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($result->Total) ? $result->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-bed fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Reservation</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resulta->Total) ? $resulta->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Cancelled</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fa fa-times fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Booking Today</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fa fa-calendar fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Confirm Booking</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Check-in Guest</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Graph</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myChart" style="width:auto; max-width: 650px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="bar.js"></script>
<?php 








$sqli="SELECT count(*) FROM  `tblreservation` WHERE TRANSDATE=DATE(NOW()) != 'Booked' ";
    $resultas=mysqli_query($connection,$sqli);
    $cnt5=mysqli_fetch_array($resultas);

    $sli="SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Cancelled' ";
    $resulta=mysqli_query($connection,$sli);
    $cnt1=mysqli_fetch_array($resulta);

$sqla="SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Confirmed' ";
    $res=mysqli_query($connection,$sqla);
    $cntaS=mysqli_fetch_array($res);
$sqlaS="SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Checkedin' ";
    $resT=mysqli_query($connection,$sqlaS);
    $cntS=mysqli_fetch_array($resT);

$select="SELECT count(*) FROM tblroom where ROOM != '' ";
    $result=mysqli_query($connection,$select);
    $cnt=mysqli_fetch_array($result);


// $query=" SELECT COUNT(*) FROM `tblreservation` WHERE TRANSDATE=DATE(NOW())!= 'Booked' ";
//      $resultas=mysqli_query($connection,$query);
//     $cnt5=mysqli_fetch_array($resultas);

 ?>
<script>
var xValues = ["Booked", "Confirmed", "Cancelled", "Checked in", "Rooms"];
var yValues = [<?php echo $cnt5[0]; ?>, <?php echo $cntaS[0]; ?>, <?php echo $cnt1[0]; ?>, <?php echo $cntS[0]; ?>,<?php echo $cnt[0]; ?>];
var barColors = ["red","green","blue","orange","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "ROOM"
    }
  }
});
</script>
