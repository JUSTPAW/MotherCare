<?php
// Start session and include database connection file
session_start();
include "db_conn.php";

// Validate and sanitize input data
function validate($data){
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

// Check if all required fields are set
if (isset($_POST['uname']) 
    && isset($_POST['password'])
    && isset($_POST['firstname'])
    && isset($_POST['lastname'])
    && isset($_POST['middlename']) 
    && isset($_POST['age'])
    && isset($_POST['address'])
    && isset($_POST['phone'])
    && isset($_POST['email'])
    && isset($_POST['re_password'])) {

    // Get input data and validate/sanitize it
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);
    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $middlename = validate($_POST['middlename']);
    $age = validate($_POST['age']);
    $address = validate($_POST['address']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    // Set up a user_data string for error messages
    $user_data = 'uname='. $uname. '&firstname='. $firstname . '&lastname='. $lastname . '&middlename='. $middlename;

    // Check for missing input data and redirect with error message if necessary
    if(empty($firstname)){
        header("Location: register.php?error=First Name is required&$user_data");
        exit();
    } else if(empty($middlename)){
        header("Location: register.php?error=Midddle Initial is required&$user_data");
        exit();
    } else if(empty($lastname)){
        header("Location: register.php?error=Last Name is required&$user_data");
        exit();
    } else if (empty($uname)) {
        header("Location: register.php?error=User Name is required&$user_data");
        exit();
    } else if(empty($pass)){
        header("Location: register.php?error=Password is required&$user_data");
        exit();
    } else if(empty($re_pass)){
        header("Location: register.php?error=Re Password is required&$user_data");
        exit();
    } else if($pass !== $re_pass){
        header("Location: register.php?error=The confirmation password  does not match&$user_data");
        exit();
    } else if(!preg_match('@[A-Z]@', $pass) || !preg_match('@[a-z]@', $pass) || !preg_match('@[0-9]@', $pass) || !preg_match('@[_\-#]@', $pass) || strlen($pass) < 8) {
        // Check password strength and redirect with error message if necessary
        header("Location: register.php?error=Password should be at least 8 characters in length and should include at least one upper case letter, one number, one special character.&$user_data");
        exit();
    } else {
        // Hash the password and sanitize the remaining input data
        $pass = md5($pass);

		$age = mysqli_real_escape_string($conn, $_POST['age']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$phone = mysqli_real_escape_string($conn, $_POST['phone']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);

	    $sql = "SELECT * FROM users WHERE user_name='$uname' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: register.php?error=The username is taken try another&$user_data");
	        exit();
		}else {
           $sql2 = "INSERT INTO users(firstname,lastname,middlename,user_name,password,age,address,	phone,email) VALUES('$firstname', '$lastname', '$middlename', '$uname', '$pass', '$age', '$address', '$phone', '$email')";
           $result2 = mysqli_query($conn, $sql2);
           if ($result2) {
           	 header("Location: login.php?success=Your account has been created successfully");
	         exit();
           }else {
	           	header("Location: register.php?error=unknown error occurred&$user_data");
		        exit();
           }
		}
	}
	
}else{
	header("Location: register.php");
	exit();
}