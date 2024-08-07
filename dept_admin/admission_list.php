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
	$admin_dept_id = $row ["dept_id"];
	$admin_name = $row ["name"];
	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
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

		thead {
			height: 35px;
			/* border-radius: 20px; */
			/* background-color: #2F4F4F; */
			/* color: white; */
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
	</style>
	<title>Admin - Application List</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<!-- <?php include('../common/admin-sidebar.php') ?> -->
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Admission Management System</h1>
			</div>
			<div class="row w-100">
				<div class="col-md-12 ml-2">
					<section class="mt-3">
						<div class="table-wrapper">
							<form method="post" action="viewprofile.php">

								<input type="text" class="form-control mb-3" id="search-input" placeholder="Search">
								<table style="margin-bottom: 10px;"
									class="w-200 table-dark container table-striped table-hover table-elements table-one-tr"
									cellpadding="5">
									<thead>
										<tr>
											<th><input type="checkbox" id="select-all"></th>
											<th>Sr.No</th>
											<th>Application No</th>
											<th>Name</th>
											<!-- <th>Gender</th> -->
											<!-- <th>DOB</th> -->
											<th style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
												Email</th>
											<th>Contact No</th>
											<th>Aadhar No</th>
											<!-- <th>SSC Board</th> -->
											<th>SSC Result</th>
											<!-- <th>HSC Board</th> -->
											<th>HSC Result</th>
											<th>Course</th>
											<th>Fees Status</th>
											<th>Operations</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$stmt = $con->prepare("SELECT * FROM admission_form WHERE form_status NOT IN ('rejected', 'accepted') AND dept_id = '$admin_dept_id'");
										$stmt->execute();
										$result = $stmt->get_result();
										$i = 1;
										while ($row = $result->fetch_assoc()){
											$course = $row["course"];
											$form_id = $row["form_id"];
											// if($admin_dept_id == $dept_id)
											// ?>
											<tr>
												<td><input type="checkbox" class="form-select"></td>
												<td><?php  echo $i; $i++; ?></td>
												<td><a href="viewprofile.php?form_id=<?php echo $row['form_id']; ?>"><?php echo $row['form_id']; ?></a></td>
												<td>
													<?php echo $row['first_name'] . " " . $row['last_name']; ?>
												</td>
												<!-- <td><?php //echo $row['gender']; ?></td> -->
												<!-- <td><?php echo $row['dob']; ?></td> -->
												<td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
													<?php echo $row['email']; ?>
												</td>
												<td>
													<?php echo $row['mobile_no']; ?>
												</td>
												<td><a href="/cms/Admission_form/<?php echo $row['aadhar_path']; ?>"><?php echo $row['aadhar_no']; ?></a></td>
												<!-- <td><?php echo $row['ssc_board']; ?></td> -->
												<td><a href="/cms/Admission_form/<?php echo $row['ssc_result_path']; ?>"><?php echo $row['ssc_percentage']; ?></a></td>
												<!-- <td><?php echo $row['hsc_board']; ?></td> -->
												<td><a href="/cms/Admission_form/<?php echo $row['hsc_result_path']; ?>"><?php echo $row['hsc_percentage']; ?></a></td>
												<td>
													<?php echo $row['course']; ?>
												</td>
												<td>
													<?php echo $row['fees_status']; ?>
												</td>
												<td>
													<div class="d-flex">
														<a class="btn btn-primary mr-1"
															href="admission_accept.php?accept_id=<?php echo $form_id; ?>">Accept</a>
														<a class="btn btn-danger mr-1" onClick="getReason()">Reject</a>
													</div>
												</td>
												<script>
													function getReason() {
														var reason = prompt("Please enter reason for rejection:");
														if (reason != null && reason != "") {
															window.location.href = 'update-function.php?reject_id=<?php echo $form_id ?>&reason=' + reason;
														}
													}
												</script>
												

											</tr>
										<?php } ?>
									</tbody>
								</table>

								<script>
									document.addEventListener("DOMContentLoaded", function () {
										var searchBox = document.getElementById("search-input");
										var rows = document.querySelectorAll("tbody tr");

										searchBox.addEventListener("keyup", function () {
											var query = this.value.trim().toLowerCase();

											rows.forEach(function (row) {
												var name = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
												var application = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
												var shouldShow = name.indexOf(query) > -1 || application.indexOf(query) > -1;
												row.style.display = shouldShow ? "" : "none";
											});
										});
									});
								</script>
							</form>
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