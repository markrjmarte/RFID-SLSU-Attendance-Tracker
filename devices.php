<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Events</title>
    
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/devices.css">
	<link rel="stylesheet" type="text/css" href="css/userslog.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/sidebar.css">
	<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jPushMenu.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/dev_config.js"></script>
    
    <script>
			$(window).on("load resize ", function() {
				var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
				$('.tbl-header').css({'padding-right':scrollWidth});
			}).resize();
		</script>
		<script>
			$(document).ready(function(){
				$.ajax({
					url: "dev_up.php",
					type: 'POST',
					data: {
					'dev_up': 1,
					}
				}).done(function(data) {
					$('#devices').html(data);
				});
				setInterval(function(){
					$.ajax({
						url: "user_log_up.php",
						type: 'POST',
						data: {
							'select_date': 0,
						}
						}).done(function(data) {
						$('#userslog').html(data);
						});
					},5000);
				});
		</script>
	
    
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
                        <a class="navbar-brand" href="login.php"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="bs-example-navbar-collapse-1">

					<ul class="nav navbar-nav">
							<li><a href="index.php">Students</a></li>
							<li><a href="ManageUsers.php">Manage Students</a></li>
							<li><a href="UsersLog.php">Student Logs</a></li>
							<li><a href="devices.php"><span>Events</span></a></li>
							<?php  
								if (isset($_SESSION['Admin-name'])) {
									echo '<li><a href="logout.php">Log Out</a><li>';	
								}
							?>
						</ul>
					</div>
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

			.navbar-default .navbar-nav li a:hover {
				color: white;
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
    
    
    <div class="container">
    	<ul class="breadcrumb">
  			<li><a href="login.php">Home</a> <span class="divider">/</span></li>
  			<li class="active">Event</li>
		</ul>
	</div>
	<body>
		<main>
			<section class="container py-lg-5">
				<div class="alert_dev"></div>
				<!-- devices -->
				<div class="row">
					<div class="col-lg-12 mt-4">
						<div class="panel">
						<div class="panel-heading" style="font-size: 19px;">Events:
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#new-device" style="font-size: 18px; float: right; margin-top: -6px;">New Event</button>
						</div>
						<div class="panel-body">
							<div class="slideInRight animated">
								<div id="devices"></div>
						</div>
						</div>
					</div>
				</div>
				<!-- \\devices -->
				<!-- New Devices -->
				<div class="modal fade" id="new-device" tabindex="-1" role="dialog" aria-labelledby="New Device" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content clearfix">
						<div class="modal-header">
							<h3 class="modal-title" id="exampleModalLongTitle">Add new event:</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="modal-body">
								<label for="User-mail"><b>Venue:</b></label>
								<input type="text" name="dev_name" id="dev_name" placeholder="Device Name..." required/><br>
								<label for="User-mail"><b>Event:</b></label>
								<input type="text" name="dev_dep" id="dev_dep" placeholder="Device Department..." required/><br>
							</div>
							<div class="modal-footer">
								<button type="button" name="dev_add" id="dev_add" class="btn btn-success">Create new event</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</form>
						</div>
					</div>
				</div>
				<!-- //New Devices -->
			</section>
		</main>
	</body>

	<?php include'footer.php'; ?> 
    
    
    <script type="text/javascript">
    
      $(document).ready(function(){
        $('.toggle-menu').jPushMenu({closeOnClickLink: false});
        $('.dropdown-toggle').dropdown();
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
