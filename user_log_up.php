<?php
function formatTime($time) {
  return date("h:i", strtotime($time));
}  
session_start();
?>

<div class="table-responsive" style="max-height: 500px;"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Id Number</th>
        <th>Card UID</th>
        <th>Events</th>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
      </tr>
    </thead>
    <tbody class="table-secondary">
      <?php

        //Connect to database
        require'connectDB.php';
        $searchQuery = "1";
        $Start_date = " ";
        $End_date = " ";
        $Start_time = " ";
        $End_time = " ";
        $Card_sel = " ";

        // Fetch the searchQuery from session
        if (!isset($_SESSION['searchQuery'])) {
          $_SESSION['searchQuery'] = "1"; // Show all data by default
        }

        if (isset($_POST['log_date'])) {
          //Start date filter
          if ($_POST['date_sel_start'] != "") {
              $Start_date = $_POST['date_sel_start'];
              $_SESSION['searchQuery'] = "checkindate >= '".$Start_date."'";
          }
          //End date filter
          if ($_POST['date_sel_end'] != "") {
              $End_date = $_POST['date_sel_end'];
              $_SESSION['searchQuery'] .= " AND checkindate <= '".$End_date."'";
          }
          
          //Card filter
          if ($_POST['card_sel'] != 0) {
              $Card_sel = $_POST['card_sel'];
              $_SESSION['searchQuery'] .= " AND card_uid='".$Card_sel."'";
          }
          //Department filter
          if ($_POST['dev_uid'] != 0) {
              $dev_uid = $_POST['dev_uid'];
              $_SESSION['searchQuery'] .= " AND device_uid='".$dev_uid."'";
          }
        }
        
        if ($_POST['select_date'] == 1) {
            $Start_date = date("Y-m-d");
            $_SESSION['searchQuery'] = "checkindate='".$Start_date."'";
        }

        // $sql = "SELECT * FROM users_logs WHERE checkindate=? AND pic_date BETWEEN ? AND ? ORDER BY id ASC";
        $sql = "SELECT * FROM users_logs WHERE ".$_SESSION['searchQuery']." ORDER BY id DESC";
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
                  <TD><?php echo $row['id'];?></TD>
                  <TD><?php echo $row['username'];?></TD>
                  <TD><?php echo $row['serialnumber'];?></TD>
                  <TD><?php echo $row['card_uid'];?></TD>
                  <TD><?php echo $row['device_dep'];?></TD>
                  <TD><?php echo $row['checkindate'];?></TD>
                  <TD><?php echo formatTime($row['timein']);?></TD>
                  <TD><?php echo $row['card_out'] == 0 ? "00:00:00" : formatTime($row['timeout']);?></TD>
                  </TR>
      <?php
                }
            }
        }
        // echo $sql;
      ?>
    </tbody>
  </table>
</div>