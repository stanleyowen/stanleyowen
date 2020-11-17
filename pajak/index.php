<?php
	include('./api/index.php');
	include('./api/auth.php');
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
					<div class="form-group">
						<h1>Project</h1>
						<?php if(isset($errors)){include('../../api/errors.php');} ?>
						<form method="POST">
							<input type="text" name="_hidden-form" class="input-hidden">
							<input type="hidden" name="_csrf-token" value="<?php echo $token ?>">
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
							  </div>
							  <input type="email" name="_email-user" class="form-control" placeholder="Email">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
							  </div>
							  <input type="password" name="_password-user" class="form-control" placeholder="Password">
							</div>
							<button type="submit" name="_login-btn" class="btn btn-outline-primary" style="width: 100%;">Login</button>
						</form>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>