<?php
session_start();

$logged = isset($_SESSION['loggedstaff'])?true:false;

if(!$logged){
	header('Location:loggedout.php');
	exit();
}

if(isset($_GET['comp'])){
  $compname = $_GET['comp'];
  
  include 'mysqlconnect.php';
  
  $tablename = "companies";
  $sql = "SELECT *
  FROM $tablename
  WHERE fullcompany = '$compname'";
  
  $query = mysqli_query($conx, $sql);
  
  if(!$query){
    die("Error :".mysqli_error($conx));
  }
  
  $rows = mysqli_num_rows($query);  
  
  if($rows == 1){
    $result = mysqli_fetch_assoc($query);
		echo $result['compdid'];
  }
  
	mysqli_free_result($query);
  mysqli_close($conx);
  
}


?>
