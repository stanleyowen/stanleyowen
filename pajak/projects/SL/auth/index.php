<?php
	include('../../../api/index.php');
	include('../../../api/auth.php');

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

	if(isset($_POST['_delete-project']) && isset($result_name)){
		header('Location:'.$URL.'/projects/delete/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}
	if(isset($_POST['_export'])){
		header('Location:');
	}
	if(isset($_POST['_back-btn']) && isset($result_name)){
		header('Location:'.$URL.'/projects/auth/?id='.$id.'&uniqueid='.$uniqueid.'');
	}
	if(isset($_POST['_show-data'])){
		unset($data_query);
	}
	if(isset($_POST['_edit-balance'])){
		$id_data = mysqli_real_escape_string($connect, $_POST['_id-data']);
		header('Location:'.$URL.'/projects/SL/edit/auth/?id='.$id.'&uniqueid='.$uniqueid.'&ids='.$id_data.'');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Projects | <?php echo $result_name?></title>
		<?php include('../../../api/headers.php'); ?>
	</head>
	<body>
		<?php include('../../../api/navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<form method="POST" class="btn-cta">
						<button type="submit" name="_back-btn" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;" class="fas fa-long-arrow-alt-left"></i>
						  	</div>
						  	<div class="btn-fa-text text-wrap">
						  		Back
						  	</div>
						</button>
					</form>

					<form class="btn-cta">
						<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#refCode">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;" class="fas fa-code-branch"></i>
						  	</div>
						  	<div class="btn-fa-text text-wrap">
						  		Ref. Code
						  	</div>
						</button>
					</form>

					<form method="POST" class="btn-cta">
						<button type="submit" name="_export" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;" class="fas fa-file-export"></i>
						  	</div>
						  	<div class="btn-fa-text text-wrap">
						  		Export to Excel
						  	</div>
						</button>
					</form>

					<form method="POST" class="btn-cta">
						<button type="submit" name="_delete-project" class="btn-project btn-add">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: red;"class="fas fa-trash-alt"></i>
						  	</div>
						  	<div class="btn-fa-text text-wrap">
						  		DELETE
						  	</div>
						</button>
					</form>
					
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
								  <input type="text" name="search" class="form-control" placeholder="Search Keywords (max 30 chars)" maxlength="30">
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
							<div class="form-group table-responsive">
								<table class="table hover-mode">
									<thead>
										<tr>
											<th scope="col">Code</th>
											<th scope="col">Description</th>
											<th scope="col">Balance</th>
											<th scope="col">&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$code_query = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' ORDER BY code ASC");
											$validation_code = mysqli_num_rows($code_query);
											if($validation_code > 0){
												while ($code_data = mysqli_fetch_assoc($code_query)){
													echo "<tr class=\"onhover\"><th scope=\"row\">".$code_data['code']."</th><th>".$code_data['description']."</th>
														<th>".number_format($code_data['bgn_balance'],0,',','.')."</th><th class=\"btn-on-hover\">
															<form method=\"POST\">
																<input name=\"_id-data\" type=\"hidden\" value=\"".$code_data['code_id']."\"/>
																<button type=\"submit\" class=\"btn-cta\" name=\"_edit-balance\"><i class=\"fas fa-pencil-alt\"></i></button>
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
					<hr class="divider">
					<?php
						$query_get_data = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id' ORDER BY code ASC");
						$check_code = mysqli_num_rows(mysqli_query($connect, "SELECT code FROM data WHERE token='$id'"));
						if($check_code > 0){
							while ($get_data = mysqli_fetch_assoc($query_get_data)){
								echo '
								<div class="container row">
									<div class="col-sm-12 col-md-6">
										<p style="font-weight:bold;">Account Name : '.$get_data['description'].'</p>
									</div>
									<div class="col-sm-12 col-md-6">
										<p style="font-weight:bold;">Account Code : '.$get_data['code'].'</p>
									</div>
								</div>
								<div class="form-group table-responsive">
									<table class="table hover-mode">
										<thead>
											<tr>
												<th scope="col">No</th>
												<th scope="col">Date</th>
												<th scope="col">Proof Code</th>
												<th scope="col">Description</th>
												<th scope="col">Block</th>
												<th scope="col">Qty</th>
												<th scope="col">Unit</th>
												<th scope="col">Price</th>
												<th scope="col">Debit</th>
												<th scope="col">Credit</th>
												<th scope="col">Balance</th>
												<th scope="col">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
										<tr class="onhover"><th scope="row" colspan="3"></th><th>Beginning Balance</th><th colspan="6"></th><th>'.number_format($get_data['bgn_balance'],0,',','.').'</th><th class="btn-on-hover">
												<form method="POST">
													<input type="hidden" name="_id-data" value="'.$get_data['code_id'].'"/>
													<button type="submit" name="_edit-balance" class="btn-cta"><i class="fas fa-pencil-alt"></i></button>
												</form></th>
								';
								$get_code = $get_data['code'];
								if(!isset($balance)){ $balance = $get_data['bgn_balance']; }
								$number 	= 1;
								$query_from_code = mysqli_query($connect, "SELECT * FROM data WHERE token='$id' AND code='$get_code' ORDER BY date ASC");
								$check_data_exist = mysqli_num_rows($query_from_code);
								if($check_data_exist > 0){
									while ($get_data_from_code = mysqli_fetch_assoc($query_from_code)) {
										if($get_data_from_code['qty'] == 0){ $price = 0; }
										else { $price = ($get_data_from_code['debit']+$get_data_from_code['credit'])/$get_data_from_code['qty']; }
										echo "
											<tr><th scope=\"row\">".$number++."</th><th>".$get_data_from_code['date']."</th><th>".$get_data_from_code['proof_code']."</th><th>".$get_data_from_code['data']."</th><th>".$get_data_from_code['block']."</th><th>".$get_data_from_code['qty']."</th><th>".$get_data_from_code['unit']."</th><th>".number_format($price,0,',','.')."</th><th>".number_format($get_data_from_code['debit'],0,',','.')."</th><th>".number_format($get_data_from_code['credit'],0,',','.')."</th><th>".number_format($balance + $get_data_from_code['debit'] - $get_data_from_code['credit'],0,',','.')."</th></tr>
										";
										$balance = $balance + $get_data_from_code['debit'] - $get_data_from_code['credit'];
										mysqli_query($connect, "UPDATE code_data SET end_balance='$balance' WHERE token='$id' AND code='$get_code'");
									}
								}else {
									echo "<tr><th scope=\"row\" colspan=\"12\"<p class=\"project-null-msg italic\">No Data Found</p></th></tr>";
								}
								echo '</tbody></table></div><hr class="divider">';
								unset($balance);
							}
						}
					?>
					
				</div>
			</div>
		</div>
		<?php include('../../../api/js.php'); ?>
	</body>
</html>