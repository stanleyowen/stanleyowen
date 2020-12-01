<?php
	include('../../../../api/index.php');
	include('../../../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$id2		= mysqli_real_escape_string($connect, $_GET['ids']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		if($project_token == $uniqueid){
			$query 		= mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code_id='$id2'");
			$check_db	= mysqli_num_rows($query);
			if($check_db == 1){
				while($check_name = mysqli_fetch_assoc($query)){
					$result_code 		= $check_name['code'];
					$result_code_value	= $check_name['description'];
					$result_balance		= $check_name['bgn_balance'];
				}
				$code = '
					<div class="container mt-20">
						<h2>Edit Projects</h2>
						<form method="POST">
						  <div class="form-group">
						    <label for="project_name">Code :</label>
						    <input type="text" name="_confirm-pjname" class="form-control" placeholder="Project Name (Max 30 Characters)" value="'.$result_code.'" autocomplete="off" autocapitalize="none" autofocus disabled>
						  </div>
						  <div class="form-group">
						  	<label for="description">Desciption</label>
							<textarea class="form-control" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)" disabled>'.$result_code_value.'</textarea>
						  </div>
						  <div class="form-group">
						    <label for="project_name">Beginning Balance :</label>
						    <input type="text" name="_balance" class="form-control" placeholder="Beginning Balance (Max 20 Digits)" value="'.$result_balance.'" autocomplete="off" autocapitalize="none" autofocus>
						  </div>
						  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button><br/>
						  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
						</form>
					</div>
				';
			}else {
				$code = '<div class="mt-20"><h1>404 - NOT FOUND</h1></div>';
			}
		}else {
			$code = '<div class="mt-20"><h1>403 - FORBIDDEN</h1></div>';
		}
	}else {
		$code = '<div class="mt-20"><h1>400 - BAD REQUEST</h1></div>';
	}

	if(isset($_POST['_confirm'])){
		$balance 			= mysqli_real_escape_string($connect, $_POST['_balance']);
		mysqli_query($connect, "UPDATE code_data SET bgn_balance='$balance' WHERE token='$id' AND code_id='$id2'");
		header('Location:'.$URL.'/projects/SL/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}else if(isset($_POST['_discard'])){
		header('Location:'.$URL.'/projects/SL/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Edit Projects</title>
		<?php include('../../../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<?php echo $code ?>
			</div>
		</div>
		<?php include('../../../../api/js.php'); ?>
	</body>
</html>
