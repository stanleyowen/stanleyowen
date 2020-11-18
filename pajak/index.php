<?php
	include('./api/index.php');
	include('./api/auth.php');
	if(isset($_POST['_create-project'])){
		$hidden_form	= mysqli_real_escape_string($connect, $_POST['_hidden-form']);
		$csrf_token_id	= mysqli_real_escape_string($connect, $_COOKIE['csrf-token']);
		$csrf_token		= mysqli_real_escape_string($connect, $_POST['_csrf-token']);
		$project_name	= mysqli_real_escape_string($connect, $_POST['_name-project']);
		$project_desc	= mysqli_real_escape_string($connect, $_POST['_desc-project']);
		$errors			= array();
		if(empty($hidden_form)){
			if($csrf_token == $csrf_token_id){
				if(empty($project_name)){ array_push($errors, "Project Name is Required"); }
				if(empty($project_desc)){ array_push($errors, "Project Description is Required"); }
				if(count($errors) == 0){
					if(strlen($project_name) > 30){ array_push($errors, "Project Name is too long"); }
					if(strlen($project_desc) > 100){ array_push($errors, "Project Description is too long"); }
				}
				if(count($errors) == 0){
					$validation = mysqli_num_rows(mysqli_query($connect, "SELECT project_name from projects WHERE project_name='$project_name'"));
					if($validation == 0){
						mysqli_query($connect, "INSERT INTO projects (project_name, project_description, project_token) VALUES ('$project_name', '$project_desc', '$project_token')");
					}
					else{
						array_push($errors, "Project Already Exists. Please Choose Another Projects");
					}
				}
			}else {
				echo "<script>alert('ERR CODE : 403\\nMESSAGE  : CSRF TOKEN MISMATCH\\nThis may happen when the form you entered doesn\\'t have the same value of CSRF Token. The second reason is the form\\'s token has expired.'); window.location=''</script>";
			}
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Dashboard</title>
		<?php include('./api/headers.php'); ?>
	</head>
	<body>
		<?php include('./api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<button type="button" class="btn-noborder" data-toggle="modal" data-target="#exampleModal">
					  <i style="font-size: 48px; color: Dodgerblue;"class="fas fa-plus-circle"></i>
					</button>

					<div class="modal fade" id="exampleModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form method="POST">
								<input type="text" name="_hidden-form" class="input-hidden">
								<input type="hidden" name="_csrf-token" value="<?php echo $csrf_token ?>">
								<div class="form-group">
									<label for="description">Project Name</label>
									<input type="text" name="_name-project" class="form-control" placeholder="Your Project Name (Max 30 Characters)" maxlength="30" required>
								</div>
								<div class="form-group">
								    <label for="description">Desciption</label>
								    <textarea class="form-control" name="_desc-project" id="description" rows="3" maxlength="100" placeholder="Your Project Name (Max 30 Characters)"></textarea>
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
						<h1>Project</h1>
						<?php if(isset($errors)){include('./api/errors.php');} ?>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group table-responsive">
						<table class="table hover-mode">
							<thead>
								<tr>
									<th scope="col">Project Name</th>
									<th scope="col">Description</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$project_query = mysqli_query($connect, "SELECT * FROM projects WHERE project_token='$project_token'");
									$validation = mysqli_num_rows($project_query);
									if($validation != 0){
										while($project = mysqli_fetch_assoc($project_query)){
											echo"<tr><th scope=\"row\">".$project['project_name']."</th><th>".$project['project_description']."</th></tr>";
										}
									}else {
										echo "
										<tr><th colspan=\"3\" scope=\"row\">
											<p class=\"project-null-msg italic\">No Projects</p>
										</th></tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>