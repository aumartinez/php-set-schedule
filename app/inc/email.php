<?php
$serverUrl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$serverUrl .= $_SERVER['SERVER_NAME'];
$serverUrl .= "/app/"; // Script path
$serverUrl .= "admin.php"; // Admin login
	
	$emailbody = '
  <html>
    <head>
      <title>DataCenter Alert</title>
    </head>
    <body>
      <div style="font-family: Arial, sans-serif;margin:60px auto;width:600px">
        <p>
          <img src="http://accedo-gps.web44.net/demo/php-webapp-01/app/img/company-logo.jpg" />
        </p>
        <h3>
          Se recibió una nueva solicitud de visita al Data Center
        </h3>
        <hr />
        <div>
          <p>
            Para acceder a la solicitud recibida y aprobarla <a href="'.$serverUrl.'">haga click aqui</a>.
          </p>      
        </div>
      </div>
    </body>
  </html>
	';

// Email account to receive alerts
$regemail = "somebody@company.com";

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
