<?php

session_start();

$logged = isset($_SESSION['loggedstaff']) ? true : false;

if(!$logged){
	header('Location:loggedout.php');
	exit();
}

$username = $_SESSION['username'];

include 'inc/functions.php';
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>DataCenter Access</title>
    <?php include 'inc/meta.php';?>
  </head>

  <body class="index">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1"><!--main body-->
					<div class="row">
						<div class="col-sm-6">
							<img src="img/company-logo.jpg" alt="Logo" class="img-responsive"/>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-6">
							<h1>
						 Panel de control
							</h1>
						</div>
						
						<div class="col-xs-6">
							<p>
						<span class="pull-right">
						<br class="visible-xs" />
						<a href="loggedout.php" class="btn btn-default btn-danger">Salir <i class="fa fa-sign-out" aria-hidden="true"></i></a>
						</span>
					</p>
						</div>
					</div>
					 
					
          <div class="row">
						<div class="col-sm-3"><!--left control-->
							<ul class="nav nav-pills nav-stacked">
								<li class="<?php
													 $phpresp = htmlspecialchars($_SERVER["PHP_SELF"]);
													 
													 if(isset($_GET['cont'])){
														 if($_GET['cont'] == 1){
															 echo "active";
														 }
													 }
													 
													 if(!isset($_GET['cont'])){
														 echo "active";
													 }
													 ?>"><a data-toggle="pill" href="#first-tab">Visitas agendadas</a></li>
								<li class="<?php 
													 if(isset($_GET['cont'])){
														 if($_GET['cont'] == 2){
															 echo "active";
														 }
													 }
													 ?>"><a data-toggle="pill" href="#second-tab">Compañias</a></li>
								<li class="<?php 
													 if(isset($_GET['cont'])){
														 if($_GET['cont'] == 3){
															 echo "active";
														 }
													 }
													 ?>"><a data-toggle="pill" href="#third-tab">Usuarios DataCenter</a></li>
								<li class="<?php 
													 if(isset($_GET['cont'])){
														 if($_GET['cont'] == 4){
															 echo "active";
														 }
													 }
													 ?>
													 "><a data-toggle="pill" href="#fourth-tab">Usuarios Compañias</a></li>
								<li class="<?php 
													 if(isset($_GET['cont'])){
														 if($_GET['cont'] == 5){
															 echo "active";
														 }
													 }
													 ?>"><a data-toggle="pill" href="#fifth-tab">Reportes</a></li>
							</ul>
						</div><!--/left control-->
						
						<div class="col-sm-9"><!--right control-->
							<div class="tab-content">
								<div id="first-tab" class="tab-pane fade 
										<?php 
										if(isset($_GET['cont'])){
											if($_GET['cont'] == 1){
											echo "active in";
											}
										}
										?>">
									<h3>Visitas agendadas</h3>
									
									<hr />
									<?php
										include 'inc/cont-visits.php';
									?>
								</div>
							
								<div id="second-tab" class="tab-pane fade
									 <?php 
										if(isset($_GET['cont'])){
											if($_GET['cont'] == 2){
											echo "active in";
											}
										}
										?>">									
									<h3>Compañias</h3>
									
									<hr />
									<?php
										include 'inc/cont-comp.php';
									?>
								</div>
							
								<div id="third-tab" class="tab-pane fade
									<?php 
										if(isset($_GET['cont'])){
											if($_GET['cont'] == 3){
											echo "active in";
											}
										}
										?>">
									<h3>Usuarios DataCenter</h3>
									<?php
									
									$accuserconfig = isset($_POST['setaccuserconfig'])?true:false;
									$accuserdsaved = isset($_POST['savedaccuser'])?true:false;
									
									if($accuserconfig || $accuserdsaved){
										include 'inc/cont-accuser.php';
									}
									else{
										include 'inc/cont-accedostaff.php';
									}									
										
									?>
								</div>
								
								<div id="fourth-tab" class="tab-pane fade
										<?php 
										if(isset($_GET['cont'])){
											if($_GET['cont'] == 4){
											echo "active in";
											}
										}
										?>">									
																						
									<h3>Usuarios Compañias</h3>
										<?php
									
									$userconfig = isset($_POST['setuserconfig'])?true:false;
									$usersaved = isset($_POST['saveduser'])?true:false;
									
									if($userconfig || $usersaved){
										include 'inc/cont-user.php';
									}
									else{
										include 'inc/cont-compstaff.php';
									}
									
										?>
								</div>
							
								<div id="fifth-tab" class="tab-pane fade
										<?php 
										if(isset($_GET['cont'])){
											if($_GET['cont'] == 5){
											echo "active in";
											}
										}
										?>">
									<h3>Reportes</h3>
									
									<hr />
									
									  <?php
											include 'inc/cont-report.php';
										?>									
								</div>
								
							</div><!--/tab-content-->
					</div><!--/right controls-->
						
					</div><!--/row-->
        </div><!--/main body-->
      </div>
    </div>

    <script src="js/cpanel.js" type="text/javascript"></script>
  </body>

</html>
