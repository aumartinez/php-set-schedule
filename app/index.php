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
    <title>Data Center Access</title>
    <?php include 'inc/meta.php';?>
  </head>

  <body class="index">
    <div class="container sec-padding">
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
            DataCenter agenda de visitas
          </h1>
           
					<div class="row">
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
							echo "<div class=\"col-sm-4 pull-right\">";
							echo "<p class=\"text-right\">";
							echo "<a href=\"agenda.php\">";
							echo "Visitas guardadas <strong>";
							echo $rows;
							echo "</strong></a>";
							echo "</p>\n";
							echo "</div>\n";
						}
						
						mysqli_free_result($query);
                                                mysqli_close($conx);
						
						?>
					</div>

          <div class="row">
						
            <div class="col-sm-4 pull-right">
              <p class="text-right">
              Bienvenido, <strong>
                <?php
                
                include 'inc/mysqlconnect.php';
                  
                $sql = "SELECT *
                          FROM authstaff
                          WHERE username = '$username'";
                
                $query = mysqli_query($conx, $sql);
                 
                if(!$query){
                  die ('Error :'.mysqli_error($conx));
                }
                
                $i = 1;
                
                $result = mysqli_fetch_assoc($query);
                
                $compdid = $result['compdid'];
                
                echo $result['name'];                
                
                mysqli_free_result($query);
                mysqli_close($conx);
                
                ?>
                </strong> <a href="logout.php" class="btn btn-default btn-primary">Salir <i class="fa fa-sign-out" aria-hidden="true"></i></a>
              </p>
            </div>
          </div>
          
          <div class="row">
            <form id="main-form" name="main-form" action="thankyou.php" method="post" onsubmit="return validateform(event);">
              <div class="col-sm-8">
                <div class="panel">
                  <h3>
                    Staff de empresa registrada
                  </h3>
                </div>
                
                <div class="sub-panel">
                  
                  <div class="company-data">
                    <h4>
                      <?php
                      include 'inc/mysqlconnect.php';

                      $sql="SELECT fullcompany
                            FROM companies
                            WHERE compdid = '$compdid'";

                      $query = mysqli_query($conx,$sql);
                      
                      if(!$query){
                        die ('Error :'.mysqli_error($conx));
                      }
                      
                      $result = mysqli_fetch_assoc($query);
                      
                      $company = $result['fullcompany'];
                      echo $company;
                      
                      mysqli_free_result($query);
                      mysqli_close($conx);
                      
                      ?>
                    </h4>
                    
                  </div>
                  
                  <div class="staff-list" required>
                    <p>
                      <strong>Seleccione de la lista a la persona que visitará las instalaciones:</strong>
                    </p>
                    <?php
                    
                    $visitcode = $username.generateRandomString(10);
                    
                    echo "<input type=\"hidden\" name=\"visitcode\" value=\"{$visitcode}\" />\n";
                    
                    include 'inc/mysqlconnect.php';

                    $sql="SELECT *
                          FROM authstaff
                          WHERE compdid = '$compdid'";

                    $query = mysqli_query($conx,$sql);

                    echo "<ul class=\"list-unstyled\">\n";
                    while($result = mysqli_fetch_assoc($query)){                      
                      
                      echo "<li class=\"checkbox\">";
											
                      echo "<label for=\"staff-{$i}\">";
                      echo $result['name'];                      
                      echo "<input id=\"staff-{$i}\" type=\"checkbox\" name=\"names[]\" ";
                      echo "onchange=\"thischecked($i);\" ";
                      echo "value=\"{$result['name']}\" />";
											
                      echo "<span class=\"cr\"><i class=\"cr-icon glyphicon glyphicon-ok\"></i></span>";
                      echo "</label>";
                      echo "\n";											
                      echo "<input id=\"company-{$i}\" type=\"checkbox\" class=\"escaped\" name=\"companies[]\" value=\"$company\"/>\n";
		      echo "<input id=\"visitortype-{$i}\" type=\"checkbox\" class=\"escaped\" name=\"visitortype[]\" value=\"auth\"/>\n";
                      echo "<input id=\"auth-{$i}\" type=\"checkbox\" class=\"escaped\" name=\"personalids[]\" value=\"{$result['personalid']}\"/>\n";                
                      echo "</li>"."\n";                      
                      $i++;
                    }
                    
                    echo "</ul>\n";
                    
                    mysqli_free_result($query);
                    mysqli_close($conx);
                    
                    ?>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                
                <div class="panel">
                  <h3>
                    Proposito de la visita
                  </h3>  
                </div>
                
                <div class="sub-panel">
                  <div class="form-group">
                    <label for="comment">Comentarios:</label>
                    <textarea class="form-control" name="message" rows="5" id="comment"required></textarea>
                  </div>
                </div>
                
              </div>

              <div class="col-sm-8">
                <div class="panel">
                  <h3>
                    Acompañantes adicionales
                  </h3>
                </div>
                
                <div class="sub-panel">
                  <div class="form-group">
                    <p>
                      <strong>Añada los datos de los visitantes adicionales:</strong> <a id="add-guest" class="btn"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                    </p>                    
                    <ul id="guest-list" class="list-unstyled from-group">
                    </ul>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-4">
                <div class="panel">
                  <h3>
                    Fecha para visita
                  </h3>
                </div>
                
                <div class="sub-panel">
                  <div class="form-group">
                      <div class="input-group date" id="datetimepicker">
                          <input type="text" class="form-control" name="date" placeholder="Click en el icono..." required />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                    </div>
                    
                  </div>
                
              </div>
              
              <div class="col-sm-12">
                <div class="pull-right">
                  <input type="submit" name="submitForm" class="btn btn-default btn-primary" value="Guardar visita"/>
                  <br />
                  <br />
                </div>
              </div>
            </form>
          </div>
        </div><!--/main body-->
      </div>
    </div>
    
    <script type="text/javascript">
                       $(function () {
                            $('#datetimepicker').datetimepicker({
                              locale: 'es',
                              format: 'DD/MM/YYYY hh:mm a',
															minDate: new Date()
                            });
                        });
                    </script>

    <?php include 'inc/bottomscripts.php'; ?>

  </body>

  </html>
