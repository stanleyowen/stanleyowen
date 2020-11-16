<?php
	include('../../api/index.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Register</title>
		<?php include('../../api/headers.php'); ?>
	</head>
	<body>
		<?php include('../../api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-5">
					<div class="header form-group">
						<h1><b>Register</b></h1>
						<form action="">
							<input type="text" name="_hidden-form" class="input-hidden">
							<input type="hidden" name="_csrf-token" value="<?php echo $token ?>">
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
							  </div>
							  <input type="text" name="_name-user" class="form-control" placeholder="Full Name" aria-label="Name" aria-describedby="basic-addon1">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
							  </div>
							  <input type="email" name="_email-user" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
							  </div>
							  <input type="password" name="_password-user" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
							</div>
							<div class="input-group mb-3 input-form">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
							  </div>
							  <input type="password" name="_confirm-password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="basic-addon1">
							</div>
							<button type="submit" name="_register-btn" class="btn btn-outline-primary" style="width: 100%;">Register</button>
						</form>
					</div>
				</div>
				<div class="header col-sm-12 col-md-7">
					<h1>
						<b>Why Us</b>
					</h1>
					<h4>
						<div class="adv">
							<div class="adv-desc">
								<i class="fas fa-lock" style="color: #10c242"></i>
							</div>
							<div class="adv-desc">
								Secured with SSL Certificate (HTTPS)
							</div>
						</div>
						<div class="adv">
							<div class="adv-desc">
								<i class="fas fa-lock" style="color: #10c242"></i>
							</div>
							<div class="adv-desc">
								Encrypted With SHA 256 Encryption During Transmission
							</div>
						</div>
						<div class="adv">
							<div class="adv-desc">
								<i class="fas fa-lock" style="color: #10c242"></i>
							</div>
							<div class="adv-desc">
								Data are Hashed before Saved in Database
							</div>
						</div>
					</h4>
				</div>
			</div>
		</div>
	</body>
</html>