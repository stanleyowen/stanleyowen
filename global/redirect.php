<?php
	if(isset($_COOKIE['token']) && $_COOKIE['token_id'] && isset($_COOKIE['loggedin'])){
		if(isset($_GET['apps'])){
			$apps 		= mysqli_real_escape_string($connect, trim(addslashes($_GET['apps'])));
			if($apps === "todolist"){
				header('Location:../../todo/');
			}
			else if($apps === "notes"){
				header("Location:../../notes/");
			}
			else if($apps === "pass-gen"){
				header("Location:../../pass-gen/");
			}
			else if($apps === "md5"){
				header("Location:../../md5/");
			}
			else if($apps === "sha1"){
				header("Location:../../sha1/");
			}
		}
	}
?>