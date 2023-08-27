<?php

	class Employee
	{
		private $servername = "localhost";
		private $username   = "root";
		private $password   = "";
		private $database   = "ems";
		public  $con;
		// Database Connection 
		public function __construct()
		{
		    $this->con = new mysqli($this->servername, $this->username,$this->password,$this->database);
		    if(mysqli_connect_error()) {
			 trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
		    }else
            {
			 $this->con;
		    }
		}
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

        //call for login
        public function admin()
		{
		if ( !isset($_POST['empid'], $_POST['password']) ) {
			exit('Please fill both the Employee ID and password fields!');
		}
		$empid = $_POST['empid'];
		$password = $_POST['password'];
        // $selectedDepartment = $_POST['department'];
        $selectedPosition = $_POST['position'];
		
		$query = "SELECT ID,empid,password,department,position FROM list WHERE empid = ?";
		$stmt = $this->con->prepare($query) or die($this->con->error);

		$stmt->bind_param("s", $empid);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows === 1) {
			$row = $result->fetch_assoc();
			$user_id = $row['ID'];
            $empid = $row['empid'];
			$hashed_password = $row['password'];
            $storedDepartment = $row['department'];
            $storedPosition = $row['position'];
		if (password_verify($password, $hashed_password)) {

                if ($selectedPosition === $storedPosition && $selectedPosition === "Admin"){
				
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['empid'] = $empid;
                $_SESSION['position'] = $storedPosition;
                $_SESSION['department'] = $storedDepartment;
				header("Location: adminhome.php");
				exit(); 
            } elseif ($selectedPosition === $storedPosition && $selectedPosition === "QA Lead"){

                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['empid'] = $empid;
                    $_SESSION['position'] = $storedPosition;
                    $_SESSION['department'] = $storedDepartment;
                    header("Location: dephome.php");
                    exit(); 
             } elseif ($selectedPosition === $storedPosition && $selectedPosition === "Frontend Lead"){
				
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['empid'] = $empid;
                    $_SESSION['position'] = $storedPosition;
                    $_SESSION['department'] = $storedDepartment;
                    header("Location: dephome.php");
                    exit(); 
             } elseif ($selectedPosition === $storedPosition && $selectedPosition === "Backend Lead"){
				
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['empid'] = $empid;
                    $_SESSION['position'] = $storedPosition;
                    $_SESSION['department'] = $storedDepartment;
                    header("Location: dephome.php");
                    exit(); 
             } elseif ($selectedPosition === $storedPosition && $selectedPosition === "Staff"){
				
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['empid'] = $empid;
                    $_SESSION['position'] = $storedPosition;
                    $_SESSION['department'] = $storedDepartment;
                    header("Location: othershome.php");
                    exit(); 
            } else {
                echo "Selected department does not match!";
            }
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Incorrect username or password";
    }
		$stmt->close();
		}

// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

 // Call for admin employee search list table
 public function displayData($searchmatch = '') {
    $query = "SELECT * FROM list";
    return $this->displaySearchData($query, $searchmatch);
}

// Call for QA employee search list table
public function displayDatadep($searchmatch = '') {
    $department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
    $query = "SELECT * FROM list WHERE department = '$department'";
    return $this->displaySearchData($query, $searchmatch);
}
        private function displaySearchData($query, $searchmatch) {
            if ($searchmatch != '') {
                $searchmatch = "%{$searchmatch}%";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("s", $searchmatch);
            } else {
                $stmt = $this->con->prepare($query);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            } else {
                echo "No records found.";
                return array();
            }
        }
    
// ----------------------------------------------------------------------       
// ----------------------------------------------------------------------


// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

  //show data to dropdown
  public function department()
  {
      $query = "SHOW COLUMNS FROM list WHERE Field = 'department'";
       return $this->dropdown($query);
  }
          public function position()
  {
      $query = "SHOW COLUMNS FROM list WHERE Field = 'position'";
       return $this->dropdown($query);
  }
          public function tol()
  {
      $query = "SHOW COLUMNS FROM request WHERE Field = 'TOL'";
      return $this->dropdown($query);
  }   
  
  
      private function dropdown($query){
       $stmt = $this->con->prepare($query) or die($this->con->error);
      $stmt->execute();
      $result = $stmt->get_result();
       if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $enumValuesString = $row['Type'];
          $enumValuesString = str_replace("'", "", $enumValuesString); 
          $enumValues = explode(",", substr($enumValuesString, 5, -1));
          
          return $enumValues;
      } else {
          return array();
      }
      }

// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

// add employee
public function addemp()
		{
			$fname = ($_POST['fname']);
			$lname = ($_POST['lname']);
			$empid = ($_POST['empid']);
			$DOB = (($_POST['DOB']));
            $email = (($_POST['email']));
            $position = (($_POST['position']));
            $department = (($_POST['department']));

            $convert = ['cost' => 12];
			$hashpwd = password_hash($empid, PASSWORD_BCRYPT, $convert);
            if ($fname != " " && $lname != " "&& $empid != " " && $DOB != " " && $email != " " && $position != " "&& $department) {
            
			$query="INSERT INTO list(fname,lname,empid,DOB,email,position,department,password) VALUES('$fname','$lname','$empid','$DOB','$email','$position','$department','$hashpwd')";
			$sql = $this->con->query($query);
			if ($sql==true) {
			    header("Location:adminhome.php");
			}else{
			    echo "Registration failed try again!";
			}
        }else{
            echo "Fields can't be blank";
        }
		}
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------
        // send leave request
        public function leavereq()
		{
			$empid = ($_POST['empid']);
			$datecreated = ($_POST['datecreated']);
			$TOL = ($_POST['tol']);
			$datestart = (($_POST['datestart']));
            $dateend = (($_POST['dateend']));
            $department = (($_POST['department']));
            $reason = (($_POST['reason']));
           

			$query="INSERT INTO request(empid,datecreated,TOL,datestart,dateend,reason,department) VALUES('$empid','$datecreated','$TOL','$datestart','$dateend','$reason','$department')";
			$sql = $this->con->query($query);
			if ($sql==true) {
			    header("Location:othershome.php");
			}else{
			    echo "Request failed try again!";
			}
		}
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

 // display all approved request
public function approved()
{
    return $this->getApprovedRequests("SELECT * FROM request WHERE status = 'Approved' ORDER BY datecreated DESC");
}

public function approvedothers()
{
    $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
    return $this->getApprovedRequests("SELECT * FROM request WHERE status = 'Approved' and empid = '$empid' ORDER BY datecreated DESC");
}

public function approveddep()
{
    $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
    $department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
    $position = isset($_SESSION['position']) ? $_SESSION['position'] : null;
    return $this->getApprovedRequests("SELECT * FROM request WHERE status = 'Approved' and department = '$department' ORDER BY datecreated DESC");
}

private function getApprovedRequests($query)
{
    $stmt = $this->con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        echo "No records found.";
        return array();
    }
}

// Display all Declined request

public function Declined()
{
    return $this->getDeclienedRequests("SELECT * FROM request WHERE status = 'Declined' ORDER BY datecreated DESC");
}

public function Declinedothers()
{
    $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
    return $this->getDeclienedRequests("SELECT * FROM request WHERE status = 'Declined' and empid = '$empid' ORDER BY datecreated DESC");
}

public function Declineddep()
{
    $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
    $department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
    $position = isset($_SESSION['position']) ? $_SESSION['position'] : null;
    return $this->getApprovedRequests("SELECT * FROM request WHERE status = 'Declined' and department = '$department' ORDER BY datecreated DESC");
}

private function getDeclienedRequests($query)
{
    $stmt = $this->con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        echo "No records found.";
        return array();
    }
}

    // Pending requests

    public function Pending()
{
    return $this->getPendingRequests("SELECT * FROM request WHERE status = 'Pending' ORDER BY datecreated DESC");
}

