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
					$validation = mysqli_num_rows(mysqli_query($connect, "SELECT project_name from projects WHERE project_name='$project_name' AND token='$project_token'"));
					if($validation == 0){
						$token_id = bin2hex(random_bytes(100));
						mysqli_query($connect, "INSERT INTO projects (project_name, project_description, project_token, token) VALUES ('$project_name', '$project_desc', '$project_token', '$token_id')");
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
	if(isset($_POST['_changepsw'])){
		$old_password 	= mysqli_real_escape_string($connect, $_POST['_old-password']);
		$new_password 	= mysqli_real_escape_string($connect, $_POST['_new-password']);
		$cf_password 	= mysqli_real_escape_string($connect, $_POST['_cf-password']);
		$errors 		= array();
		if(!empty($old_password) && !empty($new_password) && !empty($cf_password)){
			if(strlen($new_password) >= 6 && strlen($cf_password) >= 6 && strlen($new_password) <= 50 && strlen($cf_password) <= 50){
				$psw_validation = mysqli_query($connect, "SELECT password from users WHERE email='$email'");
				while ($psw_user_db = mysqli_fetch_assoc($psw_validation)){
					$psw_user = $psw_user_db['password'];
				}
				if(password_verify($old_password, $psw_user)){
					if($new_password == $cf_password){
						$usr_token = bin2hex(random_bytes(80));
						$usr_password = password_hash($new_password, PASSWORD_DEFAULT);
						setcookie('token', $usr_token, time()+(3600*24*3), '/');
						mysqli_query($connect, "UPDATE users SET password='$usr_password', token='$usr_token' WHERE email='$email'");
					}else {
						array_push($errors, "Make sure both New Password and Confirm Password are Match");
					}
				}else {
					array_push($errors, "Invalid Password");
				}
			}else {
				array_push($errors, "Something Went Wrong, Please Try Again");
			}
		}else {
			array_push($errors, "Make sure to fill out all the Required Fields");
		}
	}
	if(isset($_POST['display_project'])){
		$get_token = mysqli_real_escape_string($connect, $_POST['_project-token']);
		header('Location: '.$URl.'/pajak/projects/auth/?id='.$get_token.'&uniqueid='.$project_token.'');
	}
	if(isset($_POST['edit_project'])){
		$get_token = mysqli_real_escape_string($connect, $_POST['_project-token']);
		header('Location: '.$URl.'/pajak/projects/edit/auth/?id='.$get_token.'&uniqueid='.$project_token.'');
	}
	if(isset($_POST['delete_project'])){
		$get_token = mysqli_real_escape_string($connect, $_POST['_project-token']);
		header('Location: '.$URl.'/pajak/projects/delete/auth/?id='.$get_token.'&uniqueid='.$project_token.'');
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
					<form class="btn-cta">
						<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#accountInfo">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-user-circle"></i>
						  	</div>
						  	<div class="btn-fa-text">
						  		Account
						  	</div>
						</button>
					</form>
					<form class="btn-cta">
						<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#addProject">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-plus-circle"></i>
						  	</div>
						  	<div class="btn-fa-text">
						  		New Project
						  	</div>
						</button>
					</form>

					<div class="modal fade" id="addProject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
									<input type="text" name="_name-project" class="form-control" placeholder="Project Name (Max 30 Characters)" maxlength="30" required>
								</div>
								<div class="form-group">
								    <label for="description">Desciption</label>
								    <textarea class="form-control" name="_desc-project" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)" required></textarea>
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
					<div class="modal fade" id="accountInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Account Information</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>Username &nbsp; &nbsp; : <?php echo $name?></p>
					        <p>Email &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $email?></p>
					        <p>Password &nbsp; &nbsp; &nbsp;: ********** <a href="#" data-toggle="modal" data-target="#changePassword">Change Password</a></p>
					      </div>
					    </div>
					  </div>
					</div>

					<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<form method="POST">
						      	<div class="col-sm-12">
							        <label>Old Password</label><br/>
							        <input type="password" class="form-control" name="_old-password" placeholder="Input Old Password" autofocus="on" autocomplete="off" required />
							    </div>
							    <div class="col-sm-12">
							        <label class="input-form">New Password</label><br/>
							        <input type="password" class="form-control" name="_new-password" placeholder="Input Old Password (max 50 chars)" autocomplete="off" minlength="6" maxlength="50"required />
							    </div>
							    <div class="col-sm-12">
							        <label class="input-form">Confirm Password</label><br/>
							        <input type="password" class="form-control" name="_cf-password" placeholder="Input Old Password (max 50 chars)" autocomplete="off" minlength="6" maxlength="50" required />
							    </div>
					      </div>
					      <div class="modal-footer">
					      	<button type="submit" class="btn btn-primary" name="_changepsw">Change</button></form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Discard</button>
					      </div>
					    </div>
					  </div>
					</div>

					<div class="form-group">
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
									<th scope="col">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$project_query = mysqli_query($connect, "SELECT * FROM projects WHERE project_token='$project_token'");
									$validation = mysqli_num_rows($project_query);
									if($validation != 0){
										while($project = mysqli_fetch_assoc($project_query)){
											echo"
											<tr class=\"onhover\"><th scope=\"row\">".$project['project_name']."</th><th>".$project['project_description']."</th><th class=\"btn-on-hover\">
												<form class=\"btn-cta\" method=\"POST\">
													<input type=\"hidden\" name=\"_project-token\" value=\"".$project['token']."\" />
													<button type=\"submit\" class=\"btn-cta\" name=\"display_project\"><i class=\"fas fa-external-link-alt\"style=\"color: Dodgerblue;\"></i></button>
												</form>
												<form class=\"btn-cta\" method=\"POST\">
													<input type=\"hidden\" name=\"_project-token\" value=\"".$project['token']."\" />
													<button type=\"submit\" class=\"btn-cta\" name=\"edit_project\"><i class=\"fas fa-edit\" style=\"color: #d48728\"></i></button>
												</form>
												<form class=\"btn-cta\" method=\"POST\">
													<input type=\"hidden\" name=\"_project-token\" value=\"".$project['token']."\" />
													<button type=\"submit\" class=\"btn-cta\" name=\"delete_project\"><i class=\"fas fa-trash-alt\" style=\"color:red\"></i></button>
												</form>
											</th></tr>";
										}
									}else {
										echo "
										<tr><th colspan=\"3\" scope=\"row\"><p class=\"project-null-msg italic\">No Projects</p></th></tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php include('./api/js.php'); ?>
	</body>
</html>