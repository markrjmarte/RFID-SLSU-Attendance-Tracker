<?php
// Connect to the database
require 'connectDB.php';

$output = '';

if (isset($_POST["To_Excel"])) {
  $searchQuery = "1"; // Default search query to show all data
  $Start_date = $_POST['date_sel_start'];
  $End_date = $_POST['date_sel_end'];
  $card_sel = $_POST['card_sel'];
  $dev_uid = $_POST['dev_sel'];

  // Apply date range filter
  if (!empty($Start_date) && !empty($End_date)) {
    $searchQuery .= " AND checkindate BETWEEN '$Start_date' AND '$End_date'";
  } elseif (!empty($Start_date)) {
    $searchQuery .= " AND checkindate='$Start_date'";
  }

  // Apply card filter
  if ($card_sel != "0") {
    $searchQuery .= " AND card_uid='$card_sel'";
  }

  // Apply department filter
  if ($dev_uid != "0") {
    $searchQuery .= " AND device_uid='$dev_uid'";
  }

  $sql = "SELECT * FROM users_logs WHERE $searchQuery ORDER BY id DESC";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
    $output .= '
      <table class="table" bordered="1">  
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Id number</th>
          <th>Card UID</th>
          <th>Section ID</th>
          <th>Events</th>
          <th>Date log</th>
          <th>Time In</th>
          <th>Time Out</th>
        </tr>';

    while ($row = $result->fetch_assoc()) {
      $output .= '
        <tr> 
          <td>' . $row['id'] . '</td>
          <td>' . $row['username'] . '</td>
          <td>' . $row['serialnumber'] . '</td>
          <td>' . $row['card_uid'] . '</td>
          <td>' . $row['device_uid'] . '</td>
          <td>' . $row['device_dep'] . '</td>
          <td>' . $row['checkindate'] . '</td>
          <td>' . $row['timein'] . '</td>
          <td>' . $row['timeout'] . '</td>
        </tr>';
    }
    $output .= '</table>';

    // Set appropriate content type for Excel download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=User_Log.xls');
    echo $output;
    exit();
  } else {
    // Redirect to the log page if no data is found
    header("location: UsersLog.php");
    exit();
  }
}
?>
