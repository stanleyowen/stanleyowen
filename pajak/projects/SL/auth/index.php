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
		if($search > 30){ array_push($errors, "Keywords too Long"); }
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

					<form class="btn-cta">
						<button type="button" class="btn-project btn-add" data-toggle="modal" data-target="#searchData">
							<div class="btn-fa-add">
						  		<i style="font-size: 48px; color: Dodgerblue;" class="fas fa-search"></i>
						  	</div>
						  	<div class="btn-fa-text text-wrap">
						  		Search
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
					<?php
						$query_get_data = mysqli_query($connect, "SELECT * FROM code_data WHERE token='$id'");
						$check_code = mysqli_num_rows(mysqli_query($connect, "SELECT code FROM data WHERE token='$id'"));
						if($check_code > 0){
							while ($get_data = mysqli_fetch_assoc($query_get_data)){
								echo '
								<div class="container row">
									<div class="col-sm-12 col-md-6">
										<p>Account Name : '.$get_data['description'].'</p>
									</div>
									<div class="col-sm-12 col-md-6">
										<p>Account Name : '.$get_data['code'].'</p>
									</div>
								</div>
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
											</tr>
										</thead>
									</table>
								</div>
								';
								$get_code = $get_data['code'];
								$query_from_code = mysqli_query($connect, "SELECT * FROM data WHERE token='$id' AND code='$get_code'");
								while ($get_data_from_code = mysqli_fetch_assoc($query_from_code)) {
									echo '
										
									';
								}
								echo '<hr class="divider"/>';
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
								</tr>
							</thead>
							<tbody>
								<?php
									if(!isset($data_query)){
										$data_query = mysqli_query($connect, "SELECT * FROM data WHERE token='$id'");
									}
									$validation = mysqli_num_rows($data_query);
									$number = 1;
									$total_qty = 0;
									$total_price = 0;
									$total_debit = 0;
									$total_credit = 0;
									if($validation != 0){
										while($data = mysqli_fetch_assoc($data_query)){
											echo "<tr class=\"onhover\"><th scope=\"row\">".$number++."</th><th>".$data['date']."</th><th>".$data['code_value']."</th><th>".$data['proof_code']."</th><th>".$data['data']."</th><th>".$data['block']."</th><th>".$data['qty']."</th><th>".$data['unit']."</th><th>".number_format($data['price'],0,',','.')."</th><th>".$data['code']."</th><th>".number_format($data['debit'],0,',','.')."</th><th>".number_format($data['credit'],0,',','.')."</th></tr>";
												$total_qty += $data['qty'];
												$total_price += $data['price'];
												$total_debit += $data['debit'];
												$total_credit += $data['credit'];
										}
										echo "<tr class=\"onhover\"><th colspan=\"6\" scope=\"row\">Total</th><th>".number_format($total_qty,0,',','.')."</th><th></th><th>".number_format($total_price,0,',','.')."</th><th></th><th>".number_format($total_debit,0,',','.')."</th><th>".number_format($total_credit,0,',','.')."</th><th colspan=\"2\"></th></tr>";
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
		<?php include('../../../api/js.php'); ?>
	</body>
</html>