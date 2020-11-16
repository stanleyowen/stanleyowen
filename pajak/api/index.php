<?php
	//Global Variable
	$URL		= 'http://localhost/pajak';
	$SECRET_KEY = '';

	//Encryption and Decryption
	//Database Connection Configuration
	$database_server	= 'localhost';
	$username_server	= 'root';
	$password_server	= '';
	$databse_name		= 'pajak';
	$connect			= mysqli_connect($database_server, $username_server, $password_server, $databse_name);

	if(mysqli_connect_errno()){
		echo "<script>alert('ERR CODE : 500\\nMESSAGE  : CANNOT CONNECT TO DATABASE SERVER\\nThis may happen when the server encountered an internal error or misconfiguration and was unable to complete your request'); window.location=''</script>";
	}

	//CSRF Token Configuration
	if(empty($_COOKIE['csrf-token'])){
		$token = bin2hex(random_bytes(50));
		setcookie('csrf-token', $token, time()+300, '/');
	}
	if(isset($_COOKIE['csrf-token'])){
		$token = mysqli_real_escape_string($connect, $_COOKIE['csrf-token']);
		return $token;
	}

	//Validation Register Auth
	if(isset($_POST['_register-btn'])){
		$hidden_form	= mysqli_real_escape_string($connect, $_POST['_hidden-form']);
		$csrf_token_id	= mysqli_real_escape_string($connect, $_COOKIE['csrf-token']);
		$csrf_token		= mysqli_real_escape_string($connect, $_POST['_csrf-token']);
		$name 			= mysqli_real_escape_string($connect, $_POST['_name-user']);
		$email			= mysqli_real_escape_string($connect, $_POST['_email-user']);
		$password 		= mysqli_real_escape_string($connect, $_POST['_password-user']);
		$cfpassword		= mysqli_real_escape_string($connect, $_POST['_confirm-password']);
		$error			= array();
		if(empty($hidden_form)){
			if($csrf_token == $csrf_token_id){
				if($password == $cfpassword){
					$validation = mysqli_num_rows(mysqli_query($connect, "SELECT email from user WHERE email='$email'"));
					if($validation == 0){
						$usr_token = bin2hex(random_bytes(80));
						setcookie('token', $usr_token, time()+(3600*24*3), '/');
						mysqli_query($connect, "INSERT INTO users (username, email, password, token) VALUES ($name, $email, $password, $usr_token)");
						header('Location: ../../');
					}
					else{
						array_push($error, "Email Already Exists. Please Choose Another Email");
					}
				}else {
					array_push($error, "Make sure Password and Confirm Password are Match");
				}
			}else {
				array_push($error, "CSRF Token Mismatch");
			}
		}
	}
?>