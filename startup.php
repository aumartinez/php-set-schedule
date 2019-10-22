<?php

include 'app/inc/mysqlconnect.php';

$file = 'app/sql/startup.sql';
$sql = file_get_contents($file);

//Check if table already exists
$testSql = '
   SELECT 1
   FROM `accedostaff`
   LIMIT 1';
   
$eval = mysqli_query($conx, $testSql);

if ($eval !== false) {
  $ready = false;
  $query = mysqli_multi_query($conx, $sql);
  
  if(!$query) {
    die ('Error :'.mysqli_errno($conx));
  } 
  else {
    do {
      // Store first result set
      if ($result = mysqli_store_result($conx)){
        // Fetch one and one row
        while ($row = mysqli_fetch_row($result)){
          printf("%s\n", $row[0]);
        }
        mysqli_free_result($result);
      }
    }
    while (mysqli_next_result($conx));
  }
  
  mysqli_close($conx);
} 
else {
  $ready = true;
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
             echo "La tablas en la base de datos se configuraron correctamente.";
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
