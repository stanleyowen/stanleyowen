<?php
	$databse_server			= "";
	$database_user			= "";
	$database_password		= "";
	$database_name			= "";
	$connect 			= mysqli_connect($databse_server, $database_user, $database_password, $database_name);
        
	if(isset($_GET['logout'])){
	    $logout   = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_GET['logout']))));
	    if($logout == "true"){
	      setcookie('loggedin', '', time() - 3600, "/");
	      setcookie('token', '', time() - 3600, "/");
	      setcookie('token_id', '', time() - 3600, "/");
	      header('Location: '.$proxy.'/apps/');
	    }
	}
?>