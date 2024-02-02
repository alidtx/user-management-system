<?php
session_start();
require('./include/config.php');
class User extends Dbconfig {	
    protected $hostName;
    protected $userName;
    protected $password;
	protected $dbName;
	private $userTable = 'user';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 		
			$database = new dbConfig();            
            $this -> hostName = $database -> serverName;
            $this -> userName = $database -> userName;
            $this -> password = $database ->password;
			$this -> dbName = $database -> dbName;			
            $conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else{
                $this->dbConnect = $conn;
            }
        }
    }
	
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}

	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}	

    public function loginStatus (){
		if(empty($_SESSION["userid"])) {
			header("Location: login.php");
		}
	}	


	public function login(){		
		$errorMessage = '';
		if(!empty($_POST["login"]) && $_POST["loginId"]!=''&& $_POST["loginPass"]!='') {	
			$loginId = $_POST['loginId'];
			$password = $_POST['loginPass'];
			if(isset($_COOKIE["loginPass"]) && $_COOKIE["loginPass"] == $password) {
				$password = $_COOKIE["loginPass"];
			} else {
				$password = md5($password);
			}	
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE email='".$loginId."' AND password='".$password."' AND status = 'active'";
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery);
			$isValidLogin = mysqli_num_rows($resultSet);	

			if($isValidLogin){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["userid"] = $userDetails['id'];
				$_SESSION["name"] = $userDetails['user_name'];
				header("location: index.php"); 		
			} else {		
				$errorMessage = "Invalid login!";		 
			}
		} else if(!empty($_POST["loginId"])){
			$errorMessage = "Enter Both user and password!";	
		}
		return $errorMessage; 		
	}
	public function adminLoginStatus (){
		if(empty($_SESSION["adminUserid"])) {
			header("Location: index.php");
		}
	}		

	
	public function adminLogin(){		
		$errorMessage = '';
		if(!empty($_POST["login"]) && $_POST["email"]!=''&& $_POST["password"]!='') {	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE email='".$email."' AND password='".md5($password)."' AND status = 'active' AND type = 'administrator'";
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery);
			$isValidLogin = mysqli_num_rows($resultSet);	
			if($isValidLogin){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["adminUserid"] = $userDetails['id'];
				$_SESSION["admin"] = $userDetails['user_name'];
				header("location: dashboard.php"); 		
			} else {		
				$errorMessage = "Invalid login!";		 
			}
		} else if(!empty($_POST["login"])){
			$errorMessage = "Enter Both user and password!";	
		}
		return $errorMessage; 		
	}


	public function register(){		
		$message = '';
		if(!empty($_POST["register"]) && $_POST["email"] !='') {
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE email='".$_POST["email"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$isUserExist = mysqli_num_rows($result);
			if($isUserExist) {
				$message = "User already exist with this email address.";
			} else {			
				$insertQuery = "INSERT INTO ".$this->userTable."(user_name,email, password) 
				VALUES ('".$_POST["user_name"]."','".$_POST["email"]."', '".md5($_POST["passwd"])."')";
				$userSaved = mysqli_query($this->dbConnect, $insertQuery);
				if($userSaved) {				
					$message = "Complted.";
				} else {
					$message = "User register request failed.";
				}
			}
		}
		return $message;
	}	



	public function userDetails () {
		$sqlQuery = "SELECT * FROM ".$this->userTable." 
			WHERE id ='".$_SESSION["userid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails;
	}	


	public function editAccount () {
		$message = '';
		$updatePassword = '';
		if(!empty($_POST["passwd"]) && $_POST["passwd"] != '' && $_POST["passwd"] != $_POST["cpasswd"]) {
			$message = "Confirm passwords do not match.";
		} else if(!empty($_POST["passwd"]) && $_POST["passwd"] != '' && $_POST["passwd"] == $_POST["cpasswd"]) {
			$updatePassword = ", password='".md5($_POST["passwd"])."' ";
		}		
		$updateQuery = "UPDATE ".$this->userTable." 
			SET user_name = '".$_POST["user_name"]."',  email = '".$_POST["email"]."' $updatePassword
			WHERE id ='".$_SESSION["userid"]."'";
		$isUpdated = mysqli_query($this->dbConnect, $updateQuery);	
		if($isUpdated) {
			$_SESSION["name"] = $_POST['user_name'];
			$message = "Account details saved.";
		}
		return $message;
	}	

	public function getUserList(){		
		$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE id !='".$_SESSION['adminUserid']."' ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= '(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR designation LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR mobile LIKE "%'.$_POST["search"]["value"].'%") ';			
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		
		$sqlQuery1 = "SELECT * FROM ".$this->userTable." WHERE id !='".$_SESSION['adminUserid']."' ";
		$result1 = mysqli_query($this->dbConnect, $sqlQuery1);
		$numRows = mysqli_num_rows($result1);
		
		$userData = array();	
		while( $users = mysqli_fetch_assoc($result) ) {		
			$userRows = array();
			$status = '';
			if($users['status'] == 'active')	{
				$status = '<span class="label label-success">Active</span>';
			} else if($users['status'] == 'pending') {
				$status = '<span class="label label-warning">Inactive</span>';
			} else if($users['status'] == 'deleted') {
				$status = '<span class="label label-danger">Deleted</span>';
			}
			$userRows[] = $users['id'];
			$userRows[] = ucfirst($users['user_name']);	
			$userRows[] = $users['email'];	
			$userRows[] = $users['type'];
			$userRows[] = $status;						
			$userRows[] = '<button type="button" name="update" id="'.$users["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$userRows[] = '<button type="button" name="delete" id="'.$users["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$userData[] = $userRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$userData
		);
		echo json_encode($output);
	}

	public function deleteUser(){
		if($_POST["userid"]) {
			$sqlUpdate = "
				UPDATE ".$this->userTable." SET status = 'deleted'
				WHERE id = '".$_POST["userid"]."'";		
			mysqli_query($this->dbConnect, $sqlUpdate);		
		}
	}

	public function getUser(){
		$sqlQuery = "
			SELECT * FROM ".$this->userTable." 
			WHERE id = '".$_POST["userid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}

	public function updateUser() {
		if($_POST['userid']) {	
			$updateQuery = "UPDATE ".$this->userTable." 
			SET user_name = '".$_POST["userName"]."', email = '".$_POST["email"]."', status = '".$_POST["status"]."', type = '".$_POST['user_type']."'
			WHERE id ='".$_POST["userid"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}	


	public function adminDetails () {
		$sqlQuery = "SELECT * FROM ".$this->userTable." 
			WHERE id ='".$_SESSION["adminUserid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails;
	}	



	public function addUser () {
		if($_POST["email"]) {
			$insertQuery = "INSERT INTO ".$this->userTable."(user_name, email, password, type, status) 
				VALUES ('".$_POST["userName"]."', '".$_POST["email"]."',  
				'".md5($_POST["password"])."', '".$_POST['user_type']."', 'active')";
			$userSaved = mysqli_query($this->dbConnect, $insertQuery);
		}
	}

}
?>