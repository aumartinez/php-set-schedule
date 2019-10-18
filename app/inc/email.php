<?php

$serverUrl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$serverUrl .= $_SERVER['SERVER_NAME'];
$serverUrl .= "/app/admin.php";
	
	$emailbody = '
	<div>
	<h3>Se envio una nueva solicitud de visita al Data Center</h3>
	<div>
	 <p>Para acceder a la solicitud recibida y aprobarla <a href="'.$serverUrl.'">haga click aqui</a>.</p>
	 <br /><br /><br />
	</div>
	</div>';

$regemail = "";

$to =$regemail; //Email account to receive alerts
$subject = "***Alerta de visita solicitada***";
$txt = $emailbody;
$headers = array("From: no-reply@company.com",
                 "Reply-To: no-reply@company.com",
                 "X-Mailer: PHP/".PHP_VERSION);

$headers = implode("\r\n", $headers);
$sendemail = mail($to, $subject, $txt, $headers);
?>
