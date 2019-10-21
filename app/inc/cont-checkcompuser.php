<?php
session_start();

$logged = $_SESSION['loggedstaff'];

if(!$logged){
	header('Location:loggedout.php');
	exit();
}

if(isset($_GET['usr'])){
  $username = $_GET['usr'];
  
  include 'mysqlconnect.php';
  
  $tablename = "authstaff";
  $sql = "SELECT *
  FROM $tablename
  WHERE username = '$username'";
  
  $query = mysqli_query($conx, $sql);
  
  if(!$query){
    die("Error :".mysqli_error($conx));
  }
  
  $rows = mysqli_num_rows($query);  
  
  if($rows == 1){
    echo "El nombre de usuario ya existe, cambielo";
  }
  
	mysqli_free_result($query);
  mysqli_close($conx);
  
}


?>
