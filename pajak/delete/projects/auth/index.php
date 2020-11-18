<?php
	include('../../../api/index.php');
	include('../../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		$query 		= mysqli_query($connect, "SELECT project_name FROM projects WHERE token='$id' AND project_token='$uniqueid'");
		$check_db	= mysqli_num_rows($query);
		if($check_db == 1){
			while($check_name = mysqli_fetch_assoc($query)){
				$result_name = $check_name['project_name'];
			}
			$code = '
				<div class="container mt-20">
					<h2>Are You Sure Want to Delete <font color="red"><b>'.$result_name.'</b></font>?</h2>
					<p>This action cannot be <font color="red"><b>undone</b></font>. This will permanently delete <font color="red">'.$result_name.'</b></font> projects and all of its\' data</p>
					<form method="POST">
					  <div class="form-group">
					    <label for="exampleInputPassword1">Please type <b>'.$result_name.'</b> to confirm :</label>
					    <input type="text" name="_confirm-delete" class="form-control" autofocus>
					  </div>
					  <button name="_confirm" type="submit" class="btn btn-full btn-outline-danger">DELETE PERMANENTLY</button><br/>
					  <button name="_discard" type="submit" class="btn btn-full btn-outline-warning">DISCARD</button>
					</form>
				</div>
			';
		}else {
			$code = '<div class="mt-20"><h1>404 - NOT FOUND</h1></div>';
		}
	}else {
		$code = '<div class="mt-20"><h1>400 - BAD REQUEST</h1></div>';
	}

	if(isset($_POST['_confirm']) && isset($result_name)){
		$cf_code 	= mysqli_real_escape_string($connect, $_POST['_confirm-delete']);
		if($result_name == $cf_code){
			mysqli_query($connect, "DELETE FROM projects WHERE project_name='$result_name'");
			mysqli_query($connect, "DELETE FROM data WHERE origin='$result_name'");
			echo "<script>alert('Project Deleted Successfully');window.location='$URL'</script>";
		}else {
			echo "<script>alert('Confirmation Code Mismatch');</script>";
		}
	}else if(isset($_POST['_discard'])){
		header('Location: '.$URL.'');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Dashboard</title>
		<?php include('../../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<?php echo $code ?>
			</div>
		</div>
	</body>
</html>