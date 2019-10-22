<?php

include 'app/inc/mysqlconnect.php';

// Check if table already exists by querying first entry
$sql = '
 SELECT *
 FROM `accedostaff`
 LIMIT 1';
   
$query = mysqli_query($conx, $sql);

if($query) {
  mysqli_free_result($query);  
  $ready = true;
  mysqli_close($conx);
}
else if (!$query){
  $file = 'app/sql/startup.sql';
  $sql = file_get_contents($file);
  
  $fileQuery = mysqli_query($conx, $sql);
  
  if(!$fileQuery){
    die ('Error :'.mysqli_errno($conx));
  }
  
  mysqli_close($conx);
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title>
      Setup start database setup
    </title>
  </head>
  
  <style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
    
    body {
      font-family: 'Open Sans', sans-serif;
      font-size: 16px;
      line-height: 1.5;
    }
    
    .text-center {
      text-align: center;
    }
    
    .wrapper {
      max-width: 600px;
      padding: 0 15px;
      margin: 60px auto;
    }
  </style>
  
  <body>
     <div class="wrapper">
       <h1 class="text-center">
         Iniciar configuracion de base de datos
       </h1>
       
       <hr />
       
       <div id="result">
         <?php
           if($ready == false) {
             echo "<p>";
             echo "La tablas en la base de datos se iniciaron y configuraron correctamente.";
             echo "</p>\n";
             echo "<p>";
             echo "Puede proceder al <a href=\"index.html\">inicio</a>.";
             echo "</p>\n";
           }
           else if ($ready == true) {
             echo "<p>";
             echo "Las tablas en la base de datos ya estan listas.";
             echo "</p>\n";
             echo "<p>";
             echo "Puede proceder al <a href=\"index.html\">inicio</a>.";
             echo "</p>\n";
           }
         ?>
       </div>
     </div>
  </body>
</html>
