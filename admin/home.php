<?php
// Load required files
require_once("../includes/config.php");
require_once("../includes/functions.php");
require_once("../includes/session.php");
require_once("../includes/user.php");
require_once("../includes/pagination.php");
require_once("../includes/paginsubject.php");
require_once("../includes/accomodation.php");
require_once("../includes/guest.php");
require_once("../includes/reserve.php");
require_once("../includes/setting.php");
require_once("../includes/database.php");

if (!isset($_SESSION['ADMIN_ID'])) {
    redirect('login.php');
    return true;
}

// Fetch data for cards
$queries = [
    "rooms" => "SELECT count(*) as 'Total' FROM `tblroom` WHERE ROOM != ''",
    "reservations" => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS != ''",
    "cancelled" => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Cancelled'",
    "bookings_today" => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE TRANSDATE=DATE(NOW())",
    "confirmed" => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Confirmed'",
    "checked_in" => "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedin'"
];

$results = [];

foreach ($queries as $key => $query) {
    $mydb->setQuery($query);
    $results[$key] = $mydb->loadResultList();
}

$cardData = [
    "rooms" => ["Rooms", "fas fa-bed", $results['rooms']],
    "reservations" => ["Reservation", "fas fa-book", $results['reservations']],
    "cancelled" => ["Cancelled", "fa fa-times", $results['cancelled']],
    "bookings_today" => ["Booking Today", "fa fa-calendar", $results['bookings_today']],
    "confirmed" => ["Confirmed Booking", "fas fa-check", $results['confirmed']],
    "checked_in" => ["Check-in Guest", "fas fa-user", $results['checked_in']]
];

?>

<?php foreach ($cardData as $data) { ?>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <?php echo $data[0]; ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo isset($data[2][0]->Total) ? $data[2][0]->Total : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="<?php echo $data[1]; ?> fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
$counts = [
    "booked" => "SELECT count(*) FROM `tblreservation` WHERE TRANSDATE=DATE(NOW()) != 'Booked'",
    "cancelled" => "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Cancelled'",
    "confirmed" => "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Confirmed'",
    "checked_in" => "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Checkedin'",
    "rooms" => "SELECT count(*) FROM `tblroom` WHERE ROOM != ''"
];

$dataCounts = [];
foreach ($counts as $key => $query) {
    $result = mysqli_query($connection, $query);
    $dataCounts[$key] = mysqli_fetch_array($result);
}
?>

<script>
var xValues = ["Booked", "Confirmed", "Cancelled", "Checked in", "Rooms"];
var yValues = [
    <?php echo $dataCounts['booked'][0]; ?>, 
    <?php echo $dataCounts['confirmed'][0]; ?>, 
    <?php echo $dataCounts['cancelled'][0]; ?>, 
    <?php echo $dataCounts['checked_in'][0]; ?>, 
    <?php echo $dataCounts['rooms'][0]; ?>
];
var barColors = ["red", "green", "blue", "orange", "brown"];

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
    legend: { display: false },
    title: {
      display: true,
      text: "ROOM"
    }
  }
});
</script>
