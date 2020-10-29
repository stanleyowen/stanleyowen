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
				echo '<script>alert("ERROR: TOKEN MISMATCH! This may happen when other devices are trying to logged in into this account. If it is not you, it is recommended to change your password!");document.location="../validate/login/?apps=notes";</script>';
			}else {
				$check_name = mysqli_query($connect, "SELECT username FROM users WHERE token='$token' AND token_id='$token_id'");
			}
		}else {
			setcookie('loggedin', '', time() - 3600, "/");
			setcookie('token', '', time() - 3600, "/");
			setcookie('token_id', '', time() - 3600, "/");
			echo '<script>alert("ERROR: TOKEN MISMATCH!");document.location="../validate/login/?apps=notes";</script>';
		}
	}else {
		header('Location: ../validate/login/?apps=notes');
	}

	if(isset($_POST['_submit'])){
		$honeypot = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current'])));
		if(empty($honeypot)){
			$description = mysqli_real_escape_string($connect, trim(addslashes($_POST['_description'])));
			$errors = array();
			if(empty($description)){
				array_push($errors, "Notes Field is Required");
			}
			if(strlen($description) > 300){
				array_push($errors, "Notes cannot contain more than 300 characters");
			}
			if(count($errors) == 0){
				while ($row = mysqli_fetch_array($check_name)) {
					$name = $row['username'];
				}

				$notetoken = openssl_random_pseudo_bytes(80);
				$notetoken = bin2hex($notetoken);	
				mysqli_query($connect, "INSERT INTO notes(username, description, token) VALUES('$name','$description','$notetoken')");
			}
		}
	}

	if(isset($_GET['id'])){
		$id = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_GET['id']))));
		mysqli_query($connect, "DELETE FROM notes WHERE token='$id'");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stanley Owen | Notes</title>
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
		<h6>Welcome Back: <b><?php echo $name ?></b></h6>
		<h2><center>Notes</center></h2>
		<?php
			if(isset($_POST['_submit'])){
				include('../global/error.php');
			}
		?>
		<form method="POST">
			<input type="text" name="_current" style="display:none">

			<label for="description">Notes</label>
			<textarea name="_description" class="materialize-textarea" id="textarea" maxlength="300" placeholder="Type your notes here (max 300)"></textarea>

			<button type="submit" name="_submit" style="width: 100%" class="btn btn-large waves-effect waves-light hoverable blue accent-3">Add</button>
		</form>
		<table>
			<thead>
				<th>Notes</th>
				<th>Button</th>
			</thead>
			<tbody>
				<?php
					$query = mysqli_query($connect, "SELECT * FROM notes WHERE username='$name'");
					while ($row = mysqli_fetch_array($query)) {
						$message = "Are you sure want to Permanently Delete this Activity?";
						echo "<tr>
						<td>".$row['description']."</td>
						<td><a class=\"white\" href=\"?id=".$row['token']."\"class=\"btn first\" onClick=\"javascript: return confirm('$message')\"><i class=\"fa fa-window-close-o\" aria-hidden=\"true\"></i></a></td>";
					}
				?>
			</tbody>
		</table>
	</div>
    <?php include('../global/footer.php'); ?>
    <?php include('../global/javascript.php'); ?>

</body>
</html>