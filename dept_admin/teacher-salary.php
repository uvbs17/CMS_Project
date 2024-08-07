<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!isset($_SESSION["Logininfo"])) {
	echo '<script type="text/javascript">window.location.href = "index.php";</script>';
} else {
	$userid = $_SESSION['Logininfo']['user_id'];
	$password = $_SESSION['Logininfo']['password'];

	$query = "SELECT *
		FROM department AS d
		INNER JOIN admin_info AS a
		ON a.dept_id = d.dept_id
		WHERE a.user_id = '$userid'
		AND a.password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);



	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<!---------------- Session Ends form here ------------------------>

<!--*********************** PHP code starts from here for data insertion into database ******************************* -->
<?php

if (isset($_POST['btn_save'])) {

	$teacher_code = $_POST['teacher_code'];

	$basic_salary = $_POST["basic_salary"];

	$medical_allowance = $_POST["medical_allowance"];

	$hr_allowance = $_POST["hr_allowance"];

	$scale = $_POST["scale"];

	$query = "INSERT INTO `teacher_salary_allowances`(`teacher_code`, `basic_salary`, `medical_allowance`, `hr_allowance`, `scale`) VALUES ('$teacher_code','$basic_salary','$medical_allowance','$hr_allowance','$scale')";
	$run = mysqli_query($con, $query);
	if ($run) {
		echo "Your Data has been submitted";
	} else {
		echo "Your Data has not been submitted";
	}
}



if (isset($_POST['btn_sub'])) {

	$teacher_code = $_POST['teacher_code'];
	$date = date("d/m/Y");
	$query = "SELECT * FROM teacher_salary_allowances WHERE teacher_code='$teacher_code'";
	$run = mysqli_query($con, $query);
	if(mysqli_num_rows($run) > 0) {
		while ($row = mysqli_fetch_array($run)) {
			$total_amount = $row['basic_salary'] + ($row['basic_salary'] * $row['medical_allowance'] / 100) + ($row['basic_salary'] * $row['hr_allowance'] / 100);
			$query1 = "INSERT INTO teacher_salary_report(`salary_id`,`teacher_code`, `total_amount`, `status`, `paid_date`) VALUES (NULL ,'$teacher_code','$total_amount','Paid', NOW())";
			$run1 = mysqli_query($con, $query1);

			if ($run1) { ?>
				<script type="text/javascript">
					alert("Salary has been paid to I'd is : " + <?php echo $row['teacher_code'] ?>);
				</script>
			<?php } else { ?>
				<script type="text/javascript">
					alert("Salary has not been paid due to some errors");
				</script>
			<?php }
		}
	} else { ?>
		<script type="text/javascript">
			alert("Teacher code not found in database");
		</script>
	<?php }
}
 ?>
<!--*********************** PHP code end from here for data insertion into database ******************************* -->


<!doctype html>


