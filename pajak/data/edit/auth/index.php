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
					$price		 	= $check_name['price'];
					$date		 	= $check_name['date'];
					$debit 		 	= $check_name['debit'];
					$credit		 	= $check_name['credit'];
				}

				$res_code = '
					<div class="container mt-20">
						<h2>Edit Data</h2>
						<form method="POST">
					        <p class="required">* required</p>
					        	<div class="form-group">
									<label for="Code">Code <span class="required">*</span></label>
									<input type="number" name="_code" value="'.$code.'" class="form-control" placeholder="Input Data (max 5 digits)" max="99999" min="0" required>
								</div>
								<div class="form-group">
									<label for="description">Date <span class="required">*</span></label>
									<input type="date" name="_date" value="'.$date.'" max="9999-12-31" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="description">Proof Code</label>
									<input type="text" name="_proof-code" value="'.$proof_code.'" class="form-control" maxlength="50" placeholder="Input Proof Code (max 50 chars)">
								</div>
								<div class="form-group">
									<label for="description">Description <span class="required">*</span></label>
									<input type="text" name="_desc-data" class="form-control" maxlength="100" value="'.$description.'" placeholder="Input Data (max 100 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Block</label>
									<input type="text" name="_block" value="'.$block.'" class="form-control" maxlength="10" placeholder="Input Block (max 10 digits)">
								</div>
								<div class="form-group">
									<label for="description">Quantity</label>
									<input type="number" name="_qty" value="'.$qty.'" class="form-control" max="9999999999" placeholder="Input Quantity (max 10 digits)">
								</div>
								<div class="form-group">
									<label for="description">Unit</label>
									<input type="text" name="_unit" value="'.$unit.'" class="form-control" maxlength="10" placeholder="Input Unit (max 10 chars)">
								</div>
								<div class="form-group">
									<label for="description">Price <span class="required">*</span></label>
									<input type="number" name="_price" value="'.$price.'" class="form-control" max="99999999999999999999" placeholder="Input Price (max 20 digits)" required>
								</div>
								<div class="form-group">
									<label for="description">Debit <span class="required">*</span></label>
									<input type="number" name="_debit" value="'.$debit.'" class="form-control" max="99999999999999999999" placeholder="Input Debit (max 20 digits)" required>
								</div>
								<div class="form-group">
									<label for="description">Credit <span class="required">*</span></label>
									<input type="number" name="_credit" value="'.$credit.'" class="form-control" max="99999999999999999999" placeholder="Input Credit (max 20 digits)" required>
								</div>
					      </div>
						  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button><br/>
						  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
						</form>
					</div>
				';
			}else {
				$res_code = '<div class="mt-20"><h1>404 - NOT FOUND</h1></div>';
			}
		}else {
			$res_code = '<div class="mt-20"><h1>403 - FORBIDDEN</h1></div>';
		}
	}else {
		$res_code = '<div class="mt-20"><h1>400 - BAD REQUEST</h1></div>';
	}

	if(isset($_POST['_confirm'])){
		$code 		= mysqli_real_escape_string($connect, $_POST['_code']);
		$date 		= mysqli_real_escape_string($connect, $_POST['_date']);
		$proof_code = mysqli_real_escape_string($connect, $_POST['_proof-code']);
		$desc_data	= mysqli_real_escape_string($connect, $_POST['_desc-data']);
		$block		= mysqli_real_escape_string($connect, $_POST['_block']);
		$qty 		= mysqli_real_escape_string($connect, $_POST['_qty']);
		$unit 		= mysqli_real_escape_string($connect, $_POST['_unit']);
		$price 		= mysqli_real_escape_string($connect, $_POST['_price']);
		$debit 		= mysqli_real_escape_string($connect, $_POST['_debit']);
		$credit 	= mysqli_real_escape_string($connect, $_POST['_credit']);
		$errors = array();
		if(empty($code) || empty($desc_data) || empty($date) || empty($price) || empty($debit) || empty($credit)){
			array_push($errors, "Make sure to fill out all the required forms");
		}else {
			if(is_numeric($code) != 1){ array_push($errors, $code." is not an integer");			}
			if(is_numeric($qty) != 1 && !empty($qty)){ array_push($errors, $qty." is not an integer");			}
			if(is_numeric($price) != 1){ array_push($errors, $price." is not an integer");			}
			if(is_numeric($debit) != 1){ array_push($errors, $debit." is not an integer");			}
			if(is_numeric($credit) != 1){ array_push($errors, $credit." is not an integer");			}
			if(count($errors) == 0) {
				if($code > 99999){ array_push($errors, "Code is too long"); }
				if(strlen($proof_code) > 25 && !empty($proof_code)) { array_push($errors, "Proof Code is too long"); }
				if(strlen($desc_data) > 100){ array_push($errors, "Description is too long"); }
				if(strlen($block) > 10 && !empty($block)) { array_push($errors, "Block is too long"); }
				if($qty > 9999999999 && !empty($qty)) { array_push($errors, "Quantity is too long"); }
				if(strlen($unit) > 25 && !empty($unit)) { array_push($errors, "Unit is too long"); }
				if($price > 99999999999999999999) { array_push($errors, "Price is too long"); }
				if($debit > 99999999999999999999) { array_push($errors, "Debit is too long"); }
				if($credit > 99999999999999999999) { array_push($errors, "Credit is too long"); }
				if(strlen($date) > 10){ array_push($errors, "Please Provide a Valid Date"); }
				if(count($errors) == 0) {
					$code_value = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code='$code'");
					$validate_code = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code='$code'"));
					if($validate_code > 0){
						while ($get_value = mysqli_fetch_assoc($code_value)){
							$code_description = $get_value['description'];
						}
						mysqli_query($connect, "UPDATE data SET code='$code', code_value='$code_description', proof_code='$proof_code', data='$desc_data', block='$block', qty='$qty', unit='$unit', price='$price', date='$date', debit='$debit', credit='$credit', token='$id' WHERE data_id='$data'");
						header('Location:'.$url.'');
					}else {
						array_push($errors, "Ref Code Not Found");
					}
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
				<?php echo $res_code ?>
			</div>
		</div>
		<?php include('../../../api/js.php'); ?>
	</body>
</html>
