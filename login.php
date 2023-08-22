
<?php
session_start();
if (isset($_SESSION['Admin-name'])) {
  header("location: index.php");
}

// Array containing restricted pages
$restrictedPages = array("index.php", "services.php", "company.php", "clients.php", "contact.php");

// Check if the user is not logged in and accessing a restricted page
if (!isset($_SESSION['Admin-name']) && in_array(basename($_SERVER['PHP_SELF']), $restrictedPages)) {
  header("location: login.php"); // Redirect to login page
  exit();
}

?>
<!DOCTYPE html>
<html>

<head>

    <title>Sign In</title>
    
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/loginform.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/sidebar.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
	
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jPushMenu.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    
    <script type="text/javascript">
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		})
	</script>
    
</head>
<?php include'header.php'; ?>  
<body>

	<div class="loader"></div>
	
	<style>
	
	.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('images/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
	}
	
	</style>
	
	<header>
	
        <nav class="navbar-default navbar-static-top" id="navbar-default" style="border-radius:0;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle toggle-menu menu-left push-body" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                        <a class="navbar-brand" href=""></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav">
						<li><a href="login.php"><span>Home</span></a></li>
						<li><a href="index.php">Students</a></li>
						<li><a href="ManageUsers.php">Manage Students</a></li>
						<li><a href="UsersLog.php">Students Logs</a></li>
						<li><a href="devices.php">Events</a></li>
						<?php  
							if (isset($_SESSION['Admin-name'])) {
								echo '<li><a href="logout.php">Log Out</a><li>';	
							}
						?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <style>
        
        	.navbar-default {
        		background: rgb(72, 69, 83, 1);
        	}
        
        	.navbar-default .navbar-nav li a {
        		color: #000;
        	}
        	
        	.navbar-default .navbar-toggle .icon-bar {
				background: #000;
			}

			.navbar-nav {
				float: right;
			}
			
			@media screen and (max-width: 768px) {
			.navbar-nav {
				float: left;
			}
			}
			
        
        </style>

        
    </header>
    
    
    <div class="banner">
    	<div class="opacity_overlay">
    		<div class="info">
				<br><br><br><br>
    			<h2>" The usefulness of a METTINGS is</h2>
				<h2>in inverse proportion to the ATTENDANCE. "</h2>
				<hr>
				<h3>Lane Kirkland</h3>
				<br><br><br><br>
    			
    			
    			
    		</div>
    		
    		<div class="secondary_layer">
    			<div class="container">
    				<div class="col-md-8 col-sm-6">
    					<p class="msg">The easiest and quickest way to start your <span>Tracking</span></p>
    					<p class="quote">Start now, Achieve Later</p>
    				</div>
    				<div class="col-md-4 col-sm-6 pull-right">
    					<a href="#myModal" class="btn" data-toggle="modal"><button type="button">Get Started</button></a>
    				</div>
    			</div>
    		</div>
    		
    	</div>
    </div>
    
	<!-- Modal HTML -->
	<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content clearfix">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<div class="modal-body">
					<h3 class="title">Sign In</h3>
					<p class="description">Login here Using Email & Password</p>
					<?php  
						if (isset($_GET['error'])) {
						if ($_GET['error'] == "invalidEmail") {
							echo '<div class="alert alert-danger">
									This E-mail is invalid!!
									</div>';
						}
						elseif ($_GET['error'] == "sqlerror") {
							echo '<div class="alert alert-danger">
									There a database error!!
									</div>';
						}
						elseif ($_GET['error'] == "wrongpassword") {
							echo '<div class="alert alert-danger">
									Wrong password!!
									</div>';
						}
						elseif ($_GET['error'] == "nouser") {
							echo '<div class="alert alert-danger">
									This E-mail does not exist!!
									</div>';
						}
						}
						if (isset($_GET['reset'])) {
						if ($_GET['reset'] == "success") {
							echo '<div class="alert alert-success">
									Check your E-mail!
									</div>';
						}
						}
						if (isset($_GET['account'])) {
						if ($_GET['account'] == "activated") {
							echo '<div class="alert alert-success">
									Please Login
									</div>';
						}
						}
						if (isset($_GET['active'])) {
						if ($_GET['active'] == "success") {
							echo '<div class="alert alert-success">
									The activation like has been sent!
									</div>';
						}
						}
					?>
					<form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<span class="input-icon"><i class="fa fa-user"></i></span>
							<input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
						</div>
						<div class="form-group">
							<span class="input-icon"><i class="fa fa-key" aria-hidden="true"></i></span>
							<input type="password" name="pwd" id="pwd" class="form-control" placeholder="Password" required>
						</div>
						<button type="submit" class="btn" name="login" id="login">Login</button>
						<p style="padding: 1em; color: red;">
							 <a href="#">Reset password</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>  
	
    <div class="services">
    	<div class="container">
    		<h2>EvTRACKER is a <span id="rotate"></span> web application</h2>
    		<h3>Attendance Tracking System using RFID or "EvTRACKER" refers to a system specifically tailored for event administrators to track and manage 
				logs of event activities or transactions using RFID technology. This system could help administrators keep monitor logs, 
				analyze usage patterns, and make informed decisions to enhance event services and efficiency.</h3>
    		
			<div class="overview">
			
				<div class="col-md-4 col-sm-4">
					<div class="feature-box">
						<img src="images/image1.jpg" class="img-responsive">				
					</div>
					
					<div class="feature-body">			
						<h4>Managing Students</h4>
						<p> The capability of the system to handle and control user accounts and related information within the event's database. 
							This feature enables event administrators to perform various actions related to event participant, such as adding, updating, 
							and removing student accounts.</p>
					</div>
				
				</div>
				
				<div class="col-md-4 col-sm-4">
					<div class="feature-box">
						<img src="images/image2.png" class="img-responsive">				
					</div>
					
					<div class="feature-body">			
						<h4>Managing Logs</h4>
						<p>The ability of the system to handle and oversee the logs or records of event activities and transactions. 
							This feature empowers event administrators to monitor and review the log data for various purposes, ensuring efficient 
							event operations and analysis of students behavior. </p>
					</div>
				
				</div>
				
				<div class="col-md-4 col-sm-4">
					<div class="feature-box">
						<img src="images/image3.png" class="img-responsive">				
					</div>
					
					<div class="feature-body">			
						<h4>Manage Events</h4>
						<p>The ability of the system to handle and control the different events or student groups.. 
							This feature empowers event administrators to manage and organize events effectively, 
							facilitating smooth event operations and student engagement</p>
					</div>
				
				</div>

			</div>
    	</div>
    </div>
    
	<div class="subscribe">
		<div class="opacity_overlay">
			<div class="container">
				<h3>Join the Fun!</h3>
				<p>"We do not remember days; We remember moments."</p>
			</div>
		</div>
	</div>
	
	
	<?php include'footer.php'; ?>  
	
    
    
    <script type="text/javascript">
    
      $(document).ready(function(){
        $('.toggle-menu').jPushMenu({closeOnClickLink: false});
        $('.dropdown-toggle').dropdown();
      });
      
    </script>
    
    <script type="text/javascript">
    
    	var terms = ["COMPREHENSIVE", "EFFICIENT", "INNOVATIVE"];

		function rotateTerm() {
  			var ct = $("#rotate").data("term") || 0;
  			$("#rotate").data("term", ct == terms.length -1 ? 0 : ct + 1).text(terms[ct]).fadeIn()
              	.delay(1000).fadeOut(200, rotateTerm);
		}
		$(rotateTerm);

    </script>

    
	<script type="text/javascript">

  	jQuery('.counter-item').appear(function() {
    	jQuery('.counter-number').countTo();
    	jQuery(this).addClass('funcionando');
   	 	console.log('funcionando');
  	});
  
	</script>
	
    <script type="text/javascript">
    
        $(document).ready(function () {
            $("#clients-slider").carousel({
                interval: 5000 //TIME IN MILLI SECONDS
            });
        });
        
    </script>
    
    
    <script type="text/javascript">
    
    $(function () {
  		$.scrollUp({
    		scrollName: 'scrollUp', // Element ID
    		topDistance: '300', // Distance from top before showing element (px)
    		topSpeed: 600, // Speed back to top (ms)
    		animation: 'fade', // Fade, slide, none
    		animationInSpeed: 200, // Animation in speed (ms)
    		animationOutSpeed: 200, // Animation out speed (ms)
    		activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
    		scrollImg: true,
  		});
	});
    </script>

</body>

</html>