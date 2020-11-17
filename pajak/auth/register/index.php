<?php
	include('../../api/index.php');
	if(isset($_POST['_register-btn'])){
		$hidden_form	= mysqli_real_escape_string($connect, $_POST['_hidden-form']);
		$csrf_token_id	= mysqli_real_escape_string($connect, $_COOKIE['csrf-token']);
		$csrf_token		= mysqli_real_escape_string($connect, $_POST['_csrf-token']);
		$name 			= mysqli_real_escape_string($connect, $_POST['_name-user']);
		$email			= mysqli_real_escape_string($connect, $_POST['_email-user']);
		$password 		= mysqli_real_escape_string($connect, $_POST['_password-user']);
		$cfpassword		= mysqli_real_escape_string($connect, $_POST['_confirm-password']);
		$errors			= array();
		if(empty($hidden_form)){
			if($csrf_token == $csrf_token_id){
				if(empty($name)){ array_push($errors, "Name Field is Required"); }
				if(empty($email)){ array_push($errors, "Email FIeld is Required"); }
				if(empty($password)){ array_push($errors, "Password Field is Required"); }
				if(empty($cfpassword)){ array_push($errors, "Confirmation Password Field is Required"); }
				if($password != $cfpassword){ array_push($errors, "Make sure Password and Confirm Password are Match"); }
				if(count($errors) == 0){
					if(strlen($name) < 6){ array_push($errors, "Name is too short"); }
					if(strlen($name) > 50){ array_push($errors, "Name is too long"); }
					if(strlen($email) < 10){ array_push($errors, "Email is too short"); }
					if(strlen($email) > 60){ array_push($errors, "Email is too long"); }
					if(strlen($password) < 6){ array_push($errors, "Password is too short"); }
					if(strlen($password) > 50){ array_push($errors, "Password is too long"); }
				}
				if(count($errors) == 0){
					$validation = mysqli_num_rows(mysqli_query($connect, "SELECT email from users WHERE email='$email'"));
					if($validation == 0){
						$password = password_hash($password, PASSWORD_DEFAULT);
						$usr_token = bin2hex(random_bytes(80));
						$unique_token1 = bin2hex(random_bytes(125));
						$unique_token2 = bin2hex(random_bytes(125));
						setcookie('token', $usr_token, time()+(3600*24*3), '/');
						mysqli_query($connect, "INSERT INTO users (username, email, password, unique_id, unique_id2, token) VALUES ('$name', '$email', '$password', '$unique_token1', '$unique_token2', '$usr_token')");
						header('Location: ../../');
					}
					else{
						array_push($errors, "Email Already Exists. Please Choose Another Email");
					}
				}
			}else {
				echo "<script>alert('ERR CODE : 403\\nMESSAGE  : CSRF TOKEN MISMATCH\\nThis may happen when the form you entered doesn\\'t have the same value of CSRF Token. The second reason is the form\\'s token has expired.'); window.location=''</script>";
			}
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Register</title>
		<?php include('../../api/headers.php'); ?>
	</head>
	<body>
		<?php include('../../api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-5">
					<div class="header form-group">
						<h1><b>Register</b></h1>
						<?php if(isset($errors)) include('../../api/errors.php'); ?>
						<form method="POST">
							<input type="text" name="_hidden-form" class="input-hidden">
							<input type="hidden" name="_csrf-token" value="<?php echo $token ?>">
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
							  </div>
							  <input type="text" name="_name-user" class="form-control" placeholder="Full Name" aria-label="Name" aria-describedby="basic-addon1">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
							  </div>
							  <input type="email" name="_email-user" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
							  </div>
							  <input type="password" name="_password-user" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
							  </div>
							  <input type="password" name="_confirm-password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="basic-addon1">
							</div>
							<button type="submit" name="_register-btn" class="btn btn-outline-primary" style="width: 100%;">Register</button>
						</form>
					</div>
				</div>
				<div class="header col-sm-12 col-md-7">
					<h1>
						<b>Why Us</b>
					</h1>
					<h4>
						<div class="adv">
							<div class="adv-desc">
								<i class="fas fa-lock" style="color: #10c242"></i>
							</div>
							<div class="adv-desc">
								Secured with SSL Certificate (HTTPS)
							</div>
						</div>
						<div class="adv">
							<div class="adv-desc">
								<i class="fas fa-lock" style="color: #10c242"></i>
							</div>
							<div class="adv-desc">
								Encrypted With SHA 256 Encryption During Transmission
							</div>
						</div>
						<div class="adv">
							<div class="adv-desc">
								<i class="fas fa-lock" style="color: #10c242"></i>
							</div>
							<div class="adv-desc">
								Data are Hashed before Saved in Database
							</div>
						</div>
					</h4>
				</div>
			</div>
		</div>
	</body>
</html>