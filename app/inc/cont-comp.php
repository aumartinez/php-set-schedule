<?php //Submitted new company form

$savecompany = isset($_POST['savecomp']) ? true:false;

if($savecompany){
	
	include 'inc/mysqlconnect.php';
	
	$tablename = "companies";
	$fullcompany = $_POST['company'];
	$compdid = $_POST['compdid'];
	
	$sql = "SELECT *
	FROM $tablename
	WHERE compdid = '$compdid'";
		
	$query = mysqli_query($conx, $sql);
	
		 if(!$query){
	  die('Error: '.mysqli_error($conx));
   }
	
	$rows = mysqli_num_rows($query);
	
	if($rows == 0){
		$sql = "INSERT INTO $tablename (compdid, fullcompany)
	        VALUES ('$compdid', '$fullcompany')";
	
	$insertComp = mysqli_query($conx, $sql);
	
	 if(!$insertComp){
	  die('Error: '.mysqli_error($conx));
   }
	}
	
	mysqli_free_result($query);
   mysqli_close($conx);		
	
}
?>

<form id="control-2" name="addcomp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?cont=2" method="post">
	<div class="sub-panel">
		<div class="form-group">		
			
				<a id="" class="box collapsed" data-toggle="collapse" href="#addcomp">
					<h4>Añadir compañias:</h4>
				<span class="pull-right">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<i class="fa fa-minus" aria-hidden="true"></i>
				</span>
				</a>
			
			<div id="addcomp" class="collapse box-content">
				<input id="company" type="text" name="company" class="form-control" placeholder="Nombre de la compañía" required>
				<span class="pull-right"><input type="submit" name="savecomp" value="Guardar"/></span>
				<div class="clearer"></div>
			</div>			
		  <input id="compdid" type="hidden" name="compdid" />
			<div class="clearer"></div>
	</div>
	</div>
</form>

<div class="sub-panel">
		<div class="form-group">
			<h4>
				Listado de compañias
			</h4>
		</div>
	</div>

<?php

include 'inc/mysqlconnect.php';

$tablename = "companies";

 $sql = "SELECT *
 				FROM $tablename";
 
 $query = mysqli_query($conx, $sql);
 
 $i = 1;
 $j = 0;

 $formArray = array();
 $phpresp = htmlspecialchars($_SERVER["PHP_SELF"]);

	while($row = mysqli_fetch_assoc($query)){
		
		echo "<form id=\"formcomp-".$i."\" method=\"post\" action=\"".$phpresp."\">";
		echo "<div class=\"form-group\">";
		echo "<div class=\"panel-group\">";
		echo "<div class=\"panel panel-default\">";
		echo "<div class=\"panel-heading\">\n";
		echo "<h4 class=\"panel-title\">\n";
    echo "<a data-toggle=\"collapse\" class=\"block collapsed\" href=\"#";
		echo "compdid-".$i."\">";
		echo $row['fullcompany'];
		echo "<span class=\"pull-right\">";
		echo "<i class=\"fa fa-plus\" aria-hidden=\"true\"></i>";
		echo "<i class=\"fa fa-minus\" aria-hidden=\"true\"></i>";
		echo "</span>";
		echo	"</a>";
		echo "</h4>";        
    echo "</div>\n";
		
		echo "<div id=\"";
		echo "compdid-".$i;
		echo "\" class=\"panel-collapse collapse\">\n";
		
		
		
		$tablename = "authstaff";
		$compdid = $row['compdid'];
		
		$subsql = "SELECT *
							FROM $tablename
							WHERE compdid = '$compdid'";
		
		$subquery = mysqli_query($conx, $subsql);
		
		if(!$subquery){
			die("Error:".mysqli_error($conx));
		}
		
		echo "<table class=\"table\">\n";
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th>Nombres</th>\n";
		echo "<th>Cedula</th>\n";
		echo "<th>Username</th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		
		$numrows = mysqli_num_rows($subquery);
			
		if($numrows > 0){
		
		while($subrow = mysqli_fetch_assoc($subquery)){			
			echo "<tr class=\"\">";
			
			echo "<td>";
			echo "<input type=\"text\"";
			echo " name =\"";
			echo "names[]";
			echo "\"";
			echo "class=\"form-control\" value=\"";
			echo $subrow['name'];
			echo "\"/>\n";
			echo "</td>\n";
			
			echo "<td>";
			echo "<input type=\"text\"";
			echo " name =\"";
			echo "personalids[]";
			echo "\"";
			echo "class=\"form-control\" value=\"";
			echo $subrow['personalid'];
			echo "\"/>\n";
			echo "</td>\n";
			
			echo "<td>";
			echo "<input type=\"text\"";
			echo " name =\"";
			echo "usernames[]";
			echo "\"";
			echo "class=\"form-control\" value=\"";
			echo $subrow['username'];
			echo "\"/>";
			echo "</td>\n";
						
			echo "</tr>\n";
		}
			
		}
		
		echo "</tbody>";
		echo "</table>";
		echo "<div class=\"panel-footer\">";
		
		//Saving form button
		
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</form>";
		
		$formArray[$j] = $i;
		$i++;
		$j++;
	}

 if(!$query){
	 die('Error: '.mysqli_error($conx));
 }

 mysqli_free_result($query);
 mysqli_close($conx);

?>
<br />
<br />
