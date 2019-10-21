<?php

$userErr = false;

$userpass = isset($_POST['accedo_pass'])?trim($_POST['accedo_pass']):false;
$username = isset($_POST['setaccuserconfig'])?trim($_POST['setaccuserconfig']):false;
$name = isset($_POST['userconfig_acccompname'])?trim($_POST['userconfig_acccompname']):false;
$personalid = isset($_POST['userconfig_acccompuserid'])?trim($_POST['userconfig_acccompuserid']):false;
$email = isset($_POST['userconfig_acccompemail'])?trim($_POST['userconfig_acccompemail']):false;

echo $userpass;

if(strlen($userpass) == 0){
  include 'inc/mysqlconnect.php';
  
  $tablename = "accedostaff";
  $sql="SELECT *
  FROM $tablename
  WHERE username = '$username'";
  
  $query = mysqli_query($conx, $sql);
  
   if(!$query){
    die("Error: ".mysqli_error($conx));
  }
  
  $result = mysqli_fetch_assoc($query);
  
  $userpass1 = $result['userpass1'];
  $userpass2 = $result['userpass2'];
  
  mysqli_free_result($query);
  mysqli_close($conx);
}
else{
   $pass = $userpass;
    $salt = '$6$rounds=5000$'.generateRandomString(8).'$';
    
    $crypted = crypt($pass, $salt);
		
    $userpass1 = $crypted;
    $userpass2 = $salt;
}

$savedaccuserconfig = isset($_POST['savedaccuser'])?true:false;

if($savedaccuserconfig){
  include 'inc/mysqlconnect.php';
  
  $tablename = "accedostaff";
  
  $sql="UPDATE $tablename
  SET name = '$name', accemail = '$email', cedula = '$personalid', userpass1 = '$userpass1', userpass2 = '$userpass2'
  WHERE username='$username'";
  
  $update = mysqli_query($conx, $sql);
  
  if(!$update){
    die("Error: ".mysqli_error($conx));
  }
	
	echo "<span class=\"red-text\">Datos guardados</span>";
  
  mysqli_close($conx);
  
}

?>

<p class="pull-right">
  <button>
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?cont=3" target="_self" ><i class="fa fa-times" aria-hidden="true"></i></a>
  </button>  
</p>
<div class="clearer"></div>
<form name="formacccompuser" action="<?php echo $_SERVER['PHP_SELF']; ?>?cont=3" method="post" class="box-content">
  <div class="form-group">
    <?php
  include 'inc/mysqlconnect.php';
  
  $username = isset($_POST['setaccuserconfig'])?$_POST['setaccuserconfig']:false;
    
  $tablename = "accedostaff";
  
  $sql ="SELECT *
  FROM $tablename
  WHERE username ='$username'";
  
  $query = mysqli_query($conx, $sql);
  
  if(!$query){
    die("Error: ".mysqli_error($conx));
  }
    
    $j = 1;
    
    $result = mysqli_fetch_assoc($query);
?>
  <label for="userconfig_accname">Nombres y Apellidos</label>
  <input type="text" id="accuseritem_1" name="userconfig_acccompname" class="form-control" value="<?php echo $result['name'];?>"/>  
  <label for="userconfig_name">Email</label>
  <input type="text" id="accuseritem_1" name="userconfig_acccompemail" class="form-control" value="<?php echo $result['accemail'];?>"/>  
  <label for="userconfig_name">Cedula/ID</label>
  <input type="text" id="accuseritem_2" name="userconfig_acccompuserid" class="form-control" value="<?php echo $result['cedula'];?>"/> 
  <label for="userconfig_name">User name</label>
  <input type="text" id="accuseritem_2" class="form-control" value="<?php echo $result['username'];?>" disabled/>
  <input type="hidden" name="setaccuserconfig" class="form-control" value="<?php echo $result['username'];?>"/>
    <br />
    <button class="left btn-genpass" id="genpass" type="button">Generar nueva contraseña: </button>      
        <input id="accpass" class="pass form-control" type="text" name="accedo_pass" value="">
        <span><small>La contraseña debe ser de al menos 6 caracteres</small></span>
        <br /><br />
         
<?php
  
  mysqli_free_result($query);
  mysqli_close($conx);
?>
  </div>

<div class="pull-right">
<input type="submit" name="savedaccuser" value="Guardar"/>  
  </div>
<div class="clearer"></div>
</form>
<br /><br />
