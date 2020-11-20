<?php
	include('../../api/index.php');
	include('../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		if($project_token == $uniqueid){
			$query 		= mysqli_query($connect, "SELECT * FROM projects WHERE token='$id' AND project_token='$uniqueid'");
			$check_db	= mysqli_num_rows($query);
			if($check_db == 1){
				while($check_name = mysqli_fetch_assoc($query)){
					$result_name 		= $check_name['project_name'];
					$result_description	= $check_name['project_description'];
					$result_status		= $check_name['status'];
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

	if(isset($_POST['_delete-project'])){
		header('Location:'.$URL.'/projects/delete/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}
	if(isset($_POST['_back-btn'])){
		header('Location:'.$URL.'');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Projects | <?php echo $result_name?></title>
		<?php include('../../api/headers.php'); ?>
	</head>
	<body>
		<?php include('../../api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<form method="POST" class="btn-cta">
						<button type="submit" name="_back-btn" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-long-arrow-alt-left"></i>
						  	</div>
						  	<div class="btn-fa-text">
						  		Back
						  	</div>
						</button>
					</form>

					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#addData">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-plus-circle"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		New Data
					  	</div>
					</button>

					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#infoData">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-info-circle"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		Information
					  	</div>
					</button>
					<form method="POST" class="btn-cta">
						<button type="submit" name="_delete-project" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: red;"class="fas fa-trash-alt"></i>
						  	</div>
						  	<div class="btn-fa-text">
						  		DELETE
						  	</div>
						</button>
					</form>
					<div class="modal fade" id="addData" tabindex="-1" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form method="POST">
								<input type="text" name="_hidden-form" class="input-hidden">
								<input type="hidden" name="_csrf-token" value="<?php echo $csrf_token ?>">
								<div class="form-group">
									<label for="description">Date</label>
									<input type="text" name="_name-project" class="form-control" placeholder="Project Name (Max 30 Characters)" maxlength="30" required>
								</div>
								<div class="form-group">
								    <label for="description">Desciption</label>
								    <textarea class="form-control" name="_desc-project" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)"></textarea>
								</div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Discard</button>
					        <button type="submit" name="_create-project" class="btn btn-primary">Create</button>
					        </form>
					      </div>
					    </div>
					  </div>
					</div>
					<div class="form-group">
						<?php if(isset($errors)){include('../../api/errors.php');} ?>
					</div>
				</div>

				<div class="modal fade" id="infoData" tabindex="-1" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Information</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>Project Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $result_name?></p>
					        <p>Project Description : <?php echo $result_description?>
					        <p class="status">System Status &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp;
					        	<?php
					        		if($result_status == "All Good") {
					        			echo "<p class=\"status text-success font-weight-bold\">".$result_status."</p>";
					        		}else {
					        			echo "<p class=\"status text-danger font-weight-bold\">".$result_status."</p>";
					        		}
					        	?>
					        </p> 
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					        </form>
					      </div>
					    </div>
					  </div>
					</div>
					<div class="form-group">
						<?php if(isset($errors)){include('../../api/errors.php');} ?>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group table-responsive">
						<table class="table hover-mode">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Project Name</th>
									<th scope="col">Description</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$data_query = mysqli_query($connect, "SELECT * FROM data WHERE token='$token'");
									$validation = mysqli_num_rows($data_query);
									if($validation != 0){
										$number = 1;
										while($data = mysqli_fetch_assoc($project_query)){
											echo"<tr><th scope=\"row\">".$number."</th><th>".$data['project_name']."</th><th>".$project['project_description']."</th></tr>";
										}
									}else {
										echo "
										<tr><th colspan=\"3\" scope=\"row\"><p class=\"project-null-msg italic\">No Data</p></th></tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php include('../../api/js.php'); ?>
	</body>
</html>
