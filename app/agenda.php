<?php

session_start();

$logged = isset($_SESSION['logged'])?true:false;

if(!$logged){
	header('Location:logout.php');
	exit();
}

$username = $_SESSION['username'];

include 'inc/functions.php';
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Access</title>
    <?php include 'inc/meta.php';?>
  </head>

  <body class="index">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1"><!--main body-->
					
					<div class="row">
						<div class="col-sm-4">
							<div class="logo">
							  <img class="img-responsive" alt="Logo" src="img/company-logo.jpg" />
						  </div>						
						</div>
					</div>
          <h1>
          Agenda de visitas
          </h1>
           
					<div class="row">
						<div class="col-sm-12">
							<p class="text-right">
								<a href="index.php"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
							</p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<?php
							
							 include 'inc/mysqlconnect.php';
							
							  $sql = "SELECT *
						 					FROM savedvisits
											WHERE submitter = '$username'";
						
						$query = mysqli_query($conx, $sql);
						if(!$query){
                  die ('Error :'.mysqli_error($conx));
                }
						
						$rows = mysqli_num_rows($query);
												
						if($rows>0){
							
							while($result = mysqli_fetch_assoc($query)){
								echo "<p class=\"text-left\">";
								echo "Fecha y Hora de visita: ";
								$formatdate = date("d-m-Y h:i a", strtotime($result['date']));
								echo "<strong>";
								echo $formatdate;
								echo "</strong>";
								echo "<br />\n";								
							
								echo "Estado: ";
								echo "<strong>";
								echo $result['visitstatus'];
								echo "</strong>";
								echo "<br />\n";
                echo "</p>\n";
								echo "<h4>Participantes</h4>";								
								
								$visitcode = $result['visitcode'];
								
								$message = $result['message'];
								
								$subsql = "SELECT *
						 					FROM schedvisits
											WHERE visitcode = '$visitcode'";
								
								$subquery = mysqli_query($conx, $subsql);
								
								echo "<table class=\"table table-striped\">\n";
								echo "<thead>\n";
								echo "<tr>\n";
								echo "<th>";
								echo "No.";
								echo "</th>\n";
								echo "<th>";
								echo "Nombres y Apellidos";
								echo "</th>\n";
								echo "<th class=\"hidden-xs\">";
								echo "Número de cédula";
								echo "</th>\n";
								echo "<th class=\"hidden-xs\">";
								echo "Compañía";
								echo "</th\n>";
								echo "</tr>\n";
								echo "</thead>\n";
								
                echo "<tbody>\n";
                
								$i = 1;
								while($row = mysqli_fetch_assoc($subquery)){
								 echo "<tr>";
									echo  "<td>";
									echo  $i;
									echo  "</td>";
									echo  "<td>";
									echo $row['name'];
									echo  "</td>";
									echo  "<td class=\"hidden-xs\">";
									echo  $row['personalid'];
									echo  "</td>";
									echo  "<td class=\"hidden-xs\">";
									echo  $row['fullcompany'];
									echo  "</td>";
								 echo  "</tr>";
									$i++;
							  }
                
                echo "</tbody>\n";
								echo "</table>";
								echo "<p>&nbsp;</p>\n";
								echo "<p><strong>Motivos de la visita:</strong></p>\n";
								echo "<p class=\"well\">";
								echo $message;
								echo "</p>";
							}				
														
						}
							mysqli_free_result($query);
							mysqli_free_result($subquery);
							mysqli_close($conx);
							 
							?>
						</div>
					</div>
					
        </div><!--/main body-->
      </div>
    </div>   

  </body>
  </html>