<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" sizes="32x32" href="/CMS/Images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/CMS/Images/fav.png">

	<!-- css style goes here -->

	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<style>
		td {
			height: 45px;
			text-align: center;
		}

		select.browser-default.custom-select {
			border-radius: 30px;
		}

		.btn {
			border: 0;
			border-radius: 30px;
		}

		.btn-primary {
			border: 0;
		}

		thead tr th {
			height: 45px;
			background-color: darkslategrey;
			text-align: center;
		}

		div.btn.btn-block.table-one.text-white.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.text-white.table-three.d-flex {
			background-color: #245e71;
		}

		div.modal-header.bg-info.text-white {
			margin: 10px;
			border-radius: 20px;
		}

		div.modal-content {
			border-radius: 30px;
		}

		div.btn.btn-block.text-white.table-two.d-flex {
			background-color: #245e71;
		}

		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			margin-bottom: 20px;
		}

		input.btn.btn-primary.ml-auto {
			border-radius: 30px;
			background-color: #1f5b6e;
		}

		input.form-control {
			border-radius: 30px;
		}

		a.btn.btn-danger {
			border-radius: 20px;
		}
	</style>
	<title>Admin - Teacher Salary</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Teacher Salary Management System </h1>

			</div>
			<div class="row">
				<div class="col-md-12 ml-2">
					<section class=" mt-3">
						<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-3 ml-5 ">
								<div class="col-md-12 pt-3 ml-5">
									<!-- Large modal -->
									<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
										aria-labelledby="myLargeModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header bg-info text-white">
													<h4 class="modal-title text-center">Add Salary</h4>
												</div>
												<div class="modal-body">
													<form action="" method="POST">
														<div class="row mt-3">
															<div class="col-md-6 pr-5">
																<div class="form-group">
																	<label for="exampleInputEmail1">Teacher I'd:
																	</label>
																	<input type="text" name="teacher_code"
																		class="form-control"
																		placeholder="Enter Teacher Id">
																</div>
															</div>
															<div class="col-md-6 pr-5">
																<div class="form-group">
																	<label for="exampleInputEmail1">Basic
																		Salary:</label>
																	<input type="text" name="basic_salary"
																		class="form-control"
																		placeholder="Enter Basic Salary">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="exampleInputEmail1">Medical
																		Allowance: </label>
																	<input type="text" name="medical_allowance"
																		class="form-control"
																		placeholder="Enter Medical Allowance">
																</div>
															</div>
															<div class="col-md-6">
																<div class="formp">
																	<label for="exampleInputEmail1">House Rent
																		Allowance: </label>
																	<input type="text" name="hr_allowance"
																		class="form-control"
																		placeholder="Enter HR Allowance">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="formp">
																	<label for="exampleInputEmail1">Paid Scale:
																	</label>
																	<input type="text" name="scale" class="form-control"
																		placeholder="Enter Paid Scale">
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn btn-primary" name="btn_save"
																value="Save Data">
															<button type="button" class="btn btn-secondary"
																data-dismiss="modal">Close</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-3 ml-5 ">
								<div class="col-md-12 pt-3 ml-5">
									<!-- Large modal -->
									<div class="modal fade add_salary" tabindex="-1" role="dialog"
										aria-labelledby="myLargeModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header bg-info text-white">
													<h4 class="modal-title text-center">Add Salary</h4>
												</div>
												<div class="modal-body">
													<form action="" method="POST">
														<div class="row mt-3">
															<div class="col-md-12 pr-5">
																<div class="form-group">
																	<label for="exampleInputEmail1">Teacher I'd:
																	</label>
																	<input type="text" name="teacher_code"
																		class="form-control"
																		placeholder="Enter Teacher Id">
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn btn-primary" name="btn_sub"
																value="Save Data">
															<button type="button" class="btn btn-secondary"
																data-dismiss="modal">Close</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table style="margin-left: 0 ;margin-right:0;"
									class="w-100  table-dark container table-striped table-hover table-elements table-one-tr		"
									cellpadding="10">
									<thead class="thead-dark">
										<tr class="table-tr-head table-three text-white">
											<th colspan="9" style="border-radius: 20px 20px 0 0;">
												<h2>All Teachers Salary Report
													<button style=" margin-left: 450px;" type="button"
														class="btn btn-primary" data-toggle="modal"
														data-target=".bd-example-modal-lg">Add Salary Scale</button>
													<button type="button" class="btn btn-primary" data-toggle="modal"
														data-target=".add_salary">Add Salary</button>

												</h2>
											</th>
										</tr>
										<tr class="table-tr-head">
											<th>Salary Voucher</th>
											<th>I'd</th>
											<th>Name</th>
											<th>Basic Salary</th>
											<th>Medical Allowance</th>
											<th>HR Allowance</th>
											<th>Pay Scale</th>
											<th>Paid Date</th>
											<th>Total Amount</th>
										</tr>
									</thead>
									<?php
									$query = "SELECT tsr.teacher_code, ti.first_name, ti.middle_name, ti.last_name, salary_id, basic_salary, medical_allowance, hr_allowance, scale, paid_date AS paid_date, total_amount 
									FROM teacher_salary_allowances tsa 
									INNER JOIN teacher_salary_report tsr ON tsa.teacher_code = tsr.teacher_code 
									INNER JOIN teacher_info ti ON ti.teacher_code = tsr.teacher_code";
									$run = mysqli_query($con, $query);
									while ($row = mysqli_fetch_array($run)) { ?>
										<tr>
											<td>
												<?php echo $row['salary_id'] ?>
											</td>
											<td>
												<?php echo $row['teacher_code'] ?>
											</td>
											<td>
												<?php echo $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] ?>
											</td>
											<td>
												<?php echo $row['basic_salary'] ?>
											</td>
											<td>
												<?php echo ($row['basic_salary'] * $row['medical_allowance'] / 100) ?>
											</td>
											<td>
												<?php echo ($row['basic_salary'] * $row['hr_allowance'] / 100) ?>
											</td>
											<td>
												<?php echo $row['scale'] ?>
											</td>
											<td>
												<?php echo $row['paid_date'] ?>
											</td>
											<td>
												<?php echo $row['total_amount'] ?>
											</td>
										</tr>
										<?php
									}
									?>
								</table>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>