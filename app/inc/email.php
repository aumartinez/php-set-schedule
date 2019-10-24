<?php
$serverUrl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$serverUrl .= $_SERVER['SERVER_NAME'];

$str = $_SERVER['PHP_SELF'];
$arr = explode("/", $str);
$subUrl = array("");

for ($i = 0; $i < count($arr); $i++) {
  array_push($subUrl, $arr[$i]);
  if ($arr[$i] == "app") {
    break;
  }
}

$str = join("/", $subUrl);
$str = substr($str, 1);

$serverUrl .= $str; // Script path
	
$emailbody = '
  <html>
    <head>
      <title>DataCenter Alert</title>
    </head>
    <body>
      <div style="font-family: Arial, sans-serif;margin:60px auto;width:600px">
        <p>
          <img src="'.$serverUrl.'/img/company-logo.jpg" />
        </p>
        <h3>
          Se recibió una nueva solicitud de visita al Data Center
        </h3>
        <hr />
        <div>
          <p>
            Para acceder a la solicitud recibida y aprobarla <a href="'.$serverUrl.'/admin.php">haga click aqui</a>.
          </p>      
        </div>
      </div>
    </body>
  </html>
	';

// Email account to receive alerts

include 'mysqlconnect.php';

$tablename = "accedostaff";
$username = "admin";
$sql="SELECT *
FROM $tablename
WHERE username = '$username'";

$query = mysqli_query($conx, $sql);

if(!$query){
  die("Error: ".mysqli_error($conx));
}

$result = mysqli_fetch_assoc($query);
$regemail = trim($result['accemail']);

mysqli_free_result($query);
mysqli_close($conx);

$to =$regemail; 
$subject = "***Alerta de visita solicitada***";
$txt = $emailbody;
$headers = array("MIME-Version: 1.0",
                 "Content-type:text/html;charset=UTF-8",
                 "From: no-reply@company.com",
                 "Reply-To: no-reply@company.com",
                 "X-Mailer: PHP/".PHP_VERSION);

$headers = implode("\r\n", $headers);
$sendemail = mail($to, $subject, $txt, $headers);
?>
