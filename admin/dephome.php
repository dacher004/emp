<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
$empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
$department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
$position = isset($_SESSION['position']) ? $_SESSION['position'] : null;
  
  // Include database file
  include 'connection.php';
  $EmployeeObj = new Employee();
  // Delete record from table
  if(isset($_GET['approveId']) && !empty($_GET['approveId'])) {
      $approveId = $_GET['approveId'];
      $EmployeeObj->approveleave($approveId);
  }
  if(isset($_GET['declineId']) && !empty($_GET['declineId'])) {
    $declineId = $_GET['declineId'];
    $EmployeeObj->declineleave($declineId);
}

     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        
	
		<title>QA</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    <body>
  <header class="main-header">
    <div class="logo">
    <img src="/noneng/admin/images/logo1.png" alt="Logo">
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="dephome.php">Requests</a></li>
        <li><a href="elistdep.php">Account List</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="data">
  <form method="POST" action="qahome.php">
  <li> <label>Employee ID|Department: <strong><?php echo $empid,"|", $position; ?> </strong></label></li>
        
  <h2>Pending request</h2>
    <!-- <button type="submit" name="save">Refresh</button> -->
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
        <th>Department</th>
        <th>action</th>
      </tr>
    </thead>
    <?php 

// Search and display record from table
  $searchResults = array();
   $searchResults = $EmployeeObj->Pendingdep();
    
  foreach ($searchResults as $Employee) {

?>
<tr>
  <td><?php echo $Employee['empid'] ?></td>
  <td><?php echo $Employee['datecreated'] ?></td>
  <td><?php echo $Employee['TOL'] ?></td>
  <td class="text-wrap"><?php echo $Employee['reason'] ?></td>
  <td><?php echo $Employee['datestart'] ?></td>
  <td><?php echo $Employee['dateend'] ?></td>
  <td><?php echo $Employee['department'] ?></td>
  <td>
            <a href="dephome.php?approveId=<?php echo $Employee['ID'] ?>" style="color:green" onclick="return confirm('Are you sure want to decline this request?')"> Approve
              </a>&nbsp
            <a href="dephome.php?declineId=<?php echo $Employee['ID'] ?>" style="color:red" onclick="return confirm('Are you sure want to decline this request?')">
            Decline            </a>
          </td>
 
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
  $searchResults = $EmployeeObj->approveddep();
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
  $searchResults = $EmployeeObj->Declineddep();
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
