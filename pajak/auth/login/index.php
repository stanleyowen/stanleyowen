<?php
	include('../../api/index.php');
	if(isset($_POST['_login-btn'])){
		$hidden_form	= mysqli_real_escape_string($connect, $_POST['_hidden-form']);
		$csrf_token_id	= mysqli_real_escape_string($connect, $_COOKIE['csrf-token']);
		$csrf_token		= mysqli_real_escape_string($connect, $_POST['_csrf-token']);
		$email			= mysqli_real_escape_string($connect, $_POST['_email-user']);
		$password 		= mysqli_real_escape_string($connect, $_POST['_password-user']);
		$errors			= array();
		if(empty($hidden_form)){
			if($csrf_token == $csrf_token_id){
				if(empty($email)){
					array_push($errors, "Email Field is Required");
				}
				if(empty($password)){
					array_push($errors, "Password Field is Required");
				}
				if(count($errors) == 0){
					$validation = mysqli_num_rows(mysqli_query($connect, "SELECT email, password from users WHERE email='$email' and password='$password'"));
					if($validation == 1){
						$usr_token = bin2hex(random_bytes(80));
						setcookie('token', $usr_token, time()+(3600*24*3), '/');
						mysqli_num_rows(mysqli_query($connect, "UPDATE users SET token='$usr_token' WHERE email='$email' AND password='$password'"));
						header('Location: ../../');
					}else {
						array_push($errors, "Invalid Credentials");
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
		<title>Login</title>
		<?php include('../../api/headers.php'); ?>
	</head>
	<body>
		<?php include('../../api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="header col-sm-12 col-md-6">
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
				<div class="col-sm-12 col-md-6">
					<div class="header form-group">
						<h1><b>Login</b></h1>
						<?php if(isset($errors)){include('../../api/errors.php');} ?>
						<form method="POST">
							<input type="text" name="_hidden-form" class="input-hidden">
							<input type="hidden" name="_csrf-token" value="<?php echo $token ?>">
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
							  </div>
							  <input type="email" name="_email-user" class="form-control" placeholder="Email">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
							  </div>
							  <input type="password" name="_password-user" class="form-control" placeholder="Password">
							</div>
							<button type="submit" name="_login-btn" class="btn btn-outline-primary" style="width: 100%;">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>