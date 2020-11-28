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
				header("Content-type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename=".$result_name.".xls");
			}else {
				header('Location: '.$URL.'/errors/404/');
			}
		}else {
			header('Location: '.$URL.'/errors/403/');
		}
	}else {
		header('Location: '.$URL.'/errors/400/');
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Projects | <?php echo $result_name?></title>
		<?php include('../../api/headers.php'); ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
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
											echo "<tr class=\"onhover\"><th scope=\"row\">".$number++."</th><th>".$data['date']."</th><th>".$data['code_value']."</th><th>".$data['proof_code']."</th><th>".$data['data']."</th><th>".$data['block']."</th><th>".$data['qty']."</th><th>".$data['unit']."</th><th>".number_format($data['price'],0,',','.')."</th><th>".$data['code']."</th><th>".number_format($data['debit'],0,',','.')."</th><th>".number_format($data['credit'],0,',','.')."</th><th class=\"btn-on-hover\"></tr>";
												$total_qty += $data['qty'];
												$total_price += $data['price'];
												$total_debit += $data['debit'];
												$total_credit += $data['credit'];
										}
										echo "<tr class=\"onhover\"><th colspan=\"6\" scope=\"row\">Total</th><th>".number_format($total_qty,0,',','.')."</th><th></th><th>".number_format($total_price,0,',','.')."</th><th></th><th>".number_format($total_debit,0,',','.')."</th><th>".number_format($total_credit,0,',','.')."</th><th colspan=\"2\"></th></tr>";
									}else {
										echo "
										<tr><th colspan=\"11\" scope=\"row\"><p class=\"project-null-msg italic\">No Data Found</p></th></tr>";
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