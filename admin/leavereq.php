<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
$empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
$department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
 
  // Include database file
  include 'connection.php';
  $EmployeeObj = new Employee();
  $tols = $EmployeeObj->tol();
  // Insert record from table
  if(isset($_POST['submit'])) {
    $EmployeeObj->leavereq($_POST);
  }

     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        
	
		<title>Leave Request</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    <body>
  <header class="main-header">
    <div class="logo">
    <img src="/noneng/admin/images/logo1.png" alt="Logo">
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="othershome.php">Main Page</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="data">
  <form method="POST" action="othershome.php">
  <h2>Leave Request</h2>
</form>


<form action="leavereq.php" method="POST">
<div class="row">
    <div class="column-req" style="background-color:#bbb;">
      <label>Employee ID:</label>
      <input type="text" name="empid" value="<?php echo $empid; ?>" readonly>
      <br>
      <label>Date Created:</label>
      <input type="date" name="datecreated" required="">
      <br>
      <label>Type of Leave:</label>
      <select id="tol" name="tol">
                 <?php
                  foreach ($tols as $tol) {
                    echo '<option value="' . $tol . '">' . $tol . '</option>';
                }
                ?>
                </select>
      <br>
      <label>Date Start:</label>
      <input type="date" name="datestart" required="">
      <br>
      <label>Date End:</label>
      <input type="date" name="dateend" required="">
    </div>
    <div class="column-req" style="background-color:#bbb;">
    <label>Department:</label>
      <input type="text" name="department" value="<?php echo $department; ?>" readonly>
      
      <br>
      <label>Reason:</label>
      <textarea name="reason" rows="4" cols="45"></textarea>
      
         </div>
  
         <input type="submit" name="submit" style="float:right;" value="Submit">
        </div>
        <br>
       
     <br>

  </form>

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
