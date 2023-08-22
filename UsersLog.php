<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
// Add default values for the filters
$_SESSION['searchQuery'] = "1"; // Show all data by default
$_SESSION['defaultFilter'] = true; // Indicate that default filter is applied
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stundent Logs</title>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
    <script src="js/user_log.js"></script>
    
        <script>
          $(window).on("load resize ", function() {
            var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
            $('.tbl-header').css({'padding-right':scrollWidth});
        }).resize();
        </script>
        <script>
          $(document).ready(function(){
            $.ajax({
              url: "user_log_up.php",
              type: 'POST',
              data: {
                  'select_date': 1,
              }
              }).done(function(data) {
                $('#userslog').html(data);
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
      
      <script>
      $(document).ready(function () {
          // Function to load logs based on selected filters
          function loadLogs() {
            var date_sel_start = $("#date_sel_start").val();
            var date_sel_end = $("#date_sel_end").val();
            var time_sel = $(".time_sel:checked").val();
            var time_sel_start = $("#time_sel_start").val();
            var time_sel_end = $("#time_sel_end").val();
            var card_sel = $("#card_sel option:selected").val();
            var dev_uid = $("#dev_sel option:selected").val();

            var select_date = $("#defaultFilter").prop("checked") ? 1 : 0;

            $.ajax({
              url: "user_log_up.php",
              type: "POST",
              data: {
                log_date: 1,
                date_sel_start: date_sel_start,
                date_sel_end: date_sel_end,
                time_sel: time_sel,
                time_sel_start: time_sel_start,
                time_sel_end: time_sel_end,
                card_sel: card_sel,
                dev_uid: dev_uid,
                select_date: select_date,
              },
              success: function (data) {
                $('#userslog').html(data);
              },
            });
          }

          // Filter button click event
          $(document).on("click", "#user_log", function () {
            loadLogs(); // Load logs based on selected filters
            $("#Filter-export").modal("hide");
          });

          // Load default logs on page load
          loadLogs();
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
                        <li><a href="UsersLog.php"><span>Student Logs</span></a></li>
                        <li><a href="devices.php">Events</a></li>
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
        		background: rgb(72, 69, 83, 1) ;
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
  			<li class="active">Student Logs</li>
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
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Filter-export" style="font-size: 18px; float: right; margin-top: -6px;">Log Filter/ Export to Excel</button>
                  </div>
                  <div class="panel-body">
                    <div class="slideInRight animated">
                    <div id="userslog"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade bd-example-modal-lg" id="Filter-export" tabindex="-1" role="dialog" aria-labelledby="Filter/Export" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg animate" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLongTitle">Filter Your Student Log:</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="Export_Excel.php" enctype="multipart/form-data">
                  <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-lg-6 col-sm-6">
                          <div class="panel panel-primary">
                            <div class="panel-heading">Date:</div>
                            <div class="panel-body">
                            <label for="Start-Date"><b>Select from this Date:</b></label>
                            <input type="date" name="date_sel_start" id="date_sel_start">
                            <label for="End -Date"><b>To End of this Date:</b></label>
                            <input type="date" name="date_sel_end" id="date_sel_end">
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                          <div class="panel panel-primary">
                            <div class="panel-heading">Students and Events:</div>
                            <div class="panel-body">
                              <label for="Select-user"><b>Select User:</b></label>
                          <select class="card_sel" name="card_sel" id="card_sel">
                            <option value="0">All Students</option>
                            <?php
                              require'connectDB.php';
                              $sql = "SELECT * FROM users WHERE add_card=1 ORDER BY id ASC";
                              $result = mysqli_stmt_init($conn);
                              if (!mysqli_stmt_prepare($result, $sql)) {
                                  echo '<p class="error">SQL Error</p>';
                              } 
                              else{
                                  mysqli_stmt_execute($result);
                                  $resultl = mysqli_stmt_get_result($result);
                                  while ($row = mysqli_fetch_assoc($resultl)){
                            ?>
                                    <option value="<?php echo $row['card_uid'];?>"><?php echo $row['username']; ?></option>
                            <?php
                                  }
                              }
                            ?>
                          </select><br>
                          <label for="Select-deparment"><b>Select Event</b></label>
                          <select class="dev_sel" name="dev_sel" id="dev_sel">
                            <option value="0">All Events</option>
                            <?php
                              require'connectDB.php';
                              $sql = "SELECT * FROM devices ORDER BY device_dep ASC";
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
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="To_Excel">Export</button>
                    <button type="button" name="user_log" id="user_log" class="btn btn-success">Filter</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <!-- //Log filter -->
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

