<?php

  if(isset($_POST['saveaccuser'])){
    
    $pass = $_POST['accedo_pass'];
    $salt = '$6$rounds=5000$'.generateRandomString(8).'$';
    
    $crypted = crypt($pass, $salt);
    
    $name = $_POST['accedo_name'];
    $cedula = $_POST['accedo_id'];
		$email = $_POST['accedo_email'];
    $accedousername = $_POST['accedo_user'];	
    
    $userpass1 = $crypted;
    $userpass2 = $salt;
    
    include 'inc/mysqlconnect.php';
    
    $tablename = "accedostaff";
		
		$sql = "SELECT *
		FROM $tablename
		WHERE username = '$accedousername'";
		
		$query = mysqli_query($conx, $sql);
		
    if(!$query){
			die("Error :".mysqli_error($conx));
		}
		
		$rows = mysqli_num_rows($query); 
		
		if($rows == 0){
			$sql = "INSERT INTO $tablename (
			 name, accemail, cedula, username, userpass1, userpass2, admin
			)
			VALUES(
			 '$name', '$email','$cedula', '$accedousername', '$userpass1', '$userpass2', 1
			)";

			$insert = mysqli_query($conx, $sql);

			if(!$insert){
				die('Error: '.mysqli_error($conx));
			}
		}
    
		mysqli_free_result($query);		
    mysqli_close($conx);					   
  }
?>

<hr />

<form id="control-3" name="addaccuser" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?cont=3" method="post" onsubmit="return validateaccform();">
	<div class="sub-panel">
		<div class="form-group">
			
			<a id="" class="box collapsed" data-toggle="collapse" href="#addaccuser">
			<h4>Añadir usuarios:</h4>      
				<span class="pull-right">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<i class="fa fa-minus" aria-hidden="true"></i>
				</span>
				</a>
      
			<div id="addaccuser" class="collapse box-content">
        <label for="accname"/>Nombre y Apellidos</label><br />
        <input id="accname" type="text" class="form-control" name="accedo_name" value="" required/>
        <label>Cédula de identidad</label><br />
        <input id="accid" type="text" class="form-control" name="accedo_id" value="" required/>
			  <label>Email</label><br />
        <input id="accidemail" type="text" class="form-control" name="accedo_email" value="" required/>			
        <label for="accuser">Nombre usuario</label>
        <input id="accuser" type="text" class="form-control" name="accedo_user" value="" required/>
			  <div id="validateaccuser" class="red-text"></div>			  
        <br />
        <button class="left btn-genpass" id="genpass" type="button">Generar contraseña: </button>
        <input id="accpass" class="pass form-control" type="text" name="accedo_pass" value="" required/>
        <span><small>La contraseña debe ser de al menos 6 caracteres</small></span>
        
        <br /><br />				
				<span class="pull-right"><input id="btn-saveaccuser" type="submit" name="saveaccuser" value="Guardar"/></span>
			<div class="clearer"></div>
			</div>                    
			
	</div>
	</div>
</form>
<br />
<br />

<div class="sub-panel">
		<div class="form-group">
			<h4>
				Usuarios registrados
			</h4>
      
      <?php
      
      $count = 1;
      
			include 'inc/mysqlconnect.php';
          
          $tablename = "accedostaff";
          
          $sql = "SELECT *
          FROM $tablename
          ORDER BY name ASC";
          
          $query = mysqli_query($conx, $sql);                  
          
          if(!$query){
            die('Error: '.mysqli_error($conx));
          }
          
        echo "<table class=\"table table-striped\">";
          echo "<thead>";
          echo "<tr>\n";
          
          echo "<th>";
          echo "Item";
          echo "</th>\n";
          
          echo "<th>";
          echo "Nombres y Apellidos";
          echo "</th>\n";
          
          echo "<th class=\"hidden-xs\">";
          echo "Cédula";
          echo "</th>\n";
			
			    echo "<th class=\"hidden-xs\">";
          echo "Email";
          echo "</th>\n";
          
          echo "<th>";
          echo "Usuario";
          echo "</th>\n";
          
          echo "</tr>\n";
          echo "</thead>";
          
          echo "<tbody>";
            
         while($result = mysqli_fetch_assoc($query)){
            echo "<tr>";
            
            echo "<td>";
            echo $count;
            echo "</td>\n";
            
            echo "<td>";
            echo $result['name'];
            echo "</td>\n";
            
            echo "<td class=\"hidden-xs\">";
            echo $result['cedula'];
            echo "</td>\n";
					 
					  echo "<td class=\"hidden-xs\">";
            echo $result['accemail'];
            echo "</td>\n";
            
            echo "<td>";
					  echo "<form action=".$_SERVER['PHP_SELF']."?cont=3 method=\"post\">";
            echo $result['username'];
					  echo "<input type=\"hidden\" name=\"setaccuserconfig\" value=\"".$result['username']."\"/>";
					  echo "<span class=\"pull-right\">";
					  echo "<button type=\"submit\">";
					  echo "<i class=\"fa fa-wrench\" aria-hidden=\"true\"></i>";
					  echo "</button>";
					  echo "</span>";
					  echo "</form>";
            echo "</td>\n";
            
            echo "</tr>\n";
           
            $count++;
          }
          
          echo "</tbody>\n";
          echo "</table>\n";
          
          mysqli_free_result($query);
          mysqli_close($conx);
      
     
      ?>
		</div>
	</div>

<br /><br />
