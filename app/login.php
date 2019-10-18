<?php

session_start();
header('HTTP/1.0 401 Unauthorized');

include 'inc/functions.php';

$username = 0;
$userpass = 0;

if(isset($_POST['username'])){
  $username = $_POST['username'];
}

if(isset($_POST['userpass'])){
  $userpass = $_POST['userpass']; 
}

if(isset($_POST['userpass'])){
  $originalpass = $_POST['userpass'];
}

if(isset($_POST['submit'])){
  if($username && $userpass){
    include 'inc/mysqlconnect.php';					
    
    $sql =	"SELECT *
    FROM authstaff
    WHERE username = '$username'";
    
    $query = mysqli_query($conx, $sql);
    
    if(!$query){
      die ('Error :'.mysqli_error($conx));
    }
    
    $getSalt = mysqli_fetch_assoc($query);
    $salt = $getSalt['userpass2'];		
    
    $crypted = crypt($userpass, $salt);
    $userpass = $crypted;
    
    mysqli_free_result($query);
    
    $sql =	"SELECT *
    FROM authstaff
    WHERE username = '$username' 
    AND userpass1 = '$userpass'";
    
    $query = mysqli_query($conx, $sql);
    
    if(!$query){
      die ('Error :'.mysqli_error($conx));
    }
    
    $numrows = mysqli_num_rows($query);
    
    mysqli_free_result($query);
    
    if($numrows == 1){
      $_SESSION['logged'] = true;
      $_SESSION['username'] = $username;			
      
      $newsalt = '$6$rounds=5000$'.generateRandomString(8).'$';
      $newcrypted = substr(crypt($originalpass, $newsalt),strlen($newsalt));
      $newpass = $newcrypted;
      
      $sql =	"UPDATE authstaff
      SET userpass1 = '$newpass', userpass2= '$newsalt'
      WHERE username = '$username'";
      
      $update = mysqli_query($conx, $sql);
      
      if(!$update){
        die ('Error :'.mysqli_error($conx));
      }
      
      mysqli_free_result($update);
      mysqli_close($conx);
      
      header('Location:index.php');			
      exit();
    }		
    
    else{
      $_SESSION['logged'] = false;
    }
  }
  
  $_SESSION['logged'] = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Accedo Access</title>
<?php include 'inc/meta.php';?>
</head>
<body class="signin">  
<div class="container">
  <div class="row">
   <div id="body-content" class="col-sm-12">
     <form id="login-form" name="login" class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			
			<h2 class="form-signin-heading">Ingrese</h2>			
			<label class="sr-only">User name</label>
			<input id="input-user" type="text" name="username" class="form-control" placeholder="User name" required autofocus autocomplete="off"/>
			<label class="sr-only">Password</label>
			<input id="input-pass" type="password" name="userpass" class="form-control" placeholder="Password" required autofocus />
			<input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Acceder" />
			
		</form>
		
		<?php      
			
			if(isset($_POST['submit'])){
				if($_SESSION['logged']==false){
					echo "<h3 class=\"red-text\" align=\"center\">";
					echo "Try again";		
					echo "</h3>\n";
				}
			}
		?>
		
    </div>
  </div>
</div>

<?php include 'inc/bottomscripts.php'; ?>

</body>
</html>
