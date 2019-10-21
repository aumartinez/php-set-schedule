<?php

$userErr = false;

$userpass = isset($_POST['addcomp_pass'])?trim($_POST['addcomp_pass']):false;
$username = isset($_POST['setuserconfig'])?trim($_POST['setuserconfig']):false;
$name = isset($_POST['userconfig_compname'])?trim($_POST['userconfig_compname']):false;
$personalid = isset($_POST['userconfig_compuserid'])?trim($_POST['userconfig_compuserid']):false;
$email = isset($_POST['userconfig_compemail'])?trim($_POST['userconfig_compemail']):false;

if(strlen($userpass) == 0){
  include 'inc/mysqlconnect.php';
  
  $tablename = "authstaff";
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
    $crypted = substr(crypt($pass, $salt),strlen($salt));
		
    $userpass1 = $crypted;
    $userpass2 = $salt;
}

$saveduserconfig = isset($_POST['saveduser'])?true:false;

if($saveduserconfig){
  include 'inc/mysqlconnect.php';
  
  $tablename = "authstaff";
  
  $sql="UPDATE $tablename
  SET name = '$name', personalid = '$personalid', authemail = '$email', userpass1 = '$userpass1', userpass2 = '$userpass2'
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
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?cont=4" target="_self" ><i class="fa fa-times" aria-hidden="true"></i></a>
  </button>  
</p>
<div class="clearer"></div>
<form name="formaddcompuser" action="<?php echo $_SERVER['PHP_SELF']; ?>?cont=4" method="post" class="box-content">
  <div class="form-group">
    <?php
  include 'inc/mysqlconnect.php';
  
  $username = isset($_POST['setuserconfig'])?$_POST['setuserconfig']:false;
    
  
  $tablename = "authstaff";
  
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
  <label for="userconfig_name">Nombres y Apellidos</label>
  <input type="text" id="useritem_1" name="userconfig_compname" class="form-control" value="<?php echo $result['name'];?>"/>  
  <label for="userconfig_name">Compañia</label>
  <input type="text" id="useritem_1" name="userconfig_compfullname" class="form-control" value="<?php echo $result['fullcompany'];?>" disabled/>  
  <label for="userconfig_name">Cedula/ID</label>
  <input type="text" id="useritem_2" name="userconfig_compuserid" class="form-control" value="<?php echo $result['personalid'];?>"/> 
  <label for="userconfig_name">Email</label>
  <input type="text" id="useritem_3" name="userconfig_compemail" class="form-control" value="<?php echo $result['authemail'];?>"/> 
  <label for="userconfig_name">User name</label>
  <input type="text" id="useritem_4" class="form-control" value="<?php echo $result['username'];?>" disabled/>
  <input type="hidden" name="setuserconfig" class="form-control" value="<?php echo $result['username'];?>"/>
    <br />
    <button class="left btn-genpass" id="gencompuserpass" type="button">Generar nueva contraseña: </button>      
        <input id="compuserpass" class="pass form-control" type="text" name="addcomp_pass" value="">
        <span><small>La contraseña debe ser de al menos 6 caracteres</small></span>
        <br /><br />
         
<?php
  
  mysqli_free_result($query);
  mysqli_close($conx);
?>
  </div>

<div class="pull-right">
<input type="submit" name="saveduser" value="Guardar"/>  
  </div>
<div class="clearer"></div>
</form>
<br /><br />
