<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}


  
  // Include database file
  include 'connection.php';
  $EmployeeObj = new Employee();
  // Delete record from table
//   if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
//       $deleteId = $_GET['deleteId'];
//       $customerObj->deleteRecord($deleteId);
//   }

     


// Get the user ID if logged in
$empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
$department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
</head>
<body>
    <?php if ($department): ?>
        <h1>Welcome to Your Home Page</h1>
        <p>Your user department: <?php echo $department; ?></p>
        
        <!-- Display user-specific data here -->
    <?php else: ?>
        <p>You are not logged in.</p>
    <?php endif; ?>
</body>
</html>
