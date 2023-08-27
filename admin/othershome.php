<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
$department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
$position = isset($_SESSION['position']) ? $_SESSION['position'] : null;

  include 'connection.php';
  $EmployeeObj = new Employee();

  // Delete record from table
//   if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
//       $deleteId = $_GET['deleteId'];
//       $customerObj->deleteRecord($deleteId);
//   }

     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        
	
		<title>Admin</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    <body>
  <header class="main-header">
    <div class="logo">
    <img src="/noneng/admin/images/logo1.png" alt="Logo">
    </div>
    <nav class="main-nav">
      <ul>
      <li> <label>Employee ID: <strong><?php echo $empid; ?> </strong> || Department: <strong><?php echo $position; ?> </strong></label></li>
        <li><a href="leavereq.php">Add Request</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="data">
  <form method="POST" action="othershome.php">
  <h2>Pending Requests</h2>
    <label>Search:</label>&nbsp
    <input type="date" name="search" placeholder="Type here"> &nbsp
    <button type="submit" name="save">Search</button>
</form>
<table class="data-table">
<thead>

      <tr>
        
        <th>Employee ID</th>
        <th>Date Created</th>
        <th>TOL</th>
        <th>Reason</th>
        <th>Date Start</th>
        <th>Date End</th>
      </tr>
    </thead>
    <?php 

// Search and display record from table
  $searchResults = array();
  if (isset($_POST['search'])) {
   $searchfname = $_POST['search'];
   $searchResults = $EmployeeObj->request($searchfname);
  } else {
   $searchResults = $EmployeeObj->request();
    }
  foreach ($searchResults as $Employee) {

?>
<tr>
  <td><?php echo $Employee['empid'] ?></td>
  <td><?php echo $Employee['datecreated'] ?></td>
  <td><?php echo $Employee['TOL'] ?></td>
  <td class="text-wrap"><?php echo $Employee['reason'] ?></td>
  <td><?php echo $Employee['datestart'] ?></td>
  <td><?php echo $Employee['dateend'] ?></td>
  
 
</tr>
<?php } ?>

</table>
  </div>

  <div class="choice">
    <div class="choice1">
    <h2>Approved Requests</h2>
    <table class="data-table">
<thead>

      <tr>
        <th>Date Created</th>
        <th>TOL</th>
        <th>Date Start</th>
        <th>Date End</th>
      </tr>
    </thead>
    <?php 

// Search and display record from table
  $searchResults = array();
   $searchResults = $EmployeeObj->approvedothers();
    
  foreach ($searchResults as $Employee) {

?>
<tr>
  <td><?php echo $Employee['datecreated'] ?></td>
  <td><?php echo $Employee['TOL'] ?></td>
  <td><?php echo $Employee['datestart'] ?></td>
  <td><?php echo $Employee['dateend'] ?></td>
  
 
</tr>
<?php } ?>

</table>
    </div>
    <div class="choice2">
    <h2>Declined Requests</h2>
    <table class="data-table">
<thead>

      <tr>
        <th>Date Created</th>
        <th>TOL</th>
        <th>Date Start</th>
        <th>Date End</th>
      </tr>
    </thead>
    <?php 

// Search and display record from table
  $searchResults = array();
  $searchResults = $EmployeeObj->Declinedothers();
  foreach ($searchResults as $Employee) {

?>
<tr>
  <td><?php echo $Employee['datecreated'] ?></td>
  <td><?php echo $Employee['TOL'] ?></td>
  <td><?php echo $Employee['datestart'] ?></td>
  <td><?php echo $Employee['dateend'] ?></td>
  
 
</tr>
<?php } ?>

</table>
    </div>
  </div>
  <div class="main-footer">

  <div class="footer-social">
        <a href="#"><img src="/noneng/admin/images/facebook-icon.png" alt="Facebook"></a>
        <a href="#"><img src="/noneng/admin/images/twitter-icon.png" alt="Twitter"></a>
        <a href="#"><img src="/noneng/admin/images/instagram-icon.png" alt="Instagram"></a>
        <a href="#"><img src="/noneng/admin/images/linkedin-icon.png" alt="Instagram"></a>
      </div>
    <p>&copy; 2023 Vtime Tech Employee Management System. All rights reserved.</p>
    

</div>
</body>

</html>
