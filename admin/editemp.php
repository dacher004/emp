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

  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $Employee = $EmployeeObj->displyaRecordById($editId);
  }
  // Update Record in customer table
  if(isset($_POST['submit'])) {
    $EmployeeObj->editemp($_POST);
  }  
  

     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        
	
		<title>Add Account</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    <body>
  <header class="main-header">
    <div class="logo">
    <img src="/noneng/admin/images/logo1.png" alt="Logo">
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="elist.php">Main Page</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="data">
  <h2>Edit Employee Information</h2>


<form action="editemp.php" method="POST">
<div class="row">
    <div class="column" style="background-color:#bbb;">
      <input name="id" value="<?php echo isset($Employee['ID']) ? $Employee['ID'] : ''; ?>" type = "hidden">
      <label>First name:</label>
      <input type="text" name="fname" value="<?php echo isset($Employee['fname']) ? $Employee['fname'] : ''; ?>">
      <br>
      <label>Last name:</label>
      <input type="text" name="lname" value="<?php echo isset($Employee['lname']) ? $Employee['lname'] : ''; ?>">
      <br>
      <label>Employee ID:</label>
      <input type="text" name="empid" value="<?php echo isset($Employee['empid']) ? $Employee['empid'] : ''; ?>">
      <br>
      <label>Date of Birth:</label>
      <input type="date" name="DOB" value="<?php echo isset($Employee['DOB']) ? $Employee['DOB'] : ''; ?>">
    </div>
    <div class="column" style="background-color:#bbb;">
    <label>Email:</label>
      <input type="text" name="email" value="<?php echo isset($Employee['email']) ? $Employee['email'] : ''; ?>">
      <br>
      <label>Position:</label>
      <select id="position" name="position" >
                 <?php
                  foreach ($positions as $position) {
                    $selected = isset($Employee['position']) && $Employee['position'] === $position ? 'selected' : '';
                    echo '<option value="' . $position . '"' . $selected . '>' . $position . '</option>';
                }
                ?>
                </select>
      <br>
      <label>Department:</label>
      <select id="department" name="department">
                 <?php
                  foreach ($departments as $department) {
                    $selected = isset($Employee['department']) && $Employee['department'] === $department ? 'selected' : '';
                    echo '<option value="' . $department . '"' . $selected . '>' . $department . '</option>';
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
