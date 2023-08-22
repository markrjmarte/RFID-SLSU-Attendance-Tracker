
<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Students</title>

    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/userslog.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/sidebar.css">
	<link rel="icon" type="image/png" href="images/favicon.png">
	<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jPushMenu.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
		
		
		<script>
		$(window).on("load resize ", function() {
			var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
			$('.tbl-header').css({'padding-right':scrollWidth});
		}).resize();
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
							<li><a href="index.php"><span>Students</span></a></li>
							<li><a href="ManageUsers.php">Manage Students</a></li>
							<li><a href="UsersLog.php">User Logs</a></li>
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
  			<li class="active">Students</li>
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
							<div class="panel-heading" style="font-size: 19px;">List:
						</div>
						<div class="panel-body">
							<div class="slideInRight animated">
							<div class="table-responsive slideInRight animated" style="max-height: 400px;"> 
							<table class="table">
								<thead class="table-primary">
									<tr>
									<th>ID | Name</th>
									<th>Id number</th>
									<th>Gender</th>
									<th>Card UID</th>
									<th>Date</th>
									<th>Event</th>
									</tr>
								</thead>
								<tbody class="table-secondary">
									<?php
									//Connect to database
									require'connectDB.php';

										$sql = "SELECT * FROM users WHERE add_card=1 ORDER BY id DESC";
										$result = mysqli_stmt_init($conn);
										if (!mysqli_stmt_prepare($result, $sql)) {
											echo '<p class="error">SQL Error</p>';
										}
										else{
											mysqli_stmt_execute($result);
											$resultl = mysqli_stmt_get_result($result);
										if (mysqli_num_rows($resultl) > 0){
											while ($row = mysqli_fetch_assoc($resultl)){
									?>
												<TR>
												<TD><?php echo $row['id']; echo" | "; echo $row['username'];?></TD>
												<TD><?php echo $row['serialnumber'];?></TD>
												<TD><?php echo $row['gender'];?></TD>
												<TD><?php echo $row['card_uid'];?></TD>
												<TD><?php echo $row['user_date'];?></TD>
												<TD><?php echo $row['device_dep'];?></TD>
												</TR>
									<?php
											}   
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
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










































