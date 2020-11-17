<?php
	if(isset($_COOKIE['token'])){
		$token = mysqli_real_escape_string($connect, $_COOKIE['token']);
		if(strlen($token) == 160){
			$validation = mysqli_num_rows(mysqli_query($connect, "SELECT token FROM users WHERE token='$token'"));
			if($validation == 1){
				$query = mysqli_query($connect, "SELECT * FROM users WHERE token='$token'");
				while ($db_data = mysqli_fetch_assoc($query)) {
					$name = $db_data['username'];
					$unique_id1 = $db_data['unique_id'];
					$unique_id2 = $db_data['unique_id2'];
					$unique_token = $unique_id1.$unique_id2;
				}
			}else {
				setcookie('token', null, time()-3600, '/');
				echo "<script>alert('ERR CODE : 403\\nMESSAGE  : TOKEN MISMATCH\\nThis may happen when we cannot find a match token which is posted, with our system.\\nThe second reason is another devices attempted to login into your account. If it is not you, it is recoomended to change your password as soon as possible'); window.location='$URL/auth/login'</script>";
			}
		}else {
			setcookie('token', null, time()-3600, '/');
			echo "<script>alert('ERR CODE : 400\\nMESSAGE  : INVALID TOKEN\\nThis may happen when user attempted to change the value of a cookie. For security reasons, user need to login again.'); window.location='$URL/auth/login'</script>";
		}
	}else {
		header('Location: '.$URL.'/auth/login');
	}
?>