public function Pendingothers()
{
    $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
    $department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
    return $this->getPendingRequests("SELECT * FROM request WHERE status = 'Pending' and empid = '$empid' ORDER BY datecreated DESC");
}

public function Pendingdep()
{
    $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
    $department = isset($_SESSION['department']) ? $_SESSION['department'] : null;
    $position = isset($_SESSION['position']) ? $_SESSION['position'] : null;
    return $this->getPendingRequests("SELECT * FROM request WHERE status = 'Pending' and department = '$department' ORDER BY datecreated DESC");
}

private function getPendingRequests($query)
{
    
    $stmt = $this->con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        echo "No records found.";
        return array();
    }
}


      // call for request search list table
      public function request($searchmatch = '')
      {
        $empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;
         if ($searchmatch != '') {
          $searchmatch = "%{$searchmatch}%";
          $query = "SELECT * FROM request WHERE status='Pending' and empid = '$empid' and datecreated LIKE ?";
          $stmt = $this->con->prepare($query);
      $stmt->bind_param("s", $searchmatch);
      } else {
      $query = "SELECT * FROM request WHERE status='Pending' and empid = ? ORDER BY datecreated DESC";
      $stmt = $this->con->prepare($query);
      $stmt->bind_param("i", $empid);
      }
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
      $data = array();
      while ($row = $result->fetch_assoc()) {
          $data[] = $row;
      }
      return $data;
      } else {
      echo "No records found.";
      return array();
      }
  }

// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

    //Approve leave
    public function approveleave()
		{
		    if (isset($_GET['approveId'])) {
                $requestId = $_GET['approveId'];
                $query = "UPDATE request SET status = ? WHERE ID = ?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("si", $newStatus, $requestId);
                $newStatus = 'Approved';
                $stmt->execute();
			
		    }
			
		}

        public function declineleave()
		{
		    if (isset($_GET['declineId'])) {
                $requestId = $_GET['declineId'];
                $query = "UPDATE request SET status = ? WHERE ID = ?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("si", $newStatus, $requestId);
                $newStatus = 'Declined';
                $stmt->execute();
			
		    }
			
		}
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

        //delete employee

        public function deleteemp()
		{
		    if (isset($_GET['deleteId'])) {
                $requestId = $_GET['deleteId'];
                $query = "DELETE FROM list WHERE ID = ?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("s", $requestId);
                $stmt->execute();
			
		    }
			
		}

            //edit employee record
        public function editemp($postData)
		{
            $id = ($_POST['id']);
		    $fnameupdate = ($_POST['fname']);
            $lnameupdate = ($_POST['lname']);
            $empidupdate = ($_POST['empid']);
            $DOBupdate = ($_POST['DOB']);
            $emailupdate = ($_POST['email']);
            $positionupdate = ($_POST['position']);
            $departmentupdate = ($_POST['department']);

            
            $convert = ['cost' => 12];
			$hashpwd = password_hash($empidupdate, PASSWORD_BCRYPT, $convert);
		    
		if (!empty($id) && !empty($postData)) {
			$query = "UPDATE list SET fname = '$fnameupdate', lname = '$lnameupdate', empid = '$empidupdate' , DOB = '$DOBupdate', email = '$emailupdate', position = '$positionupdate', department = '$departmentupdate', password ='$hashpwd' WHERE ID = '$id'";
			$sql = $this->con->query($query);
			if ($sql==true) {
			    header("Location:elist.php");
			}else{
			    echo "Registration updated failed try again!";
			}
		    }
        }

        // to get ID of info table for edit
		public function displyaRecordById($editId)
		{
		    $query = "SELECT * FROM list WHERE ID = '$editId'";
		    $result = $this->con->query($query);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row;
		    }else{
			echo "Record not found";
		    }
		}

    }
    