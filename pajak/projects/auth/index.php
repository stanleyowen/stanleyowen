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
		$code 	= mysqli_real_escape_string($connect, $_POST['_code']);
		$data 	= mysqli_real_escape_string($connect, $_POST['_data']);
		$date 	= mysqli_real_escape_string($connect, $_POST['_date']);
		$errors = array();
		if(empty($code) || empty($data) || empty($date)){
			array_push($errors, "Make sure to fill out all the required forms");
		}else {
			if(is_numeric($code) != 1){
				array_push($errors, $code." is not an integer");
			}
			if(count($errors) == 0) {
				if(strlen($code) > 9){ array_push($errors, "Code is too long"); }
				if(strlen($data) > 150){ array_push($errors, "Data is too long"); }
				if(strlen($date) > 10){ array_push($errors, "Please Provide a Valid Date"); }
				if(count($errors) == 0) {
					$code_value = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code='$code'");
					$validate_code = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' AND code='$code'"));
					if($validate_code > 0){
						while ($get_value = mysqli_fetch_assoc($code_value)){
							$code_description = $get_value['description'];
						}
						mysqli_query($connect, "INSERT INTO data(code, code_value, data, date, token) VALUES('$code', '$code_description', '$data', '$date', '$id')");
					}else {
						array_push($errors, "Ref Code Not Found");
					}
				}
			}
		}
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
								<input type="text" name="_hidden-form" class="input-hidden">
								<div class="form-group">
									<label for="Code">Code <span class="required">*</span></label>
									<input type="number" name="_code" class="form-control" placeholder="Input Data (max 9 digits)" max="999999999" min="0" required>
								</div>
								<div class="form-group">
									<label for="description">Data <span class="required">*</span></label>
									<input type="text" name="_data" class="form-control" maxlength="150" placeholder="Input Data (max 150 chars)" required>
								</div>
								<div class="form-group">
									<label for="description">Date <span class="required">*</span></label>
									<input type="date" name="_date" max="9999-99-99" class="form-control" maxlength="10" required>
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
														$message = 'Are you Sure Want to Delete this Data?';
														echo "<tr>
														<th scope=\"row\">".$code_data['code']."</th>
														<th>".$code_data['description']."</th>
														<th>
															<form method=\"POST\">
																<input name=\"_id\" type=\"hidden\" value=\"".$code_data['code_id']."\"/>
																<input type=\"submit\" class=\"btn-on-hover\" name=\"_delete-code\" onClick=\"javascript: return confirm('$message')\" value=\"X\"/>
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
									<th scope="col">Code</th>
									<th scope="col">Code Description</th>
									<th scope="col">Description</th>
									<th scope="col">Date</th>
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
											echo "<tr><th scope=\"row\">".$number++."</th><th>".$data['code']."</th><th>".$data['code_value']."</th><th>".$data['data']."</th><th>".$data['date']."</th></tr>";
										}
									}else {
										echo "
										<tr><th colspan=\"5\" scope=\"row\"><p class=\"project-null-msg italic\">No Data Found</p></th></tr>";
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
