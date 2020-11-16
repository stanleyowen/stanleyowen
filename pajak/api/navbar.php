<?php
	echo '
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand font-weight-bold" href="#">Financial Report</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
		    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		      <li class="nav-item nav-link-a">
		        <a class="nav-link font-weight-bold" href="'.$URL.'/auth/login/"><i class="fas fa-sign-in-alt"></i> Login</a>
		      </li>
		      <li class="nav-item nav-link-a">
		        <a class="nav-link font-weight-bold" href="'.$URL.'/auth/register/"><i class="fas fa-users"></i></i> Register</a>
		      </li>
		    </ul>
		  </div>
		</nav>';
?>