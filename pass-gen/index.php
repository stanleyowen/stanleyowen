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
				echo '<script>alert("ERROR: TOKEN MISMATCH! This may happen when other devices are trying to logged in into this account. If it is not you, it is recommended to change your password!");document.location="../validate/login/?apps=pass-gen";</script>';
			}else {
				$check_name = mysqli_query($connect, "SELECT username FROM users WHERE token='$token' AND token_id='$token_id'");
			}
		}else {
			setcookie('loggedin', '', time() - 3600, "/");
			setcookie('token', '', time() - 3600, "/");
			setcookie('token_id', '', time() - 3600, "/");
			echo '<script>alert("ERROR: TOKEN MISMATCH!");document.location="../validate/login/?apps=pass-gen";</script>';
		}
	}else {
		header('Location: ../validate/login/?apps=pass-gen');
	}

	if(isset($_POST['_submit'])){
		$honeypot = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current'])));
		if(empty($honeypot)){
			$length = mysqli_real_escape_string($connect, trim(addslashes($_POST['_length'])));
			$errors = array();
			if(is_numeric($length) == true){
				if($length > 100){
					array_push($errors, "Please input the value under 100");
				}
				if(count($errors) == 0) {
					$lengthgen = $length;
				}
			}else{
				array_push($errors, "Unexpected String Expecting Integer [Make Sure the Value you input is a Number]");
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stanley Owen | Password Generator</title>
	<?php include('../global/head.php'); ?>
</head>
<body>
	<?php
		include('../global/navbar.php');
		while ($row = mysqli_fetch_array($check_name)) {
			$name = $row['username'];
		}
	?>

	<div class="container">
		<div class="row">
			<div class="col s12">
				<h6>Welcome Back: <b><?php echo $name ?></b></h6>
				<h2><center>Password Generator</center></h2>
				<?php
					if(isset($_POST['_submit'])){
						include('../global/error.php');
					}
				?>
				<form method="POST">
					<input type="text" name="_current" style="display:none">
					<div class="input-field col s12 m10">
						<label for="length">Digits</label>
						<input type="number" name="_length" placeholder="How many digits of password you would like to generate (max 100)" max="101" />
					</div>
					<div class="input-field col s12 m2">
						<button type="submit" name="_submit" style="width: 100%" class="btn btn-large waves-effect waves-light hoverable blue accent-3"><i class="material-icons">lock</i></button>
					</div>
				</form>
				<h4>Output :</h4>
				<div class="col s12">
					<?php
						function generate($length){
							$characters = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+";
							$charactersLength = strlen($characters);
							$result = "";
							for ($i=0; $i<$length; $i++) { 
								$result .= $characters[rand(0, $charactersLength - 1)];
							}
							return $result;
						}
						if(isset($lengthgen)){
							echo '
								<div class="col s12">
									<textarea class="materialize-textarea" id="password" disabled>'.generate($lengthgen).'</textarea>
								</div>
							';
						}else {
							echo '<h4>Your Result goes here</h4>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
    <?php include('../global/footer.php'); ?>
    <?php include('../global/javascript.php'); ?>
</body>
</html>