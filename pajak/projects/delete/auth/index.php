<?php
	include('../../../api/index.php');
	include('../../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		if($project_token == $uniqueid){
			$query 		= mysqli_query($connect, "SELECT project_name FROM projects WHERE token='$id' AND project_token='$uniqueid'");
			$check_db	= mysqli_num_rows($query);
			if($check_db == 1){
				while($check_name = mysqli_fetch_assoc($query)){
					$result_name = $check_name['project_name'];
				}
			}else {
				header('Location: '.$URL.'/errors/404/');
			}
		}else {
			header('Location: '.$URL.'/errors/403/');
		}
	}else {
		header('Location: '.$URL.'/errors/400/');
	}

	if(isset($_POST['_confirm']) && isset($result_name)){
		$cf_code 	= mysqli_real_escape_string($connect, $_POST['_confirm-delete']);
		$errors		= array();
		if($result_name == $cf_code){
			mysqli_query($connect, "DELETE FROM projects WHERE token='$id'");
			mysqli_query($connect, "DELETE FROM data WHERE token='$id'");
			header('Location:'.$URL);
		}else {
			array_push($errors, "Cannot Delete Project : Code Mismatch");
		}
	}else if(isset($_POST['_discard'])){
		header('Location: '.$URL);
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Delete | <?php echo $result_name?></title>
		<?php include('../../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container" style="margin-top: 50px;">
			<div class="row">
				<div class="container mt-20">
					<h2>Are You Sure Want to Delete <font color="red"><b><?php echo $result_name?></b></font>?</h2>
					<p>This action cannot be <font color="red"><b>undone</b></font>. This will permanently delete <font color="red"><b><?php echo $result_name?></b></font> projects and all of its' data</p>
					<?php if(isset($errors)){ include('../../../api/errors.php'); }?>
					<form method="POST">
					  <div class="form-group">
					    <label for="confirmation-code">Please type <b><?php echo $result_name?></b> to confirm :</label>
					    <input type="text" name="_confirm-delete" class="form-control" autocomplete="off" autocapitalize="none" autofocus>
					  </div>
					  <button name="_confirm" type="submit" class="btn btn-full btn-outline-danger">DELETE PERMANENTLY</button><br/>
					  <button name="_discard" type="submit" class="btn btn-full btn-outline-warning">DISCARD</button>
					</form>
				</div>
			</div>
		</div>
		<?php include('../../../api/js.php'); ?>
	</body>
</html>