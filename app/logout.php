<?php
//Here clear current credentials and authorization
session_start();

//Clear authorization
unset($_SERVER['PHP_AUTH_USER']);
unset($_SERVER['PHP_AUTH_PW']);

//Clear any session variable
session_unset();

//Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Exit page</title>
<?php include 'inc/meta.php'; ?>
</head>
<body>
  <div id="body-content" class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1>Ha sido deslogueado</h1>
        <p>Se le redireccionara en <span id="countdown">4</span> segundos, o haga <a href="login.php">click aqui</a></p>
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
        redirect();
      }	
    }

    function redirect(){
      location.href='login.php';
    }

    countdown();
  </script>  

</body>
</html>
