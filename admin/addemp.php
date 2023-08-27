<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>

<?php
  
  // Include database file
  include 'connection.php';
  $EmployeeObj = new Employee();
  $departments = $EmployeeObj->department();
  $positions = $EmployeeObj->position();
  // Insert record from table
  if(isset($_POST['submit'])) {
    $EmployeeObj->addemp($_POST);
  }

     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        
	
		<title>Add Account</title>
    <script src="filter.js"> </script>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    <body>
  <header class="main-header">
    <div class="logo">
    <img src="/noneng/admin/images/logo1.png" alt="Logo">
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="adminhome.php">Main Page</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="data">
  <form method="POST" action="adminhome.php">
  <h2>Add Employee</h2>
</form>


<form action="addemp.php" method="POST">
<div class="row">
    <div class="column" style="background-color:#bbb;">
      <label>First name:</label></script>
      <input type="text" name="fname" onkeydown="return lettersonly(event)" required="">
      <br>
      <label>Last name:</label>
      <input type="text" name="lname" onkeydown="return lettersonly(event)" required="">
      <br>
      <label>Employee ID:</label>
      <input type="number" name="empid"  required="">
      <br>
      <label>Date of Birth:</label>
      <input type="date" name="DOB" required="">
    </div>
    <div class="column" style="background-color:#bbb;">
    <label>Email:</label>
      <input type="text" name="email" onkeydown="return emailonly(event)" required="">
      <br>
      <label>Position:</label>
      <select id="position" name="position">
                 <?php
                  foreach ($positions as $position) {
                    echo '<option value="' . $position . '">' . $position . '</option>';
                }
                ?>
                </select>
      <br>
      <label>Department:</label>
      <select id="department" name="department">
                 <?php
                  foreach ($departments as $department) {
                    echo '<option value="' . $department . '">' . $department . '</option>';
                }
                ?>
      </select>
<br>
      <label class="label Note"> Note: Password will be the Employee ID. </label>
    </div>
</div>
   
     
    <input type="submit" name="submit" style="float:right;" value="Submit">
    
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
