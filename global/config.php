<?php
	//$databse_server			= "fdb26.awardspace.net";
	//$database_user			= "3426369_stanleyowen";
	//$database_password		= "@U8z@A3wMCGpwpB";
	//$database_name			= "3426369_stanleyowen";
	//$connect 					= mysqli_connect($databse_server, $database_user, $database_password, $database_name);
	$databse_server			= "localhost";
	$database_user			= "root";
	$database_password		= "";
	$database_name			= "stanleyowen";
	$connect 				= mysqli_connect($databse_server, $database_user, $database_password, $database_name);

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