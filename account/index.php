<?php
	include('../global/config.php');
	include('../global/speedup.php');
	if(isset($_COOKIE['token']) && isset($_COOKIE['token_id'])){
		$token 		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_COOKIE['token']))));
		$token_id 	= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_COOKIE['token_id']))));
		if(strlen($token) == 40 && strlen($token_id) == 120) {
			$validate = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE token='$token' AND token_id='$token_id'"));
			if($validate == 0){
				setcookie('loggedin', '', time() - 3600, "/");
				setcookie('token', '', time() - 3600, "/");
				setcookie('token_id', '', time() - 3600, "/");
				echo '<script>alert("ERROR: TOKEN MISMATCH! This may happen when other devices are trying to logged in into this account. If it is not you, it is recommended to change your password!");document.location="../validate/login/?apps=md5";</script>';
			}else {
				$check_name = mysqli_query($connect, "SELECT username FROM users WHERE token='$token' AND token_id='$token_id'");
			}
		}else {
			setcookie('loggedin', '', time() - 3600, "/");
			setcookie('token', '', time() - 3600, "/");
			setcookie('token_id', '', time() - 3600, "/");
			echo '<script>alert("ERROR: TOKEN MISMATCH!");document.location="../validate/login/?apps=md5;</script>';
		}
	}else {
		header('Location: ../apps/');
	}

	if(isset($_POST['_submit'])){
		$honeypot = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current'])));
		if(empty($honeypot)){
			$old 	= mysqli_real_escape_string($connect, trim(addslashes($_POST['_old-psw'])));
			$new 	= mysqli_real_escape_string($connect, trim(addslashes($_POST['_new-psw'])));
			$new2 	= mysqli_real_escape_string($connect, trim(addslashes($_POST['_new-psw2'])));
			$errors = array();
			if(empty($old) || empty($new) || empty($new2)){
				array_push($errors, "Make sure you fill out all the field");
			}
			if(strlen($old) > 40 || strlen($new) > 40 || strlen($new2) > 40){
				array_push($errors, "Password cannot contain more than 40 characters");
			}
			if($new != $new2) {
				array_push($errors, "Make sure both new password are typed correctly");
			}
			if(count($errors) == 0) {
				while ($row = mysqli_fetch_array($check_name)) {
					$name = $row['username'];
				}
				$password 	= sha1(md5(sha1(sha1(md5($old)))));
				$validate = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE username='$name' AND password='$password'"));
				if($validate > 0){
					$generate_new_token 	= sha1(time());
					$generate_new_tokenid 	= openssl_random_pseudo_bytes(60);
					$generate_new_tokenid 	= bin2hex($generate_new_tokenid);
					$new_password 			= sha1(md5(sha1(sha1(md5($new)))));
					mysqli_query($connect, "UPDATE users SET token='$generate_new_token', token_id='$generate_new_tokenid', password='$new_password' WHERE username='$name'");
					setcookie('token', $generate_new_token, time() + (86400 * 7), "/");
					setcookie('token_id', $generate_new_tokenid, time() + (86400 * 7), "/");
					setcookie('loggedin', 'true', time() + (86400 * 7), "/");
					array_push($errors, "Password Changed Successfully");
				}else{
					array_push($errors, "Current Password Mismatch");
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stanley Owen | Account</title>
	<?php include('../global/head.php'); ?>
</head>
<body>
	<?php
		include('../global/navbar.php');
		while ($row = mysqli_fetch_array($check_name)) {
			$name = $row['username'];
		}
	?>

	<div id="changepsw" class="modal">
      <div class="modal-content">
        <h4 style="color: black">Change Password</h4>
        <form action="#!" method="POST">
        	<input type="text" name="_current" id="current" style="display:none">
        	<label for="old-password" style="color: black">Current Password</label>
        	<input type="password" name="_old-psw" id="old-password">
        	<label for="new-password" style="color:black">New Password</label>
        	<input type="password" name="_new-psw" id="new-password">
        	<label for="new-password2" style="color:black">Confirm New Password</label>
        	<input type="password" name="_new-psw2" id="new-password2">
        	<button type="submit" name="_submit">Change Password</button>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

	<div class="container">
		<div class="row">
			<div class="col s12">
				<?php
					if(isset($_POST['_submit'])){
						include('../global/error.php');
					}
				?>
				<h3>Username &#9;:&#9;<b><?php echo $name ?></b></h6>
				<h3>Password &#9;:&#9;<a class="waves-effect waves-light btn modal-trigger red" href="#changepsw">Change Password</a>
			</div>
		</div>
	</div>
    <?php include('../global/footer.php'); ?>
    <?php include('../global/javascript.php'); ?>
</body>
</html>