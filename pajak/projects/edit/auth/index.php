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
				$code = '
					<div class="container mt-20">
						<h2>Edit Projects</h2>
						<form method="POST">
						  <div class="form-group">
						    <label for="project_name">Project Name :</label>
						    <input type="text" name="_confirm-pjname" class="form-control" placeholder="Project Name (Max 30 Characters)" value="'.$result_name.'" autocomplete="off" autocapitalize="none" autofocus>
						  </div>
						  <div class="form-group">
						  	<label for="description">Desciption</label>
							<textarea class="form-control" name="_confirm-pjdesc" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)">'.$result_description.'</textarea>
						  </div>
						  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button><br/>
						  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
						</form>
					</div>
				';
			}else {
				$code = '<div class="mt-20"><h1>404 - NOT FOUND</h1></div>';
			}
		}else {
			$code = '<div class="mt-20"><h1>403 - FORBIDDEN</h1></div>';
		}
	}else {
		$code = '<div class="mt-20"><h1>400 - BAD REQUEST</h1></div>';
	}

	if(isset($_POST['_confirm']) && isset($result_name)){
		$project_name 			= mysqli_real_escape_string($connect, $_POST['_confirm-pjname']);
		$project_description 	= mysqli_real_escape_string($connect, $_POST['_confirm-pjdesc']);
		mysqli_query($connect, "UPDATE projects SET project_name='$project_name', project_description='$project_description'");
		echo "<script>alert('CODE : 200\\nMESSAGE  : PROJECT UPDATED SUCCESSFULLY');window.location='$URL'</script>";
	}else if(isset($_POST['_discard'])){
		header('Location: '.$URL.'');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Edit Projects</title>
		<?php include('../../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<?php echo $code ?>
			</div>
		</div>
		<?php include('../../../api/js.php'); ?>
	</body>
</html>
