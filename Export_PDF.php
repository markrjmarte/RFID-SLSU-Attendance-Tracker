<?php

  session_start();
  if (!isset($_SESSION['Admin-name'])) {
    header("location: login.php");
  }

  // Get the filter values from the URL
  $date_sel_start = $_GET['date_sel_start'];
  $date_sel_end = $_GET['date_sel_end'];
  $time_sel = $_GET['time_sel'];
  $time_sel_start = $_GET['time_sel_start'];
  $time_sel_end = $_GET['time_sel_end'];
  $card_sel = $_GET['card_sel'];
  $dev_uid = $_GET['dev_uid'];
  $select_date = $_GET['select_date']; 

// Connect to the database
require 'connectDB.php';

if (isset($_POST["To_PDF"])) {
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
    // Include the TCPDF library
    require_once('tcpdf/tcpdf.php');

    // Create a new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set the document information
    $pdf->SetCreator('Your Application Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('User Log PDF Export');
    $pdf->SetSubject('User Log Data');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 12);

    // Create the table header
    $pdf->Cell(30, 10, 'ID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Name', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Serial Number', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Card UID', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Section ID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Department', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Date log', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Time In', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Time Out', 1, 1, 'C');

    // Set font size and style for table data
    $pdf->SetFont('helvetica', '', 10);

    // Loop through the database results and add data to the table
    while ($row = $result->fetch_assoc()) {
      $pdf->Cell(30, 10, $row['id'], 1, 0, 'C');
      $pdf->Cell(40, 10, $row['username'], 1, 0, 'C');
      $pdf->Cell(30, 10, $row['serialnumber'], 1, 0, 'C');
      $pdf->Cell(40, 10, $row['card_uid'], 1, 0, 'C');
      $pdf->Cell(30, 10, $row['device_uid'], 1, 0, 'C');
      $pdf->Cell(40, 10, $row['device_dep'], 1, 0, 'C');
      $pdf->Cell(30, 10, $row['checkindate'], 1, 0, 'C');
      $pdf->Cell(30, 10, $row['timein'], 1, 0, 'C');
      $pdf->Cell(30, 10, $row['timeout'], 1, 1, 'C');
    }

    // Output the PDF to the browser for download
    $pdf->Output('User_Log.pdf', 'D');
    exit();
  } else {
    // Redirect to the log page if no data is found
    header("location: UsersLog.php");
    exit();
  }
}
?>
