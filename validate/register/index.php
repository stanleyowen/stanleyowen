<?php
	error_reporting(0);
	include('../../global/config.php');
	include('../../global/speedup.php');
	include('../../global/redirect.php');
	
	if(isset($_GET['apps'])){
		$apps 		= mysqli_real_escape_string($connect, trim(addslashes($_GET['apps'])));
		if($apps === "todolist"){
			$login = "todolist";
		}
		else if($apps === "notes"){
			$login = "notes";
		}
		else if($apps === "pass-gen"){
			$login = "pass-gen";
		}
		else if($apps === "md5"){
			$login = "md5";
		}
		else if($apps === "sha1"){
			$login = "sha1";
		}
	}else {
		header('Location: ../../apps/');
	}

	if(isset($_POST['_submit'])) {
		$honeypot = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current'])));
		if(empty($honeypot)){
			$username = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current-username'])));
			$password1 = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current-password'])));
			$password2 = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current-confirm-password'])));
			$errors = array();
			if(empty($username)){
				array_push($errors, "Username Field is Required");
			}
			if(empty($password1)){
				array_push($errors, "Password Field is Required");
			}
			if(empty($password2)){
				array_push($errors, "Confirm Password Field is Required");
			}
			if(strlen($username) > 40){
				array_push($errors, "Username cannot contain more than 40 characters");
			}
			if(strlen($username) <= 5){
				array_push($errors, "Username cannot contain less than 5 characters");
			}
			if(strlen($password1) > 40){
				array_push($errors, "Password cannot contain more than 40 characters");
			}
			if(strlen($password1) <= 5){
				array_push($errors, "Password cannot contain less than 5 characters");
			}
			if(strlen($password2) > 40){
				array_push($errors, "Confirm Password cannot contain more than 40 characters");
			}
			if(strlen($password2) <= 5){
				array_push($errors, "Confirm Password cannot contain less than 5 characters");
			}
			if($password1 != $password2){
				array_push($errors, "Please make sure both password are match");
			}
			$validation = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE username='$username'"));
			if($validation > 0){
				array_push($errors, "Username unavailable! Please try another");
			}

			if(count($errors) == 0){
				$password 		= sha1(md5(sha1(sha1(md5($password1)))));
				$token 			= sha1(time());

				$token_id = openssl_random_pseudo_bytes(60);
				$token_id = bin2hex($token_id);

				mysqli_query($connect, "INSERT INTO users(username, password, token, token_id) VALUES('$username','$password','$token','$token_id')");
				setcookie('token', $generate_new_token, time() + (86400 * 7), "/");
				setcookie('token_id', $generate_new_tokenid, time() + (86400 * 7), "/");
				setcookie('loggedin', 'true', time() + (86400 * 7), "/");
				include('../../global/redirect-1.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Stanley Owen | Register</title>
		<?php include('../../global/head.php'); ?>
	</head>
	<body>
		<?php include('../../global/navbar.php'); ?>
		
		<div class="container">
	        <div style="margin-top: 4rem" class="row">
	          	<div class="col s8 offset-s2">
	            	<a href="<?php echo $proxy ?>" class="btn-flat waves-effect">
	             		<i class="material-icons left">keyboard_backspace</i> Back
	            	</a>
	            	<div class="col s12" style="padding-left: 11.250px">
		              	<h4><b>Register</b></h4>
		              	<p class="grey-text text-darken-1">
		                	Already have an account? <a href=<?php echo'"../login/?apps='.$login.'"'?>>Login</a>
		             	</p>
	            	</div>
	            </div>
	        </div>
	    </div>
		<div class="container">
			<div class="row">
	          	<div class="col s8 offset-s2">
	          		<?php include("../../global/error.php") ?>
		            <form method="POST">
		            	<div class="col s12">
		            		<input type="text" name="_current" style="display: none">
		            	</div>
						<div class="col s12">
							<label for="password">Username</label>
							<input type="text" name="_current-username" id="username"/>
						</div>
						<div class="col s12">
							<label for="password">Password</label>
						  	<input type="password" name="_current-password" id="password">
						</div>
						<div class="col s12">
							<label for="password">Confirm Password</label>
						  	<input type="password" name="_current-confirm-password" id="confirm-password">
						</div>
						<div class="col s12" style="padding-left: 11.250px">
							<button type="submit" name="_submit" class="btn btn-large waves-effect waves-light hoverable blue accent-3">
							 	Register
							</button>
						</div>
		            </form>
	          	</div>
	        </div>
	    </div>

	    <?php include('../../global/javascript.php'); ?>
		<?php include('../../global/footer.php'); ?>

	</body>
</html>