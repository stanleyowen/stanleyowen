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
				echo '<script>alert("Token Mismatch!");document.location="../validate/login/?apps=todolist";</script>';
			}else {
				$check_name = mysqli_query($connect, "SELECT username FROM users WHERE token='$token' AND token_id='$token_id'");
			}
		}else {
			setcookie('loggedin', '', time() - 3600, "/");
			setcookie('token', '', time() - 3600, "/");
			setcookie('token_id', '', time() - 3600, "/");
			echo '<script>alert("Token Mismatch!");document.location="../validate/login/?apps=todolist";</script>';
		}
	}else {
		header('Location: ../validate/login/?apps=todolist');
	}

	if(isset($_POST['_submit'])){
		$honeypot = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current'])));
		if(empty($honeypot)){
			$activity = mysqli_real_escape_string($connect, trim(addslashes($_POST['_activity'])));
			$duedate = mysqli_real_escape_string($connect, trim(addslashes($_POST['_date'])));
			$errors = array();
			if(empty($activity)){
				array_push($errors, "Activity Field is Required");
			}
			if(empty($duedate)){
				array_push($errors, "Due Date Field is Required");
			}
			if(strlen($activity) > 200){
				array_push($errors, "Activity cannot contain more than 200 characters");
			}
			if(strlen($duedate) > 10){
				array_push($errors, "Date Field cannot contain more than 10 characters");
			}
			if(count($errors) == 0){
				while ($row = mysqli_fetch_array($check_name)) {
					$name = $row['username'];
				}

				$todotoken = openssl_random_pseudo_bytes(80);
				$todotoken = bin2hex($todotoken);	
				mysqli_query($connect, "INSERT INTO todo(username, activity, duedate, token) VALUES('$name','$activity','$duedate','$todotoken')");
			}
		}
	}

	if(isset($_GET['id'])){
		$id = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_GET['id']))));
		mysqli_query($connect, "DELETE FROM todo WHERE token='$id'");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stanley Owen | Todo List</title>
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
		<h2><center>Todo List</center></h2>
		<?php
			if(isset($_POST['_submit'])){
				include('../global/error.php');
			}
		?>
		<form method="POST">
			<input type="text" name="_current" style="display:none">

			<label for="activity">Activity Name</label>
			<input type="text" name="_activity" placeholder="Type your activity here (max 200)"/>

			<label for="date">Due Data (Deadline)</label>
			<input type="date" name="_date" />

			<button type="submit" name="_submit" style="width: 100%" class="btn btn-large waves-effect waves-light hoverable blue accent-3">Add</button>
		</form>
		<table>
			<thead>
				<th>Activity</th>
				<th>Deadline</th>
				<th>Button</th>
			</thead>
			<tbody>
				<?php
					$query = mysqli_query($connect, "SELECT * FROM todo WHERE username='$name'");
					while ($row = mysqli_fetch_array($query)) {
						$message = "Are you sure want to Permanently Delete this Activity?";
						echo "<tr>
						<td>".$row['activity']."</td>
						<td>".$row['duedate']."</td>
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