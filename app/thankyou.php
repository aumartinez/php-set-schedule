<?php

session_start();

$logged = isset($_SESSION['logged'])?true:false;

if(!$logged){
	header('Location:logout.php');
	exit();
}

$username = $_SESSION['username'];

include 'inc/mysqlconnect.php';

if(isset($_POST['visitcode'])){
  $visitcode = mysqli_real_escape_string($conx, $_POST['visitcode']);
}

if(isset($_POST['names'])){
  $nameArray = $_POST['names'];
  $names = array();
  $i = 0;
  foreach($nameArray as $value){
    $names[$i] = mysqli_real_escape_string($conx, $value);
    $i++;
  }
}

if(isset($_POST['visitortype'])){
  $visitortypeArray = $_POST['visitortype'];
  $visitortype = array();
  $i = 0;
  
  foreach($visitortypeArray as $value){
    $visitortype[$i] = mysqli_real_escape_string($conx, $value);
    $i++;
  }  
}

if(isset($_POST['companies'])){
  $companyArray = $_POST['companies'];
  $companies = array();
  $i = 0;
  
  foreach($companyArray as $value){
    $companies[$i] = mysqli_real_escape_string($conx, $value);
    $i++;
  }  
}

if(isset($_POST['personalids'])){
  $personalidsArray = $_POST['personalids'];
  $personalids = array();
  $i = 0;
  
  foreach($personalidsArray as $value){
    $personalids[$i] = mysqli_real_escape_string($conx, $value);
    $i++;
  }
}

if(isset($_POST['message'])){
  $message = mysqli_real_escape_string($conx, $_POST['message']);
  $message = strip_tags($message);
}

if(isset($_POST['date'])){
  $date = mysqli_real_escape_string($conx, $_POST['date']);
}

mysqli_close($conx);

if(isset($visitcode)){  
  
  include 'inc/mysqlconnect.php';
  
  //STR_TO_DATE('20/10/2014 05:39 PM', '%d/%m/%Y %h:%i %p'))
  
  $sql = "INSERT INTO `savedvisits` 
          (
            date, 
            visitcode, 
            visitstatus, 
            submitter, 
            message, 
            assigned
          )
          VALUES 
          (
            STR_TO_DATE('$date', '%d/%m/%Y %h:%i %p'), 
            '$visitcode', 
            'pending', 
            '$username', 
            '$message', 
            'sin asignar'
          )";
  
  $savevisit = mysqli_query($conx, $sql);
  
  if(!$savevisit){
    die('Error : '.mysqli_error($conx));
  }
  
  $visitcode;
  $names;
  $visitortype;
  $personalids;
  $companies;  
  $i = 0;
  
  $input = array();
  
  foreach((array)$names as $value){
    $input[$i] = array(
      'visitcode' => $visitcode,
      'name' => $value,
      'visitortype' => $visitortype[$i],
      'personalid' => $personalids[$i],
      'company' => $companies[$i]
    );
    $i++;
  }
		
	foreach((array)$input as $key => $keyval){
		
		$visitcode = $input[$key]['visitcode'];
		$name = $input[$key]['name'];
		$visitortype = $input[$key]['visitortype'];
		$personalid = $input[$key]['personalid'];
		$company = $input[$key]['company'];
		
		$sql = "INSERT INTO `schedvisits` 
					(
					 visitcode,
					 name,
					 visitortype,
					 personalid,
					 fullcompany
					)
					VALUES
					(
					 '$visitcode',
					 '$name',
					 '$visitortype',
					 '$personalid',
					 '$company'
					)";
		
		$insert = mysqli_query($conx, $sql);
		if(!$insert){
			die('Error: '.mysqli_errno($conx));
		}
	}
  mysqli_close($conx);
  
	@include 'inc/email.php';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Thank you</title>
    <?php 
    include 'inc/meta.php';   
     
    ?>
  </head>
  <body>
    <div class="container sec-padding">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
            <div class="col-sm-12">
              <h1>
                Su solicitud fue procesada y enviada
              </h1>
              <p>
                Se le redireccionara en <span id="countdown">4</span> segundos, o haga <a href="index.php">click aqui.</a>
              </p>
            </div>            
          </div>
        </div>        
      </div>
    </div>
    
  <script type="text/javascript">
    var seconds;
    var counter;
    var timecount;

    function countdown(){
      seconds = document.getElementById("countdown").innerHTML;
      seconds = parseInt(seconds,10);	

      counter = document.getElementById("countdown");
      timecount = setTimeout(countdown, 1000);
      seconds--;

      if(seconds > 0){
        counter.innerHTML = seconds;
      }
      else{
        counter.innerHTML = 0;
        clearTimeout(timecount);
        redirect();
      }	
    }

    function redirect(){
      document.location.href='index.php';
    }

    countdown();
  </script>

		
  </body>
</html>
