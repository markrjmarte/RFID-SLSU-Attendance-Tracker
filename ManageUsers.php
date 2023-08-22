
<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Students</title>

    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/userslog.css">
	<link rel="stylesheet" type="text/css" href="css/manageusers.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/sidebar.css">
	<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jPushMenu.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/manage_users.js"></script>

		<script>
			$(window).on("load resize ", function() {
				var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
				$('.tbl-header').css({'padding-right':scrollWidth});
			}).resize();
		</script>
		<script>
		$(document).ready(function(){
			$.ajax({
				url: "manage_users_up.php"
				}).done(function(data) {
				$('#manage_users').html(data);
			});
			setInterval(function(){
			$.ajax({
				url: "manage_users_up.php"
				}).done(function(data) {
				$('#manage_users').html(data);
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
							<li><a href="ManageUsers.php"><span>Manage Students</span></a></li>
							<li><a href="UsersLog.php">Student Logs</a></li>
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
  			<li class="active">Manage Students</li>
		</ul>
	</div>
	<body>
		<main>
			<section>
						<div class="col-md-4">
							<div class="form-style-5 slideInDown animated">
								<form enctype="multipart/form-data">
									<fieldset>
									<div class="alert_user"></div>
										<legend><span class="number">1</span> Stundent Info</legend>
										<input type="hidden" name="user_id" id="user_id">
										<input type="text" name="name" id="name" placeholder="Student Name...">
										<input type="text" name="number" id="number" placeholder="Id Number...">
										<input type="email" name="email" id="email" placeholder="Student Email...">
									</fieldset>
									<fieldset>
									<legend><span class="number">2</span> Additional Info</legend>
									<label>
										<label for="Device"><b>Join Event:</b></label>
											<select class="dev_sel" name="dev_sel" id="dev_sel" style="color: #000;">
											<option value="0">All Events</option>
											<?php
												require 'connectDB.php';
												$sql = "SELECT * FROM devices ORDER BY device_name ASC";
												$result = mysqli_stmt_init($conn);
												if (!mysqli_stmt_prepare($result, $sql)) {
													echo '<p class="error">SQL Error</p>';
												} 
												else{
													mysqli_stmt_execute($result);
													$resultl = mysqli_stmt_get_result($result);
													while ($row = mysqli_fetch_assoc($resultl)){
											?>
													<option value="<?php echo $row['device_uid'];?>"><?php echo $row['device_dep']; ?></option>
											<?php
													}
												}
											?>
											</select>
										<input type="radio" name="gender" class="gender" value="Female">Female
										<input type="radio" name="gender" class="gender" value="Male" checked="checked">Male
									</label >
									</fieldset>
									<button type="button" name="user_add" class="user_add">Add</button>
									<button type="button" name="user_upd" class="user_upd">Update</button>
									<button type="button" name="user_rmo" class="user_rmo">Remove</button>
								</form>
							</div>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-lg-12 mt-4">
									<div class="panel">
									<div class="panel-heading" style="font-size: 19px;">List:
									</div>
									<div class="panel-body">
										<div class="slideInRight animated">
											<div id="manage_users"></div>
									</div>
									</div>
								</div>
							</div>
						</div>
			</section>
		</main>
	</body>

	<br>
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