<?php
	include('../../../api/index.php');
	include('../../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid']) && isset($_GET['data']) && isset($_GET['url'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		$data		= mysqli_real_escape_string($connect, $_GET['data']);
		$url		= mysqli_real_escape_string($connect, urldecode($_GET['url']));
		$errors 	= array();
		if($project_token == $uniqueid){
			$query 		= mysqli_query($connect, "SELECT * FROM data WHERE token='$id' AND data_id='$data'");
			$check_db	= mysqli_num_rows($query);
			if($check_db == 1){
				while($check_name = mysqli_fetch_assoc($query)){
					$code 			= $check_name['code'];
					$proof_code		= $check_name['proof_code'];
					$description 	= $check_name['data'];
					$block		 	= $check_name['block'];
					$qty		 	= $check_name['qty'];
					$unit		 	= $check_name['unit'];
					$date		 	= $check_name['date'];
					$debit 		 	= $check_name['debit'];
					$credit		 	= $check_name['credit'];
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
		$code 		= mysqli_real_escape_string($connect, $_POST['_code']);
		$date 		= mysqli_real_escape_string($connect, $_POST['_date']);
		$proof_code = mysqli_real_escape_string($connect, $_POST['_proof-code']);
		$desc_data	= mysqli_real_escape_string($connect, $_POST['_desc-data']);
		$block		= mysqli_real_escape_string($connect, $_POST['_block']);
		$qty 		= mysqli_real_escape_string($connect, $_POST['_qty']);
		$unit 		= mysqli_real_escape_string($connect, $_POST['_unit']);
		$debit 		= mysqli_real_escape_string($connect, $_POST['_debit']);
		$credit 	= mysqli_real_escape_string($connect, $_POST['_credit']);
		$errors = array();
		if(empty($code) || empty($desc_data) || empty($date)){
			array_push($errors, "Make sure to fill out all the required forms");
		}else {
			if(is_numeric($code) != 1){ array_push($errors, $code." is not an integer"); }
			if(is_numeric($qty) != 1 && !empty($qty)){ array_push($errors, $qty." is not an integer"); }
			if(is_numeric($debit) != 1 && !empty($qty)){ array_push($errors, $debit." is not an integer"); }
			if(is_numeric($credit) != 1 && !empty($qty)){ array_push($errors, $credit." is not an integer"); }
			if(count($errors) == 0) {
				if($code > 99999){ array_push($errors, "Code is too long"); }
				if(strlen($proof_code) > 25 && !empty($proof_code)) { array_push($errors, "Proof Code is too long"); }
				if(strlen($desc_data) > 100){ array_push($errors, "Description is too long"); }
				if(strlen($block) > 10 && !empty($block)) { array_push($errors, "Block is too long"); }
				if($qty > 9999999999 && !empty($qty)) { array_push($errors, "Quantity is too long"); }
				if(strlen($unit) > 25 && !empty($unit)) { array_push($errors, "Unit is too long"); }
				if($debit > 99999999999999999999 && !empty($debit)) { array_push($errors, "Debit is too long"); }
				if($credit > 99999999999999999999 && !empty($credit)) { array_push($errors, "Credit is too long"); }
				if(strlen($date) > 10){ array_push($errors, "Please Provide a Valid Date"); }
				if(!empty($debit) || !empty($credit)){
					if(count($errors) == 0) {
						$code_value = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code='$code'");
						$validate_code = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code='$code'"));
						if($validate_code > 0){
							while ($get_value = mysqli_fetch_assoc($code_value)){
								$code_description = $get_value['description'];
							}
							mysqli_query($connect, "UPDATE data SET code='$code', code_value='$code_description', proof_code='$proof_code', data='$desc_data', block='$block', qty='$qty', unit='$unit', date='$date', debit='$debit', credit='$credit', token='$id' WHERE data_id='$data'");
							header('Location:'.$url.'');
						}else {
							array_push($errors, "Ref Code Not Found");
						}
					}
				}else {
					array_push($errors, "At least 1 field must be filled in Credit or Debit Field");
				}
			}
		}
	}else if(isset($_POST['_discard'])){
		header('Location: '.$url.'');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Edit Projects</title>
		<?php include('../../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container">
			<?php if(isset($errors)) { include('../../../api/errors.php'); } ?>
			<div class="row">
				<div class="container mt-20">
						<h2>Edit Data</h2>
						<form method="POST">
					        <p class="required">* required</p>
					        <p class="required">** At least one field must be filled</p>
					        	<div class="form-group">
									<label for="Code">Code <span class="required">*</span></label>
									<select name="_code" class="form-control" required>
										<option value="<?php echo $code ?>"><?php echo $code ?></option>
										<?php
											$option_query = mysqli_query($connect, "SELECT code FROM code_data WHERE token='$id'");
											while ($fetch_data = mysqli_fetch_assoc($option_query)) {
												echo "<option value=".$fetch_data['code'].">".$fetch_data['code']."</option>";
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="description">Date <span class="required">*</span></label>
									<input type="date" name="_date" value="<?php echo $date?>" max="9999-12-31" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="description">Proof Code</label>
									<input type="text" name="_proof-code" value="<?php echo $proof_code ?>" class="form-control" maxlength="50" placeholder="Input Proof Code (max 50 chars)">
								</div>
								<div class="form-group">
									<label for="description">Description <span class="required">*</span></label>
									<input type="text" name="_desc-data" class="form-control" maxlength="100" value="<?php echo $description ?>" placeholder="Input Data (max 100 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Block</label>
									<input type="text" name="_block" value="<?php echo $block ?>" class="form-control" maxlength="10" placeholder="Input Block (max 10 digits)">
								</div>
								<div class="form-group">
									<label for="description">Quantity</label>
									<input type="number" name="_qty" value="<?php echo $qty ?>" class="form-control" max="9999999999" placeholder="Input Quantity (max 10 digits)">
								</div>
								<div class="form-group">
									<label for="description">Unit</label>
									<input type="text" name="_unit" value="<?php echo $unit ?>" class="form-control" maxlength="10" placeholder="Input Unit (max 10 chars)">
								</div>
								<div class="form-group">
									<label for="description">Debit <span class="required">**</span></label>
									<input type="number" name="_debit" value="<?php echo $debit ?>" class="form-control" max="99999999999999999999" placeholder="Input Debit (max 20 digits)">
								</div>
								<div class="form-group">
									<label for="description">Credit <span class="required">**</span></label>
									<input type="number" name="_credit" value="<?php echo $credit ?>" class="form-control" max="99999999999999999999" placeholder="Input Credit (max 20 digits)">
								</div>
					      </div>
						  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button><br/>
						  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
						</form>
					</div>
			</div>
		</div>
		<?php include('../../../api/js.php'); ?>
	</body>
</html>
