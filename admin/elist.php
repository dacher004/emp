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
  // Delete record from employee
  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    $EmployeeObj->deleteemp($deleteId);
  }

     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        
	
		<title>Employee list</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    <body>
  <header class="main-header">
    <div class="logo">
    <img src="/noneng/admin/images/logo1.png" alt="Logo">
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="adminhome.php">Home</a></li>
        <li><a href="addemp.php">Add Account</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="data">
  <form method="POST" action="elist.php">
    <label>Search:</label>&nbsp
    <input type="text" name="search" placeholder="Type here"> &nbsp
    <button type="submit" name="save">Search</button>
</form>
<table class="data-table">
<thead>

      <tr>
        
        <th>First name</th>
        <th>Last name</th>
        <th>Employee ID</th>
        <th>Date of birth</th>
        <th>Email</th>
        <th>Position</th>
        <th>Department</th>
        <th>Action</th>
      </tr>
    </thead>
    <?php 

// Search and display record from table
  $searchResults = array();
  if (isset($_POST['search'])) {
   $searchfname = $_POST['search'];
   $searchResults = $EmployeeObj->displayData($searchfname);
  } else {
   $searchResults = $EmployeeObj->displayData();
    }
  foreach ($searchResults as $Employee) {

?>
<tr>
 
  <td><?php echo $Employee['fname'] ?></td>
  <td><?php echo $Employee['lname'] ?></td>
  <td><?php echo $Employee['empid'] ?></td>
  <td><?php echo $Employee['DOB'] ?></td>
  <td><?php echo $Employee['email'] ?></td>
  <td><?php echo $Employee['position'] ?></td>
  <td><?php echo $Employee['department'] ?></td>
  <td>
    <a href="editemp.php?editId=<?php echo $Employee['ID'] ?>" style="color:green"> Edit
      </a>&nbsp
    <a href="elist.php?deleteId=<?php echo $Employee['ID'] ?>" style="color:red" onclick="return confirm('Are you sure want to delete this record')">
    Delete            </a>
  </td>
</tr>
<?php } ?>

</table>
  </div>

  <div class="choice">
    <div class="choice1">
    <h2>Data Container2.1</h2>
    <p>This is the data container where you can display your data.</p>
    </div>
    <div class="choice2">
    <h2>Data Container2.2</h2>
    <p>This is the data container where you can display your data.</p>
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
