<?php
	include('../../api/index.php');
	include('../../api/auth.php');
	
	if(isset($_GET['id']) && isset($_GET['uniqueid'])){
		$id 		= mysqli_real_escape_string($connect, $_GET['id']);
		$uniqueid	= mysqli_real_escape_string($connect, $_GET['uniqueid']);
		if($project_token == $uniqueid){
			$query 		= mysqli_query($connect, "SELECT * FROM projects WHERE token='$id' AND project_token='$uniqueid'");
			$check_db	= mysqli_num_rows($query);
			if($check_db == 1){
				while($check_name = mysqli_fetch_assoc($query)){
					$result_name 		= $check_name['project_name'];
					$result_description	= $check_name['project_description'];
					$result_status		= $check_name['status'];
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

	if(isset($_POST['_create-data']) && isset($result_name)){
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
						mysqli_query($connect, "INSERT INTO data(code, code_value, proof_code, data, block, qty, unit, price, date, debit, credit, token) VALUES('$code', '$code_description', '$proof_code', '$desc_data', '$block', '$qty', '$unit', '$price', '$date', '$debit', '$credit', '$id')");
					}else {
						array_push($errors, "Ref Code Not Found");
					}
				}
			}
		}
	}

	if(isset($_POST['_delete-data'])){
		$id_data = mysqli_real_escape_string($connect, $_POST['_id-data']);
		$validate_del_data	= mysqli_num_rows(mysqli_query($connect, "SELECT * FROM data WHERE token='$id' AND data_id='$id_data'"));
		$errors = array();
		if($validate_del_data == 1){
			mysqli_query($connect, "DELETE FROM data WHERE data_id='$id_data' AND token='$id'");
		}else {
			array_push($errors, "Something Went Wrong, Please Try Again");
		}
	}
	if(isset($_POST['_edit-data'])){
		$id_data 	= mysqli_real_escape_string($connect, $_POST['_id-data']);  
		header('Location: '.$URL.'/data/edit/auth/?id='.$id.'&uniqueid='.$uniqueid.'&data='.$id_data.'&url='.urlencode($url).'');
	}
	if(isset($_POST['_delete-project']) && isset($result_name)){
		header('Location:'.$URL.'/projects/delete/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}
	if(isset($_POST['_back-btn']) && isset($result_name)){
		header('Location:'.$URL.'');
	}
	if(isset($_POST['_show-data'])){
		unset($data_query);
	}
	if(isset($_POST['_add-code'])){
		$code 			= mysqli_real_escape_string($connect, $_POST['_code-data']);
		$description 	= mysqli_real_escape_string($connect, $_POST['_code-desc']);
		$validation 	= mysqli_num_rows(mysqli_query($connect, "SELECT * FROM code_data WHERE code='$code' AND token='$id'"));
		$errors			= array();
		if($validation == 1){ array_push($errors, "Code had Existed"); }
		else {
			$code = 
			mysqli_query($connect, "INSERT INTO code_data(code, description, token) VALUES('$code','$description','$id')");
		}
	}
	if(isset($_POST['_delete-code'])){
		$id_code			= mysqli_real_escape_string($connect, $_POST['_id']);
		$validate_del_id	= mysqli_num_rows(mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code_id='$id_code'"));
		$errors 			= array();
		if($validate_del_id == 1){
			mysqli_query($connect, "DELETE FROM code_data WHERE token='$id' AND code_id='$id_code'");
		}else {
			array_push($errors, "Something Went Wrong, Please Try Again");
		}
	}
	if(isset($_GET['order']) && isset($_GET['sort'])){
		$order = mysqli_real_escape_string($connect, $_GET['order']);
		$sort = mysqli_real_escape_string($connect, $_GET['sort']);
		if($order == "date"){ $order = "date"; }
		else if($order == "code_value"){ $order = "code_value"; }
		if($sort == "ASC"){ $sort = "ASC"; }
		else { $sort = "DESC"; }
		if(!empty($order) && !empty($sort)){
			$data_query = mysqli_query($connect, "SELECT * FROM data WHERE token='$id' ORDER BY $order $sort");
		}
	}
	if(isset($_POST['sort-date'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "date"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=date&sort=ASC"); }
					else { header('Location:'.$url_session."&order=date&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=date&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=date&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-name'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "code_value"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=code_value&sort=ASC"); }
					else { header('Location:'.$url_session."&order=code_value&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=code_value&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=code_value&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-proof'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "proof_code"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=proof_code&sort=ASC"); }
					else { header('Location:'.$url_session."&order=proof_code&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=proof_code&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=proof_code&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-desc'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "data"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=data&sort=ASC"); }
					else { header('Location:'.$url_session."&order=data&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=data&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=data&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-block'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "block"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=block&sort=ASC"); }
					else { header('Location:'.$url_session."&order=block&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=block&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=block&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-qty'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "qty"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=qty&sort=ASC"); }
					else { header('Location:'.$url_session."&order=qty&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=qty&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=qty&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-unit'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "unit"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=unit&sort=ASC"); }
					else { header('Location:'.$url_session."&order=unit&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=unit&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=unit&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-price'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "price"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=price&sort=ASC"); }
					else { header('Location:'.$url_session."&order=price&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=price&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=price&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-code'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "code"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=code&sort=ASC"); }
					else { header('Location:'.$url_session."&order=code&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=code&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=code&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-debit'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "debit"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=debit&sort=ASC"); }
					else { header('Location:'.$url_session."&order=debit&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=debit&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=debit&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['sort-credit'])){
		if(isset($_GET['order']) && isset($_GET['sort']) && isset($_COOKIE['url-session'])){
			$order 			= mysqli_real_escape_string($connect, urldecode($_GET['order']));
			$sort 			= mysqli_real_escape_string($connect, urldecode($_GET['sort']));
			$url_session 	= mysqli_real_escape_string($connect, urldecode($_COOKIE['url-session']));
			if(!empty($order) && !empty($sort) ){
				if($order == "credit"){
					if($sort == "DESC"){ header('Location:'.$url_session."&order=credit&sort=ASC"); }
					else { header('Location:'.$url_session."&order=credit&sort=DESC"); }
				}else {
					header('Location:'.$url_session."&order=credit&sort=ASC");
				}
			}
		}else {
			setcookie('url-session', $url, '/');
			$current_url = $url."&order=credit&sort=DESC";
			header('Location:'.$current_url);
		}
	}

	if(isset($_POST['type']) && isset($_POST['keywords']) && isset($_POST['search']) && isset($result_name)){
		$type		= mysqli_real_escape_string($connect, $_POST['type']);
		$keywords 	= mysqli_real_escape_string($connect, $_POST['keywords']);
		$search 	= mysqli_real_escape_string($connect, $_POST['search']);
		$errors		= array();
		if($keywords == "date"){ $types = "date"; }
		else if($keywords == "account"){ $types = "code_value"; }
		else if($keywords == "proof-code"){ $types = "proof_code"; }
		else if($keywords == "description"){ $types = "data"; }
		else if($keywords == "block"){ $types = "block"; }
		else if ($keywords == "qty"){ $types = "qty"; }
		else if ($keywords == "unit"){ $types = "unit"; }
		else if ($keywords == "price"){ $types = "price"; }
		else if ($keywords == "code"){ $types = "code"; }
		else if ($keywords == "date"){ $types = "date"; }
		else if ($keywords == "debit"){ $types = "debit"; }
		else if ($keywords == "credit"){ $types = "credit"; }
		else { array_push($errors, "Error in Displaying Value"); }
		if(count($errors) == 0){
			$data_query = mysqli_query($connect, "SELECT * FROM data WHERE token='$id' AND ".$types." like '%$search%' ");
		}
	};
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Projects | <?php echo $result_name?></title>
		<?php include('../../api/headers.php'); ?>
	</head>
	<body>
		<?php include('../../api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<form method="POST" class="btn-cta">
						<button type="submit" name="_back-btn" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-long-arrow-alt-left"></i>
						  	</div>
						  	<div class="btn-fa-text">
						  		Back
						  	</div>
						</button>
					</form>

					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#addData">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-plus-circle"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		New Data
					  	</div>
					</button>

					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#refCode">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-code-branch"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		Ref. Code
					  	</div>
					</button>

					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#searchData">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-search"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		Search
					  	</div>
					</button>
					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#infoData">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-info-circle"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		Information
					  	</div>
					</button>
					<form method="POST" class="btn-cta">
						<button type="submit" name="_delete-project" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: red;"class="fas fa-trash-alt"></i>
						  	</div>
						  	<div class="btn-fa-text">
						  		DELETE
						  	</div>
						</button>
					</form>
					<div class="modal fade" id="addData" tabindex="-1" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form method="POST">
					        	<p class="required">* required</p>
					        	<div class="form-group">
									<label for="Code">Code <span class="required">*</span></label>
									<input type="number" name="_code" class="form-control" placeholder="Input Data (max 5 digits)" max="99999" min="0" required>
								</div>
								<div class="form-group">
									<label for="description">Date <span class="required">*</span></label>
									<input type="date" name="_date" max="9999-12-31" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="description">Proof Code</label>
									<input type="text" name="_proof-code" class="form-control" maxlength="50" placeholder="Input Proof Code (max 50 chars)">
								</div>
								<div class="form-group">
									<label for="description">Description <span class="required">*</span></label>
									<input type="text" name="_desc-data" class="form-control" maxlength="100" placeholder="Input Data (max 100 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Block</label>
									<input type="text" name="_block" class="form-control" maxlength="10" placeholder="Input Block (max 10 digits)">
								</div>
								<div class="form-group">
									<label for="description">Quantity</label>
									<input type="number" name="_qty" class="form-control" max="9999999999" placeholder="Input Quantity (max 10 digits)">
								</div>
								<div class="form-group">
									<label for="description">Unit</label>
									<input type="text" name="_unit" class="form-control" maxlength="10" placeholder="Input Unit (max 10 chars)">
								</div>
								<div class="form-group">
									<label for="description">Price <span class="required">*</span></label>
									<input type="number" name="_price" class="form-control" max="99999999999999999999" placeholder="Input Price (max 20 digits)" required>
								</div>
								<div class="form-group">
									<label for="description">Debit <span class="required">*</span></label>
									<input type="number" name="_debit" class="form-control" max="99999999999999999999" placeholder="Input Debit (max 20 digits)" required>
								</div>
								<div class="form-group">
									<label for="description">Credit <span class="required">*</span></label>
									<input type="number" name="_credit" class="form-control" max="99999999999999999999" placeholder="Input Credit (max 20 digits)" required>
								</div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Discard</button>
					        <button type="submit" name="_create-data" class="btn btn-primary">Create</button>
					        </form>
					      </div>
					    </div>
					  </div>
					</div>

					<div class="modal fade" id="searchData" tabindex="-1" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Search Data</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form method="POST">
								<div class="input-group mb-3">
								  <input type="hidden" name="uniqueid" value="<?php echo $uniqueid?>">
								  <input type="hidden" name="id" value="<?php echo $id ?>">
								  <div class="input-group-prepend">
								    <span class="input-group-text" style="background-color: white;" id="basic-addon1"><i class="fas fa-search"></i></span>
								  </div>
								  <input type="text" name="search" class="form-control" placeholder="Search Keywords (max 30 chars)">
								</div>
								<p>Search By :</p>
								<div class="container row">
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="date" value="date">
										  <label class="form-check-label" for="date">
										    Date
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="acc" value="account">
										  <label class="form-check-label" for="acc">
										    Account Name
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="proof-code" value="proof-code">
										  <label class="form-check-label" for="proof-code">
										    Proof Code
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="desc" value="description" checked>
										  <label class="form-check-label" for="desc">
										    Description
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="block" value="block">
										  <label class="form-check-label" for="block">
										    Block
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="qty" value="qty">
										  <label class="form-check-label" for="qty">
										    Quantity
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="unit" value="unit">
										  <label class="form-check-label" for="unit">
										    Unit
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="price" value="price">
										  <label class="form-check-label" for="price">
										    Price
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="code" value="code">
										  <label class="form-check-label" for="code">
										    Code
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="debit" value="debit">
										  <label class="form-check-label" for="debit">
										    Debit
										  </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="keywords" id="credit" value="credit">
										  <label class="form-check-label" for="credit">
										    Credit
										  </label>
										</div>
									</div>
								</div>
					      </div>
					      <div class="modal-footer">
					        <input type="submit" name="type" value="Search" class="btn btn-primary"/>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>

					<div class="modal fade" id="refCode" tabindex="-1" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Code List</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form method="POST">
								<div class="input-group mb-3">
								  <input type="hidden" name="uniqueid" value="<?php echo $uniqueid?>">
								  <input type="hidden" name="id" value="<?php echo $id ?>">
								  <div class="input-group">
									  <div class="input-group-prepend">
									    <span class="input-group-text" style="background-color: white;" id="basic-addon1"><i class="fas fa-plus"></i></span>
									  </div>
									  <input type="number" name="_code-data" class="form-control" placeholder="Code (max 5 chars)" max="99999" autocomplete="off" required />
								  </div>

								  <div class="input-group input-form">
									  <div class="input-group-prepend">
									    <span class="input-group-text" style="background-color: white;" id="basic-addon1"><i class="fas fa-info"></i></span>
									  </div>
									  <input type="text" name="_code-desc" class="form-control" placeholder="Description (max 150 chars)" required />
								  </div>
								</div>
								<input type="submit" name="_add-code" value="Add Ref Code" class="btn btn-primary btn-full"/>
					        </form>
								<p>Code List</p>
								<div class="form-group table-responsive">
									<table class="table hover-mode">
										<thead>
											<tr>
												<th scope="col">Code</th>
												<th scope="col">Description</th>
												<th scope="col">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$code_query = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id'");
												$validation_code = mysqli_num_rows($code_query);
												if($validation_code > 0){
													while ($code_data = mysqli_fetch_assoc($code_query)){
														echo "<tr class=\"onhover\">
														<th scope=\"row\">".$code_data['code']."</th>
														<th>".$code_data['description']."</th>
														<th>
															<form method=\"POST\">
																<input name=\"_id\" type=\"hidden\" value=\"".$code_data['code_id']."\"/>
																<button type=\"submit\" class=\"btn-on-hover\" name=\"_delete-code\" onClick=\"javascript: return confirm('Are you Sure Want to Delete this Data?')\"><i class=\"fas fa-times\"></i></button>
															</form>
														</th></tr>";
													}
												}else {
													echo "<tr><th colspan=\"4\" scope=\"row\"><p class=\"project-null-msg italic\">No Code Data Found</p></th></tr>";
												}
											?>
										</tbody>
									</table>
								</div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>

				<div class="modal fade" id="infoData" tabindex="-1" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Information</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>Project Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $result_name?></p>
					        <p>Project Description : <?php echo $result_description?>
					        <p class="status">System Status &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp;
					        	<?php
					        		if($result_status == "All Good") {
					        			echo "<p class=\"status text-success font-weight-bold\">".$result_status."</p>";
					        		}else {
					        			echo "<p class=\"status text-danger font-weight-bold\">".$result_status."</p>";
					        		}
					        	?>
					        </p> 
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
				<div class="col-sm-12">
					<?php
						if(isset($errors)){ include('../../api/errors.php'); }
						if(isset($data_query)){
							if(isset($search)){
								echo "<h5>Search Result for ".$search." :</h5>\n
								<form method=\"POST\">
									<input name=\"_show-data\" type=\"submit\" value=\"Show all Data\" />";
							}
						}
					?>
					<div class="form-group table-responsive">
						<table class="table hover-mode">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">
										Date
										<form method="POST">
											<input type="hidden" name="_name" value="date">
											<input type="hidden" name="_sort" value="ASC">
											<button type="submit" name="sort-date" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">
										Account Name
										<form method="POST">
											<button type="submit" name="sort-name" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">
										Proof Code
										<form method="POST">
											<button type="submit" name="sort-proof" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Description
										<form method="POST">
											<button type="submit" name="sort-desc" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Block
										<form method="POST">
											<button type="submit" name="sort-block" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Qty
										<form method="POST">
											<button type="submit" name="sort-qty" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Unit
										<form method="POST">
											<button type="submit" name="sort-unit" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Price
										<form method="POST">
											<button type="submit" name="sort-price" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Code
										<form method="POST">
											<button type="submit" name="sort-code" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Debit
										<form method="POST">
											<button type="submit" name="sort-debit" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">Credit
										<form method="POST">
											<button type="submit" name="sort-credit" class="btn-cta"><i class="fas fa-sort-amount-down-alt"></i></button>
										</form>
									</th>
									<th scope="col">&nbsp;</th>
									<th scope="col">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(!isset($data_query)){
										$data_query = mysqli_query($connect, "SELECT * FROM data WHERE token='$id'");
									}
									$validation = mysqli_num_rows($data_query);
									$number = 1;
									if($validation != 0){
										while($data = mysqli_fetch_assoc($data_query)){
											echo "<tr class=\"onhover\"><th scope=\"row\">".$number++."</th><th>".$data['date']."</th><th>".$data['code_value']."</th><th>".$data['proof_code']."</th><th>".$data['data']."</th><th>".$data['block']."</th><th>".$data['qty']."</th><th>".$data['unit']."</th><th>".$data['price']."</th><th>".$data['code']."</th><th>".$data['debit']."</th><th>".$data['credit']."</th><th class=\"btn-on-hover\">
												<form method=\"POST\">
													<input type=\"hidden\" name=\"_id-data\" value=\"".$data['data_id']."\"/>
													<button type=\"submit\" name=\"_edit-data\" class=\"btn-on-hover\"><i class=\"fas fa-pencil-alt\"></i></button>
												</form></th><th class=\"btn-on-hover\">
												<form method=\"POST\">
													<input name=\"_id-data\" type=\"hidden\" value=\"".$data['data_id']."\"/>
													<button type=\"submit\" name=\"_delete-data\" onClick=\"javascript: return confirm('Are you Sure Want to Delete this Data?')\"class=\"btn-on-hover\"><i class=\"fas fa-times\"></i></button>
												</form></th></tr>";
										}
									}else {
										echo "
										<tr><th colspan=\"13\" scope=\"row\"><p class=\"project-null-msg italic\">No Data Found</p></th></tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php include('../../api/js.php'); ?>
	</body>
</html>