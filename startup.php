<?php

include 'app/inc/mysqlconnect.php';

// Check if table already exists by querying first entry
$sql = '
 SELECT *
 FROM accedostaff
 LIMIT 1';
   
$query = mysqli_query($conx, $sql);

if($query) {
  //If table exists do nothing
  mysqli_free_result($query);  
  $ready = true;
  mysqli_close($conx);
}
else if (!$query){
  //If table don't exists run setup query  
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
    
    .progress-bar {
      width: 100%;
      height: 30px;
      -webkit-animation: scale-width 2.5s ease;
      animation: scale-width 2.5s ease;
      overflow: hidden;
    }
    
    .progress-bar span {
      background-image: -o-linear-gradient(45deg, #4f2671 20%, #daabf7 20%, #daabf7 40%, #4f2671 40%, #4f2671 60%, #daabf7 60%,  #daabf7 80%, #4f2671 80%, #4f2671 100%);
      background-image: linear-gradient(45deg, #4f2671 20%, #daabf7 20%, #daabf7 40%, #4f2671 40%, #4f2671 60%, #daabf7 60%,  #daabf7 80%, #4f2671 80%, #4f2671 100%);
      display: block;
      width: 600px;
      height: 30px;  
    }
    
    @-webkit-keyframes scale-width {
      0%{
       width: 0%;
      }
      100%{
       width: 100%;
      }
    }
    
    @keyframes scale-width {
      0%{
        width: 0%;
      }
      100%{
        width: 100%;
      }
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
             echo "<div class=\"progress-bar\">\n";
             echo "<span>\n";
             echo "</span>\n";
             echo "</div>\n";
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
