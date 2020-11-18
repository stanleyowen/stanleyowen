<?php
	if(isset($_GET['logout'])){
		$logout = mysqli_real_escape_string($connect, $_GET['logout']);
		if($logout == "true"){
			setcookie('token', null, time()-3600, '/');
			header('Location: '.$URL.'/auth/login');
		}
	}
	if(isset($_COOKIE['token'])){
		$token = mysqli_real_escape_string($connect, $_COOKIE['token']);
		if(strlen($token) == 160){
			$validation = mysqli_num_rows(mysqli_query($connect, "SELECT token FROM users WHERE token='$token'"));
			if($validation == 1){
				echo '
					<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
					  <a class="navbar-brand font-weight-bold" href="#">Financial Report</a>
					  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
					    <span class="navbar-toggler-icon"></span>
					  </button>
					  <div class="dropdown collapse navbar-collapse" id="navbarTogglerDemo02">
					  	<ul class="navbar-nav">
					      <li class="nav-item nav-link-a">
							    <a class="btn dropdown-toggle font-weight-bold text-white" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							      Dropdown button
							    </a>
							    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							      <a class="dropdown-item" href="#">Action</a>
							      <a class="dropdown-item" href="#">Another action</a>
							      <a class="dropdown-item" href="#">Something else here</a>
							    </div>
						  </li>
						</ul>
					  </div>
					  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
					    <ul class="navbar-nav">
					      <li class="nav-item nav-link-a">
					        <a class="nav-link font-weight-bold" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Logout</a>
					      </li>
					    </ul>
					  </div>
					</nav>';
			}
		}else {
			echo '
			<nav class="bg-dark navbar navbar-dark navbar-expand-lg"><a class="font-weight-bold navbar-brand"href="#">Financial Report</a> <button aria-controls="navbarTogglerDemo02"aria-expanded="false"aria-label="Toggle navigation"class="navbar-toggler"data-target="#navbarTogglerDemo02"data-toggle="collapse"type="button"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse"id="navbarTogglerDemo02"><ul class="mr-auto mt-2 mt-lg-0 navbar-nav"><li class="nav-item nav-link-a"><a class="font-weight-bold nav-link"href="'.$URL.'/auth/login/"><i class="fas fa-sign-in-alt"></i> Login</a></li><li class="nav-item nav-link-a"><a class="font-weight-bold nav-link"href="'.$URL.'/auth/register/"><i class="fas fa-users"></i> Register</a></li></ul></div></nav>';
		}
	}else {
		echo '
		<nav class="bg-dark navbar navbar-dark navbar-expand-lg"><a class="font-weight-bold navbar-brand"href="#">Financial Report</a> <button aria-controls="navbarTogglerDemo02"aria-expanded="false"aria-label="Toggle navigation"class="navbar-toggler"data-target="#navbarTogglerDemo02"data-toggle="collapse"type="button"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse"id="navbarTogglerDemo02"><ul class="mr-auto mt-2 mt-lg-0 navbar-nav"><li class="nav-item nav-link-a"><a class="font-weight-bold nav-link"href="'.$URL.'/auth/login/"><i class="fas fa-sign-in-alt"></i> Login</a></li><li class="nav-item nav-link-a"><a class="font-weight-bold nav-link"href="'.$URL.'/auth/register/"><i class="fas fa-users"></i> Register</a></li></ul></div></nav>';
	}
?>