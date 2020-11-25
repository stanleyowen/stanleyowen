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
				$code_php = '
					<div class="container mt-20">
						<h2>Edit Projects</h2>
						<form method="POST">
						  <div class="form-group">
						    <label for="project_name">Project Name :</label>
						    <input type="text" name="_confirm-pjname" class="form-control" placeholder="Project Name (Max 30 Characters)" value="'.$result_name.'" autocomplete="off" autocapitalize="none" autofocus>
						  </div>
						  <div class="form-group">
						  	<label for="description">Desciption</label>
							<textarea class="form-control" name="_confirm-pjdesc" id="description" rows="3" maxlength="100" placeholder="Project Description (Max 100 Characters)">'.$result_description.'</textarea>
						  </div>
						  <button name="_confirm" type="submit" class="btn btn-full btn-outline-primary">UPDATE</button><br/>
						  <button name="_discard" type="submit" class="btn btn-full btn-outline-danger">DISCARD</button>
						</form>
					</div>
				';
			}else {
				$code_php = '<div class="mt-20"><h1>404 - NOT FOUND</h1></div>';
			}
		}else {
			$code_php = '<div class="mt-20"><h1>403 - FORBIDDEN</h1></div>';
		}
	}else {
		$code_php = '<div class="mt-20"><h1>400 - BAD REQUEST</h1></div>';
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
			if(is_numeric($qty) != 1){ array_push($errors, $qty." is not an integer");			}
			if(is_numeric($price) != 1){ array_push($errors, $price." is not an integer");			}
			if(is_numeric($debit) != 1){ array_push($errors, $debit." is not an integer");			}
			if(is_numeric($credit) != 1){ array_push($errors, $credit." is not an integer");			}
			if(count($errors) == 0) {
				if($code > 99999){ array_push($errors, "Code is too long"); }
				if(strlen($proof_code) > 25) { array_push($errors, "Proof Code is too long"); }
				if(strlen($desc_data) > 100){ array_push($errors, "Description is too long"); }
				if(strlen($block) > 10) { array_push($errors, "Block is too long"); }
				if($qty > 9999999999) { array_push($errors, "Quantity is too long"); }
				if(strlen($unit) > 25) { array_push($errors, "Unit is too long"); }
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
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){ $url = "https://";  }
        else { $url = "http://"; }   
    	$url.= $_SERVER['HTTP_HOST']; 
    	$url.= $_SERVER['REQUEST_URI'];    
		header('Location: '.$URL.'/data/edit/auth/?id='.$id.'&uniqueid='.$uniqueid.'&data='.$id_data.'&url='.urlencode($url).'');
	}
	if(isset($_POST['_delete-project']) && isset($result_name)){
		header('Location:'.$URL.'/projects/delete/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}
	if(isset($_POST['_back-btn']) && isset($result_name)){
		header('Location:'.$URL.'');
	}
	if(isset($_POST['type']) && isset($_POST['keywords']) && isset($_POST['search']) && isset($result_name)){
		$type		= mysqli_real_escape_string($connect, $_POST['type']);
		$keywords 	= mysqli_real_escape_string($connect, $_POST['keywords']);
		$search 	= mysqli_real_escape_string($connect, $_POST['search']);
		$errors		= array();
		if($keywords == "all"){
			$types = "data";
		}else if ($keywords == "code"){
			$types = "code";
		}else if ($keywords == "date"){
			$types = "date";
		}else {
			array_push($errors, "Error in Displaying Value");
		}
		if(count($errors) == 0){
			$data_query = mysqli_query($connect, "SELECT * FROM data WHERE token='$id' AND ".$types." like '%$search%' ");
		}
		
	};
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
					<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#sortData">
						<div class="btn-fa-add">
					  		<i style="font-size: 48px; color: Dodgerblue;"class="fas fa-sort-amount-up"></i>
					  	</div>
					  	<div class="btn-fa-text">
					  		Sort
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
									<input type="text" name="_desc-data" class="form-control" maxlength="150" placeholder="Input Data (max 150 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Block</label>
									<input type="text" name="_block" class="form-control" maxlength="10" placeholder="Input Block (max 10 chars)">
								</div>
								<div class="form-group">
									<label for="description">Quantity</label>
									<input type="number" name="_qty" class="form-control" maxlength="10" placeholder="Input Quantity (max 10 chars)">
								</div>
								<div class="form-group">
									<label for="description">Unit</label>
									<input type="text" name="_unit" class="form-control" maxlength="10" placeholder="Input Unit (max 10 chars)">
								</div>
								<div class="form-group">
									<label for="description">Price <span class="required">*</span></label>
									<input type="number" name="_price" class="form-control" maxlength="20" placeholder="Input Price (max 20 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Debit <span class="required">*</span></label>
									<input type="number" name="_debit" class="form-control" maxlength="20" placeholder="Input Debit (max 20 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Credit <span class="required">*</span></label>
									<input type="number" name="_credit" class="form-control" maxlength="20" placeholder="Input Credit (max 20 chars)" required>
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
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="keywords" id="all-keywords" value="all" checked>
								  <label class="form-check-label" for="all-keywords">
								    All Possible Keywords
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="keywords" id="code-keyword" value="code">
								  <label class="form-check-label" for="code-keyword">
								    Code
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="keywords" id="date-keyword" value="date">
								  <label class="form-check-label" for="date-keyword">
								    Date
								  </label>
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
										<tbody class="onhover">
											<?php
												$code_query = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id'");
												$validation_code = mysqli_num_rows($code_query);
												if($validation_code > 0){
													while ($code_data = mysqli_fetch_assoc($code_query)){
														echo "<tr>
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

					<div class="modal fade" id="sortData" tabindex="-1" aria-hidden="true">
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
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="keywords" id="1" value="all" checked>
								  <label class="form-check-label" for="1">
								    All Possible Keywords
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="keywords" id="2" value="code">
								  <label class="form-check-label" for="2">
								    Code
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="keywords" id="3" value="date">
								  <label class="form-check-label" for="3">
								    Date
								  </label>
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
					        </form>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
				<?php
					if(isset($errors)){ include('../../api/errors.php'); }
					if(isset($data_query)){
						echo "<h5>Search Result for ".$search." :</h5>\n
						<form method=\"POST\">
							<input name=\"_show-data\" type=\"submit\" value=\"Show all Data\" />";
					}
				?>
				<div class="col-sm-12">
					<div class="form-group table-responsive">
						<table class="table hover-mode">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Date</th>
									<th scope="col">Account Name</th>
									<th scope="col">Proof Code</th>
									<th scope="col">Description</th>
									<th scope="col">Block</th>
									<th scope="col">Qty</th>
									<th scope="col">Unit</th>
									<th scope="col">Price</th>
									<th scope="col">Code</th>
									<th scope="col">Debit</th>
									<th scope="col">Credit</th>
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
													<input name=\"_id-data\" type=\"hidden\" value=\"".$data['data_id']."\"/>
													<button type=\"submit\" name=\"_delete-data\" onClick=\"javascript: return confirm('Are you Sure Want to Delete this Data?')\"class=\"btn-on-hover\"><i class=\"fas fa-times\"></i></button>
												</form>
												<form method=\"POST\">
													<input type=\"hidden\" name=\"_id-data\" value=\"".$data['data_id']."\"/>
													<button type=\"submit\" name=\"_edit-data\" class=\"btn-on-hover\"><i class=\"fas fa-pencil-alt\"></i></button>
												</form>";
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
