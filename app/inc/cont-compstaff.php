<?php

  if(isset($_POST['savecompuser'])){
    		
		$compdid = trim($_POST['addcomp_compdid']);
		$fullcompany = trim($_POST['addcomp_compname']);
		$name = trim($_POST['addcomp_name']);
								 
		$personalid = trim($_POST['addcomp_userid']);
		$email = trim($_POST['addcomp_email']);
		$signature = trim($_POST['addcomp_user']);
		$compusername = trim($_POST['addcomp_user']);
		$compusername = strtolower($compusername);
		
    $pass = trim($_POST['addcomp_pass']);
    
    $salt = '$6$rounds=5000$'.generateRandomString(8).'$';
    $crypted = substr(crypt($pass, $salt),strlen($salt));
		
    $userpass1 = $crypted;
    $userpass2 = $salt;
    
    include 'inc/mysqlconnect.php';
		
		$tablename = "authstaff";
		
		$sql = "SELECT *
		FROM $tablename
		WHERE username = '$compusername'";
		
		$query = mysqli_query($conx, $sql);
		
		  if(!$query){
				die("Error :".mysqli_error($conx));
			}
		
		$rows = mysqli_num_rows($query); 
		
		if($rows == 0 && strlen($compdid) > 0){
			
				$sql = "INSERT INTO $tablename (
			 compdid, fullcompany, name, authemail, personalid, signature, username, userpass1, userpass2
			)
			VALUES(
			 '$compdid', '$fullcompany', '$name', '$email','$personalid', '$signature', '$compusername', '$userpass1', '$userpass2'
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

<form id="control-4" name="formaddcompuser" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?cont=4" method="post" onsubmit="return validatecompuserform();">
	<div class="sub-panel">
		<div class="form-group">		
      <a id="" class="box collapsed" data-toggle="collapse" href="#addcompuserbox">
			<h4>Añadir usuarios:</h4>      
				<span class="pull-right">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<i class="fa fa-minus" aria-hidden="true"></i>
				</span>
				</a> 
			<div id="addcompuserbox" class="collapse box-content">
				<label for="addcomplist">Nombre de la compañia</label><br />
				<select id="addcomplist" class="form-control" name="addcomp_compname" value="" required>
					<option value="">--Seleccione una opcion--</option>
					<?php
					  include 'inc/mysqlconnect.php';
					  
					$tablename = "companies";
					  $sql = "SELECT *
						FROM $tablename
						ORDER BY fullcompany ASC";
					
					  $query = mysqli_query($conx, $sql);
					if(!$query){
                  die ('Error :'.mysqli_error($conx));
                }
					
					$rows = mysqli_num_rows($query);
					
					if($rows>0){
						while($result = mysqli_fetch_assoc($query)){
							echo "<option value=\"".$result['fullcompany']."\">";
							echo $result['fullcompany'];
							echo "</option>\n";
						}
					}
					
						mysqli_free_result($query);
					  mysqli_close($conx);
					?>
				</select>
				<input id="addcompdid" type="hidden" class="form-control" name="addcomp_compdid" value="" required/>
        <label for="addcompname"/>Nombre y Apellidos</label><br />
        <input id="addcompname" type="text" class="form-control" name="addcomp_name" value="" required/>
        <label>Cédula de identidad</label><br />
        <input id="addcompuserid" type="text" class="form-control" name="addcomp_userid" value="" required/>
			  <label>Email</label><br />
        <input id="addcompuseremail" type="text" class="form-control" name="addcomp_email" maxlength="75" value="" required/>			
        <label for="addcompuser">Nombre usuario</label><br />
        <input id="addcompuser" type="text" class="form-control" name="addcomp_user" value="" required/>
			<div id="validatecompuser" class="red-text"></div>
        <br />        
        <button class="left btn-genpass" id="gencompuserpass" type="button">Generar contraseña: </button>      
        <input id="compuserpass" class="pass form-control" type="text" name="addcomp_pass" value="" required/>
        <span><small>La contraseña debe ser de al menos 6 caracteres</small></span>
        
        <br /><br />				
				<span class="pull-right"><input type="submit" id="btn-savecompuser" name="savecompuser" value="Guardar"/></span>
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
          
          $tablename = "authstaff";
          
          $sql = "SELECT *
          FROM $tablename
          ORDER BY fullcompany ASC, name ASC";
          
          $query = mysqli_query($conx, $sql);                  
          
          if(!$query){
            die('Error: '.mysqli_error($conx));
          }
          
        echo "<table class=\"table table-striped\">";
          echo "<thead>";
          echo "<tr>";
          
          echo "<th>";
          echo "Item";
          echo "</th>\n";
          
          echo "<th>";
          echo "Nombres y Apellidos";
          echo "</th>\n";
          
          echo "<th>";
          echo "Compañia";
          echo "</th>\n";
			
			    echo "<th>";
          echo "Email";
          echo "</th>\n";
          
          echo "<th>";
          echo "Usuario";
          echo "</th>\n";
          
          echo "<tbody>";
            
         while($result = mysqli_fetch_assoc($query)){
           
					 echo "<tr>";
					 
            echo "<td>";
            echo $count;
            echo "</td>\n";
            
            echo "<td>";
            echo $result['name'];
            echo "</td>\n";
            
            echo "<td>";
            echo $result['fullcompany'];
            echo "</td>\n";
					 
					  echo "<td>";
            echo $result['authemail'];
            echo "</td>\n";
            
            echo "<td>";
					  echo "<form action=".$_SERVER['PHP_SELF']."?cont=4 method=\"post\">";
            echo $result['username'];
					  echo "<input type=\"hidden\" name=\"setuserconfig\" value=\"".$result['username']."\"/>";
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
