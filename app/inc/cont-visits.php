<?php
//Form submission

$savedvisitArr = isset($_SESSION['visitformarr']) ? true : false;


if($savedvisitArr){
	include 'inc/mysqlconnect.php';

	$savedvisitArr = $_SESSION['visitformarr'];

foreach ($savedvisitArr as $val){
  if(isset($_POST['savevisit_'.$val])){
    		
		$visitcode = $_POST["visitcode_$val"];
	  $visitstatus = $_POST["status_$val"];
    $assigned = $_POST["assigned_$val"];
		
		$tablename = "savedvisits";
		
		$sql ="UPDATE $tablename
		SET visitstatus = '$visitstatus', assigned = '$assigned'
		WHERE visitcode = '$visitcode'";
		
		$update = mysqli_query($conx, $sql);		
				
		if(!$update){
			die('Error: '.mysqli_error($conx));
		}
		
		if($visitstatus == "completed"){
			
			$shortdate = date('Y-m-d');
			$date_comp = date('Y-m-d H:i:s');
			
			$sql = "INSERT INTO registry 
			(
						date,
						visitcode,
						visitstatus,
						name,
						personalid,
						visitortype,
						fullcompany,
						purpose,
						signature,
						time_in,
						time_out,
						accedoescort
			)
			SELECT 
			'$shortdate', 
			savedvisits.visitcode, 
			visitstatus,
			name,
			personalid,
			visitortype,
			fullcompany,
			message,
			personalid,
			date,
			'$date_comp',
			assigned			
			
			FROM savedvisits, schedvisits
			WHERE	savedvisits.visitcode = '$visitcode'
			AND schedvisits.visitcode = '$visitcode'
			";
			
			$insert = mysqli_query($conx, $sql);
			
			if(!$insert){
				die('Error: '.mysqli_error($conx));
			}
    
			
		}
   
  }
	
}
	mysqli_close($conx);
}

?>
<div class="panel-group" id="accordion"> <?php //Panel group start?>
<?php
	
include 'inc/mysqlconnect.php';
 $tablename = "savedvisits";
 $sql = "SELECT *
				FROM $tablename
				WHERE NOT visitstatus = 'completed'
				AND NOT visitstatus = 'cancelled'
        ORDER BY date ASC";

 $query = mysqli_query($conx, $sql);
	
 if(!$query){
   die ('Error :'.mysqli_error($conx));
 }

$rows = mysqli_num_rows($query);

$i = 0;
$j =1;

$visitsFormArray = array();

 $phpresp = htmlspecialchars($_SERVER["PHP_SELF"])."?cont=1";

