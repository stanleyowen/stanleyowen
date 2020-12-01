<?php
	include('../../../api/index.php');
	include('../../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		if($project_token == $uniqueid){
			$query 		= mysqli_query($connect, "SELECT project_name, project_description FROM projects WHERE token='$id' AND project_token='$uniqueid'");
			$check_db	= mysqli_num_rows($query);
			if($check_db == 1){
				while($check_name = mysqli_fetch_assoc($query)){
					$result_name 		= $check_name['project_name'];
					$result_description	= $check_name['project_description'];
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
		$project_name 			= mysqli_real_escape_string($connect, $_POST['_confirm-pjname']);
		$project_description 	= mysqli_real_escape_string($connect, $_POST['_confirm-pjdesc']);
		$errors 				= array();
		if(empty($project_name) || empty($project_description)){
			array_push($errors, "Make sure to fill out all Required Fields");
		}
		if(strlen($project_name) > 30){ array_push($errors, "Project Name is too Long"); }
		if(strlen($project_description) > 100){ array_push($errors, "Project Description is too Long"); }
		if(count($errors) == 0){
			mysqli_query($connect, "UPDATE projects SET project_name='$project_name', project_description='$project_description' WHERE token='$id'");
			header('Location: '.$URL);
		}
	}else if(isset($_POST['_discard'])){
		header('Location: '.$URL);
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Edit | <?php echo $result_name?></title>
		<?php include('../../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="container mt-20">
					<h2>Edit Projects</h2>
					<?php if(isset($errors)){ include('../../../api/errors.php'); }?>
					<p class="required">* required</p>
					<form method="POST">
					  <div class="form-group">
					    <label for="project_name">Project Name <span class="required">*</span></label>
					    <input type="text" name="_confirm-pjname" class="form-control" placeholder="Project Name (Max 30 Characters)" value="<?php echo $result_name?>" autocomplete="off" autocapitalize="none" autofocus="on" required>
					  </div>
					  <div class="form-group">
					  	<label for="description">Desciption <span class="required">*</span></label>
						<textarea class="form-control" name="_confirm-pjdesc" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)" required><?php echo $result_description ?></textarea>
					  </div>
					  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button><br/>
					  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
					</form>
				</div>
			</div>
		</div>
		<?php include('../../../api/js.php'); ?>
	</body>
</html>
