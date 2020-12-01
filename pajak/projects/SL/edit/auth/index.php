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
			}else {
				header('Location: '.$URL.'/errors/404/');
			}
		}else {
			header('Location: '.$URL.'/errors/403/');
		}
	}else {
		header('Location: '.$URL.'/errors/400/');
	}

	if(isset($_POST['_confirm'])){
		$balance 	= mysqli_real_escape_string($connect, $_POST['_balance']);
		$errors 	= array();
		if(is_numeric($balance) != 1 && !empty($errors)){ array_push($errors, "Please Provide a Valid Number"); }
		if(strlen($balance) > 20){ array_push($errors, "Balance Value too big (Out of Range)"); }
		if(count($errors) == 0){
			mysqli_query($connect, "UPDATE code_data SET bgn_balance='$balance' WHERE token='$id' AND code_id='$id2'");
			header('Location:'.$URL.'/projects/SL/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
		}
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
				<div class="container mt-20">
					<h2>Edit Projects</h2>
					<?php if(isset($errors)) { include('../../../../api/errors.php'); } ?>
					<form method="POST">
					  <div class="form-group">
					    <label for="project_name">Code :</label>
					    <input type="text" name="_confirm-pjname" class="form-control" placeholder="Project Name (Max 30 Characters)" value="<?php echo$result_code?>" autocomplete="off" autocapitalize="none" autofocus disabled>
					  </div>
					  <div class="form-group">
					  	<label for="description">Desciption</label>
						<textarea class="form-control" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)" disabled><?php echo $result_code_value?></textarea>
					  </div>
					  <div class="form-group">
					    <label for="project_name">Beginning Balance :</label>
					    <input type="number" name="_balance" class="form-control" placeholder="Beginning Balance (Max 20 Digits)" value="<?php echo $result_balance?>" autocomplete="off" autocapitalize="none" max="99999999999999999999" autofocus="on">
					  </div>
					  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button>
					  <button type="reset" class="btn btn-full btn-outline-warning">RESET</button>
					  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
					</form>
				</div>
			</div>
		</div>
		<?php include('../../../../api/js.php'); ?>
	</body>
</html>