if($rows>0){
							
							while($result = mysqli_fetch_assoc($query)){
								echo "<form id=\"panelvisit-".$j."\" method=\"post\" action=\"".$phpresp."\" class=\"panel panel-default\">"; //Form start
																
								echo "<div class=\"panel-heading\">\n"; //Panel heading start
								
								echo "<h4 class=\"panel-title\">\n";
								echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" class=\"block collapsed\" href=\"#";
								echo "formvisit-".$j."\" >";
								
								echo "Solicitada por: ";
                
                $submitter = $result['submitter'];
                $tablename = "authstaff";
                
                $sqluser = "SELECT *
                FROM $tablename
                WHERE username = '$submitter'";
                
                $userquery = mysqli_query($conx, $sqluser);
                
                 if(!$userquery){
                   die ('Error :'.mysqli_error($conx));
                 }
                
                $userResult = mysqli_fetch_assoc($userquery);
                
                echo $userResult['name'];
                echo " de ";
                echo $userResult['fullcompany'];
								
								echo "<span class=\"visit-status\">";
								
								echo "Estado: ";
								echo "<strong>";
								
								$visitcode = $result['visitcode'];
								
							
									echo $result['visitstatus'];									
						
																
								echo "</strong>";
								
								echo "</span>";
								
								echo "<span class=\"pull-right\">";
								echo "<i class=\"fa fa-plus\" aria-hidden=\"true\"></i>";
								echo "<i class=\"fa fa-minus\" aria-hidden=\"true\"></i>";
								echo "</span>";
								echo	"</a>";
								echo "</h4>";        
								echo "</div>\n"; //Panel heading ends
								
								echo "<div id=\"";
								echo "formvisit-".$j."\"";
								echo "class=\"panel-collapse collapse\">\n"; //Collapse starts
								
								echo "<div class=\"panel-body\">";//Panel body starts
																
								echo "<p class=\"text-left\">";
								echo "Fecha y Hora de visita: ";
								$formatdate = date("d-m-Y h:i a", strtotime($result['date']));
								echo "<strong>";
								echo $formatdate;
								echo "</strong>";
								echo "<br />\n";               
								
								echo "<br />\n";
								echo "<h4>Participantes</h4>";
								echo "</p>\n";
															
								
								$message = $result['message'];
								
								$subsql = "SELECT *
						 					FROM schedvisits
											WHERE visitcode = '$visitcode'";
								
								$subquery = mysqli_query($conx, $subsql);
								
								echo "<table class=\"table table-striped\">";
								echo "<thead>";
								echo "<tr>";
								echo "<th>";
								echo "No.";
								echo "</th>";
								echo "<th>";
								echo "Nombres y Apellidos";
								echo "</th>";
								echo "<th>";
								echo "Número de cédula";
								echo "</th>";
								echo "<th>";
								echo "Compañía";
								echo "</th>";
								echo "</tr>\n";
								echo "</thead>\n";
								
								$count = 1;
								while($row = mysqli_fetch_assoc($subquery)){
								 echo "<tr>";
									echo  "<td>";
									echo  $count;
									echo  "</td>";
									echo  "<td>";
									echo $row['name'];
									echo  "</td>";
									echo  "<td>";
									echo  $row['personalid'];
									echo  "</td>";
									echo  "<td>";
									echo  $row['fullcompany'];
									echo  "</td>";
								 echo  "</tr>";
									$count++;
							  }
								echo "</table>";
								
								echo "<p><strong>Motivos de la visita:</strong></p>\n";
								echo "<p class=\"well\">";
								echo $message;
								echo "</p>";
								
								echo "</div>"; //Panel body ends								
								
								echo "<div class=\"panel-footer\">"; //Panel footer starts
										
								echo "<div class=\"pull-left \">"; //Status update box
                echo "<p>";
                echo "Actualice el estado:";
                echo "</p>\n";
                echo "<select name=\"status_".$j."\" required>\n";
								
								
									echo "<option>";
									echo $result['visitstatus'];									
									echo "</option>\n";
								
								
								echo "<option>--Seleccione--</option>\n";
                echo "<option value=\"pending\">pending</option>\n";
                echo "<option value=\"approved\">approved</option>\n";
                echo "<option value=\"completed\">completed</option>\n";
								echo "<option value=\"cancelled\">cancelled</option>\n";
                echo "</select>\n";
                
                echo "</div>"; //Update box ends
                
								echo "<div class=\"pull-left \">"; //Select accompanion
                echo "<p>";
                echo "Asigne el acompañante:";
                echo "</p>\n";
                
                echo "<select id=\"escort\" name=\"assigned_".$j."\" value=\"\" required>\n"; 
                
                $assigned = $result['assigned'];
								
								if (strlen($assigned) > 0){
                  echo "<option>";
                  echo $assigned;
                  echo "</option>\n";
                }
                                
                echo "<option value=\"\">--Seleccione--</option>\n";
																
                $tablename = "accedostaff";       
                $escortSql = "SELECT *
                FROM $tablename
                ORDER BY name ASC";
                
                $escortQuery = mysqli_query($conx, $escortSql);
                
                if(!$escortQuery){
                   die ('Error :'.mysqli_error($conx));
                 }
                
                while($escortResult = mysqli_fetch_assoc($escortQuery)){
                  echo "<option>";
                  echo $escortResult['name'];
                  echo "</option>\n";
                }
                
                echo "</select>\n";
                
                echo "<input type=\"hidden\" name=\"visitcode_".$j."\" value=\"".$visitcode."\"/>";
                
                echo "</div>\n"; //Select companion box ends
                
                echo "<div class=\"pull-right\">";
                echo "<input type=\"submit\" name=\"savevisit_".$j."\" value=\"Guardar\" />";
                echo "</div>\n";
                
                echo "<div class=\"clearer\"></div>\n";
                
								echo "</div>"; //Panel footer ends
								
								echo "</div>"; //Collapse ends								
								echo "</form>";								
                
    $visitsFormArray[$i] = $j;
	  
		$i++;
		$j++;
							}				
	
	mysqli_free_result($query);
							mysqli_free_result($subquery);
              mysqli_free_result($userquery);
              mysqli_free_result($escortQuery);
							mysqli_close($conx);
	
  
						} //Form constructor ends

							
	
	$_SESSION['visitformarr'] = $visitsFormArray;
	
?>
</div>
