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
	$admin_dept_id = $row["dept_id"];
	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}
?>
<!---------------- Session Ends form here ------------------------>
<?php
if(isset($_GET['enrollment_no']))
{
	$enro = $_GET['enrollment_no'];
	$query0 = "SELECT * FROM student_info AS s INNER JOIN courses AS c ON s.course_code = c.course_code 
	WHERE s.enrollment_no=$enro";
	$result = mysqli_query($con, $query0);
	if($result)
	{
		$row = mysqli_fetch_array($result);
		$amount = $row['fees_per_sem'];
		$sem = $row['current_semester'];
		$query1 = "UPDATE student_info SET fees_status='paid' WHERE enrollment_no = '$enro';
				INSERT INTO `student_fee`(`fee_voucher`, `enrollment_no`,`paid_sem`, `amount`, `posting_date`, `status`) 
				VALUES (NULL,'$enro','$sem','$amount',CURRENT_TIMESTAMP,'paid')";

		if (mysqli_multi_query($con, $query1)) {
			echo "<script>alert ('Successfully Paid $enro');</script>";
			echo "<script>window.location.href='Student-fee.php';</script>";
		} else {
			echo "<script>alert ('error in Paying $enro');</script>";
		}

		
	}
	else
	{
		echo "<script>alert ('$enro');</script>";
	}
}
if(isset($_GET['fee_voucher']))
{
	$voucher = $_GET['fee_voucher'];
	$query = "SELECT * FROM student_fee as f INNER JOIN student_info AS s on f.enrollment_no = s.enrollment_no  WHERE fee_voucher = '$voucher'";
	$result = mysqli_query($con, $query);
	if($result)
	{
		$row = mysqli_fetch_array($result);
		$enro = $row['enrollment_no'];
		$query1 = "UPDATE student_info SET fees_status='unpaid' WHERE enrollment_no = '$enro';
					DELETE FROM `student_fee` WHERE fee_voucher='$voucher'";
		if (mysqli_multi_query($con, $query1)) {
			echo "<script>alert ('Successfully Deleted $enro');</script>";
			echo "<script>window.location.href='Student-fee.php';</script>";

		} else {
			echo "<script>alert ('error in deleting $enro');</script>";
		}
	}
	else
	{
		echo "<script>alert ('error');</script>";
	}
}
?>


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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
		div.modal-header.bg-info.text-white {
			border-radius: 20px;
			margin: 10;
		}

		table {
			border-radius: 30px;
			text-align: center;
		}

		a.btn.btn-primary {
			border-radius: 20px 0 0 20px;
		}

		a.btn.btn-danger {
			border-radius: 0 20px 20px 0;
		}

		@media only screen and (max-width: 767px) {
			a.btn.btn-primary {
				border-radius: 20px;
				margin: 2px;
			}

			a.btn.btn-danger {
				border-radius: 20px;
				margin: 2px;
			}


			button.btn.btn-primary.ml-auto {
				width: 100%;
				margin-bottom: 4px;
			}

			a.btn.btn-success {
				width: 100%;
				margin-bottom: 4px;
			}

			button.btn.btn-primary.stdadd {
				width: 100%;
				margin-bottom: 4px;
			}

		}
		input.btn.attan.text-white {
			position: absolute;
			right: 20px;
			top: -30px;
		}

		a.btn.btn-success {
			border-radius: 30px;
		}

		button.btn.btn-primary.ml-auto {
			border-radius: 30px;
		}

		button.btn.btn-primary.stdadd {
			border-radius: 30px;
		}

		.btn {
			border: 0;
		}

		.btn-primary {
			border: 0;
		}

		td {
			height: 45px;
			text-align: center;
		}

		thead tr th {
			height: 45px;
			background-color: darkslategrey;
			color: white;
			text-align: center;
		}

		div.btn.btn-block.table-one.text-white.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.text-white.table-three.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.text-white.table-two.d-flex {
			background-color: #245e71;
		}

		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		div.modal-content {
			border-radius: 30px;
		}

		select.browser-default.custom-select {
			border-radius: 20px;
		}


		input.form-control {
			border-radius: 20px;
		}

		input.btn.btn-primary {
			border-radius: 20px;
		}

		button.btn.btn-secondary {
			border-radius: 20px;
		}

		/* Pagination styles */
		.pagination {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 20px;
		}

		.pagination li {
			display: inline-block;
			margin: 0 5px;
		}

		.pagination li a {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 30px;
			border-radius: 5px;
			color: #333;
			background-color: #fff;
			border: 1px solid #ccc;
			text-decoration: none;
			font-size: 14px;
			font-weight: bold;
			transition: background-color 0.2s ease;
			padding: 5px 10px;
		}

		.pagination li.active a,
		.pagination li a:hover {
			background-color: #007bff;
			border-color: #007bff;
			color: #fff;
		}

		.pagination li.disabled a {
			background-color: #ccc;
			border-color: #ccc;
			color: #666;
			pointer-events: none;
		}

		.material-icons {
			font-family: 'Material Icons';
			font-weight: normal;
			font-style: normal;
			font-size: 18px;
			line-height: 1;
			text-transform: none;
			letter-spacing: normal;
			word-wrap: normal;
			white-space: nowrap;
			direction: ltr;
		}

	</style>
		<title>Admin - Exam Fee</title>
		<!-- css style go to end here -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
		<?php include('../common/admin-sidebar.php') ?>	
		<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
			<div class="sub-main">
				<div class="p-0 mt-4 rounded text-center">
					<h1>Exam Fee Management System</h1>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form action="exam-fee.php" method="post">
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group">
									<label for="exampleInputEmail1">Fees Status:</label>
										<div class="d-flex">
											<select class="browser-default custom-select" name="fees_stat" required="">
												<option value="" >Select</option>
												<option value="paid">Paid</option>
												<option value="unpaid">Unpaid</option>
											</select>
											<input type="submit" name="submit" class="btn btn-primary px-4 ml-4" value="Seacrh">
										</div>
									</div>
								</div>
								<div class="col-md-6 align-items-baseline pt-4">
								</div>
							</div>
						</form>
						<script>
							const selectElement = document.querySelector('select[name="fees_stat"]');
							
							selectElement.addEventListener('change', () => {
							  // Get the form element
							  const form = document.querySelector('form');
							  
							  // Submit the form
							  form.submit();
							});
							
						</script>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 ml-2 table-responsive-md">
						<section class="mt-3">
							<table style="margin-left: 0 ; margin-right:0;"
								class="w-100  table-dark container table-striped table-hover table-elements table-one-tr "
								cellpadding="10">
								<?php
								$rows_per_page = 10;
								if (isset($_GET['page'])) {
									$page = intval($_GET['page']);
								} else {
									$page = 1;
								}
								$sr = ($page - 1) * $rows_per_page + 1;
								$status = "unpaid";
								if (isset($_POST['submit'])) 
								{
									$status = $_POST['fees_stat'];

								}

								if($status == 'paid')
								{
								?>
									<thead class="thead-dark">
										<tr class="table-tr-head table-three text-white">
											<th style="border-radius: 20px 0 0 0;">Sr.No</th>
											<th>Enrollment No.:</th>
											<th>Student Name</th>
											<th>Semester</th>
											<th>Course</th>
											<th>Fees Reciept No.</th>
											<th>Date</th>
											<th>Amount</th>
											<th colspan="2" style="border-radius: 0 20px 0 0;">Action</th>
										</tr>
									</thead>
									<?php  
									$query = "SELECT * FROM student_fee AS f INNER JOIN student_info AS s ON f.enrollment_no = s.enrollment_no  
									WHERE s.dept_id=$admin_dept_id LIMIT " . ($page - 1) * $rows_per_page . ",$rows_per_page";
									$run = mysqli_query($con, $query);
									if($run)
									{
										while ($row = mysqli_fetch_array($run)) 
										{
											echo "<tr>";
												echo "<td>" . $sr++ . "</td>";
												echo "<td>" . $row['enrollment_no'] . "</td>";
												echo "<td>" . $row['first_name'] . "</td>";
												echo "<td>" . $row['paid_sem'] . "</td>";
												echo "<td>" . $row['course_code'] . "</td>";
												echo "<td>" . $row['fee_voucher'] . "</td>"; 
												echo "<td>" . date('d-m-Y' , strtotime($row['posting_date'])) . "</td>"; 
												echo "<td>" . $row['amount'] . "</td>"; ?>
												<td width='175'>
													<a style=" border-radius: 20px;" class="btn btn-danger" href="Student-fee.php?fee_voucher=<?= $row['fee_voucher'] ?>">Delete</a>
												<?php echo "</tr>";
										}
									}
									else{
										echo "<tr><td colspan='6' style='text-align: center;'>No Data found.</td></tr>";
									}
								}
								else
								{
								?>
									<thead class="thead-dark">
									<tr class="table-tr-head table-three text-white">
										<th style="border-radius: 20px 0 0 0;">Sr.No</th>
										<th>Enrollment No.:</th>
										<th>Student Name</th>
										<th>Semester/Years</th>
										<th>Course</th>
										<!-- <th>Exam Type</th> -->
										<th>Fees status</th>
										<th>Amount</th>
										<th colspan="2" style="border-radius: 0 20px 0 0;">Action</th>
									</tr>
									</thead>
									<?php  
									$query = "SELECT * FROM student_info AS s INNER JOIN courses AS c ON s.course_code = c.course_code 
									WHERE s.dept_id=$admin_dept_id AND s.exam_fee_status='unpaid' LIMIT " . ($page - 1) * $rows_per_page . ",$rows_per_page";
									$run = mysqli_query($con, $query);
									while ($row = mysqli_fetch_array($run)) {
										
											echo "<tr>";
											echo "<td>" . $sr++ . "</td>";
											echo "<td>" . $row['enrollment_no'] . "</td>";
											echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
											echo "<td>" . $row['course_code'] . "</td>";
											echo "<td>" . $row['current_semester'] . "</td>";
											echo "<td>" . $row['fees_status'] . "</td>"; 
											echo "<td>" . $row['fees_per_sem'] . "</td>"; ?>
											<td width='175'>
												<a style=" border-radius: 20px;" class="btn btn-primary mr-1" 
												href="Student-fee.php?enrollment_no=<?= $row['enrollment_no'] ?>">Paid</a>
											<?php echo "</tr>";
									}
								}

								if (isset($_GET['page'])) {
									$current_page = $_GET['page'];
								} else {
									$current_page = 1;
								}
								$total_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM student_info WHERE dept_id=$admin_dept_id"));
								$total_pages = ceil($total_rows / $rows_per_page);

								?>
							</table>

							<?php if ($total_pages > 1) { ?>
								<nav aria-label="Page navigation example">
									<ul class="pagination justify-content-center mt-3">
										<li class="page-item <?php echo ($current_page == 1 ? 'disabled' : ''); ?>">
											<a class="page-link"
												href="<?php echo ($current_page === 1 ? '#' : '?page=' . ($current_page - 1)); ?>"
												tabindex="-1">
												<i class="material-icons">chevron_left</i> Previous
											</a>
										</li>
										<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
											<li class="page-item <?php echo ($current_page == $i ? 'active' : ''); ?>">
												<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
											</li>
										<?php } ?>
										<li class="page-item <?php echo ($current_page == $total_pages ? 'disabled' : ''); ?>">
											<a class="page-link"
												href="<?php echo ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1)); ?>">
												Next <i class="material-icons">chevron_right</i>
											</a>
										</li>
									</ul>
								</nav>
							<?php } ?>

						</section>
					</div>
				</div>
			</div>
		</main>
		<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>