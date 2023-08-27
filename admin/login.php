
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include 'connection.php';
$EmployeeObj = new Employee();
$positions = $EmployeeObj->position();
  if(isset($_POST['login'])) {
    $EmployeeObj->admin();
  }
?> 

<!DOCTYPE html>
<html>
	<head>
        
	
		<title>Login</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
            <center>
        <div class="logologin">
    <img src="/noneng/admin/images/logo.png" alt="Logo">
    </div>
    </center>
			<h1 class="text-label">Login</h1>
		

				<form action="login.php" method="post" class="login-form">
            <div class="form-row">
                <label for="email">Employee ID:</label>
                <input type="text" name="empid" id="empid" class="underline-input" required>
            </div>
                <br>
            <div class="form-row">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="underline-input"required>
            </div>
                <br>
                <center>
            <div class="form-row">
                <label for="position">Position:</label>
                <select id="position" name="position">
                 <?php
                  foreach ($positions as $position) {
                    echo '<option value="' . $position . '">' . $position . '</option>';
                }
                ?>
                </select>
            </div>
            <br>
                
				<button type="submit" name="login"> Submit </button>
                </center>
            </form>
			
			
		</div>
		
	</body>
</html>