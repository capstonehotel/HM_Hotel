<?php 
	$conn = mysqli_connect('localhost', 'root', '', 'hmsystemdb');

    $id = $_GET['id'];
    // echo $id;
  
    $sqli = "DELETE FROM `tblroom` WHERE 'ROOM' = '$id'";
    // $sql = "SELECT * FROM `tblroom` WHERE `ROOMID` = '$id'";
    mysqli_query($conn, $sqli);
    header("location: index.php");
    // while ($row = mysqli_fetch_assoc($result)) {
    //     echo $row['ROOMID'];
    // }
?>