
<form id="control-5" name="reportform" class="reportpanel" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?cont=5" method="post">

   <div class="sub-panel">
                  <div class="form-group">
                      <div class="input-group date" id="initialdate">
                          <input type="text" class="form-control" name="startdate" placeholder="Inicio - Click en el icono..." required />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                    </div>
  </div>
           
  
   <div class="sub-panel">
                  <div class="form-group">
                      <div class="input-group date" id="lastdate">
                          <input type="text" class="form-control" name="stopdate" placeholder="Hasta - Click en el icono..." required />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                    </div>

            
                  </div>
  
  <div class="pull-right">
    <input type="submit" name="getreport" id="btn-report" value="Guardar"/>
  </div>
  <div class="clearer"></div>
</form>
<br /><br />
<?php

  $getreport = isset($_POST['getreport'])?true:false;

  if($getreport){
    
    $initialdate = $_POST['startdate'];
    $lastdate = $_POST['stopdate'];
         
    //Execute query if post is submitted
    
    include 'inc/mysqlconnect.php';
    
    $tablename = "registry";
    
    $sql="SELECT * 
  FROM $tablename
  WHERE date BETWEEN '$initialdate' AND '$lastdate'
  ORDER BY visitcode DESC";
    
    $query = mysqli_query($conx, $sql);
    
    if(!$query){
      die('Error: '.mysqli_error($conx));
    }
    
    $rows = mysqli_num_rows($query);
    
    $getDateSql = "SELECT * 
  FROM $tablename
  WHERE date BETWEEN '$initialdate' AND '$lastdate'
  ORDER BY visitcode DESC";
    
    $getDateQuery = mysqli_query($conx, $getDateSql);
    
    $getDateResult = mysqli_fetch_assoc($getDateQuery);
    
    if($rows > 0){
      
    echo "<p class=\"visible-xs\">Reporte para el dia: ".$getDateResult['date']."</p>";
    
    echo "<table class=\"table report-table table-striped\">\n";
    echo "<thead class=\"hidden-xs\">\n";
    echo "<tr>";
    
    echo "<th>";
    echo "Fecha";
    echo "</th>";
    
    echo "<th>";
    echo "Nombres y Apellidos";
    echo "</th>\n";
      
    echo "<th>";
    echo "Compañia";
    echo "</th>\n";
    
    echo "<th>";
    echo "Cedula";
    echo "</th>\n";
      
    echo "<th>";
    echo "Entrada";
    echo "</th>\n";
    
    echo "<th>";
    echo "Salida";
    echo "</th>\n";
    
    echo "<th>";
    echo "Acompañante";
    echo "</th>\n";
    
    echo "</tr>\n";
    echo "</thead>\n";
      
    echo "<tbody>\n";
    
    while($result = mysqli_fetch_assoc($query)){
      echo "<tr>\n";
      
      $date = $result['date'];
      $date = date_create($date);
      $date = date_format($date, "d-m-y");
      
      echo "<td><span class=\"visible-xs\"><strong>Fecha: </strong></span>";
      echo $date;
      echo "</td>\n";          
      
      echo "<td><span class=\"visible-xs\"><strong>Nombres: </strong></span>";
      echo $result['name'];
      echo "</td>\n";
      
      echo "<td><span class=\"visible-xs\"><strong>Compañia: </strong></span>";
      echo $result['fullcompany'];
      echo "</td>\n";
      
      echo "<td><span class=\"visible-xs\"><strong>Cedula/ID: </strong></span>";
      echo $result['signature'];
      echo "</td>\n";
      
      $hour_in = $result['time_in'];
      $hour_out = $result['time_out'];
      
      $hour_in = date_create($hour_in);
      $hour_in = date_format($hour_in, "h:m a");
      
      $hour_out = date_create($hour_out);
      $hour_out = date_format($hour_out, "h:m a");
      
      echo "<td><span class=\"visible-xs\"><strong>Entrada: </strong></span>";
      echo $hour_in;
      echo "</td>";
      
      echo "<td><span class=\"visible-xs\"><strong>Salida: </strong></span>";
      echo $hour_out;
      echo "</td>";
      
       echo "<td><span class=\"visible-xs\"><strong>Acompañante: </strong></span>";
      echo $result['accedoescort'];
      echo "</td>";            
      
      echo "</tr>\n";
    }
    
     echo "</tbody>\n";     
    
    echo "</table>\n";
      
    }
    
    else{
      echo "<p>";
      echo "No hay resultados para mostrar";
      echo "</p>\n";
    }
    
    mysqli_free_result($query);
    mysqli_close($conx);
    
  }

?>
  
                  <script type="text/javascript">
                       $(function () {
                            $('#initialdate').datetimepicker({
                              locale: 'es',
                              format: 'YYYY-MM-DD'
                            });
                         
                          $('#lastdate').datetimepicker({
                              locale: 'es',
                              format: 'YYYY-MM-DD'
                            });
                        });
                    </script>
