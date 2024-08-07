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
	$admin_dept_id = substr($row["dept_id"], 0, 2);

	$admin_name = $row["name"];

}

$course_code = isset($_POST['course_code']);


function getsubjectcode($dep_id, $course_code, $semester, $con)
{

	$query1 = "SELECT course_id FROM courses WHERE course_code = ?";
	$stmt = mysqli_prepare($con, $query1);
	mysqli_stmt_bind_param($stmt, "s", $course_code);
	mysqli_stmt_execute($stmt);
	$result1 = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result1);
	$course_id = $row["course_id"];

	// Check if there is any existing subjects code for the given combination
	$query = "SELECT subjects_code FROM subjects WHERE dept_id = ? AND course_code = ? AND semester = ? ORDER BY subjects_code DESC LIMIT 1";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'isi', $dep_id, $course_code, $semester);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

	if (mysqli_stmt_num_rows($stmt) > 0) {
		// If there is an existing subjects code, increment the last 2 digits by 1
		mysqli_stmt_bind_result($stmt, $last_subjects_code);
		mysqli_stmt_fetch($stmt);
		$last_digits = substr($last_subjects_code, -2);
		$next_digits = str_pad(intval($last_digits) + 1, 2, '0', STR_PAD_LEFT);
		$next_subjects_code = $dep_id . $course_id . $semester . $next_digits;
	} else {
		// If there is no existing subjects code, start from 01
		$next_subjects_code = $dep_id . $course_id . $semester . "01";
	}

	return $next_subjects_code;
}

if (isset($_POST['sub'])) {
	// Get form data
	// $action = $_POST['action'];
	$subjects_name_1 = $_POST['subjects_name_1'];
	$semester = $_POST['semester'];
	$course_code = $_POST['course_code'];
	$credit_1 = $_POST['credit_1'];
	$type_1 = $_POST['type_1'];
	// $course_code = isset($_GET['course_code']);

	// Function to generate the next subjects code


	// Generate the new subjects code
	$subjects_code = getsubjectcode($admin_dept_id, $course_code, $semester, $con);

	// Insert the new subject into the database
	$query = "INSERT INTO `subjects`(`subjects_code`, `subjects_name`, `dept_id`, `course_code`, `semester`, `credits`,`type`) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'ssssiis', $subjects_code, $subjects_name_1, $admin_dept_id, $course_code, $semester, $credit_1, $type_1);
	$run = mysqli_stmt_execute($stmt);

	if ($run) {
	} else {
		echo "Error: " . mysqli_error($con);
	}

	$count = 2;
	while (isset($_POST['subjects_name_' . $count]) && isset($_POST['credit_' . $count])) {
		$subjects_name = $_POST['subjects_name_' . $count];
		$credit = $_POST['credit_' . $count];
		$type = $_POST['type_' . $count];
		$subjects_code = getsubjectcode($admin_dept_id, $course_code, $semester, $con);

		// Insert the new subject into the database
		$query = "INSERT INTO `subjects`(`subjects_code`, `subjects_name`, `dept_id`, `course_code`, `semester`, `credits`,`type`) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($stmt, 'ssssiis', $subjects_code, $subjects_name, $admin_dept_id, $course_code, $semester, $credit, $type);
		$run = mysqli_stmt_execute($stmt);
		if ($run) {

		} else {
			echo "Error: " . $query . "<br>" . mysqli_error($con);
		}
		$count++;
	}
	echo '<script type="text/javascript">window.location.href = "courses.php";</script>';

	exit;
}
if (isset($_POST['upd-sub'])) {
	// Get form data
	// $action = $_POST['action'];
	$subjects_name_1 = $_POST['subjects_name_1'];
	$semester = $_POST['semester'];
	$subject_code = $_POST['subject_code'];
	$course_code = $_POST['course_code'];
	$credit_1 = $_POST['credit_1'];
	$type_1 = $_POST['type_1'];

	$query = "UPDATE `subjects` SET `subjects_name`='$subjects_name_1',`semester`='$semester',`credits`='$credit_1',`type`='$type_1' WHERE `subjects_code`='$subject_code'";
	$run = mysqli_query($con, $query);


	if ($run) {
		echo "<script>window.location.href='course_details.php?course_code=$course_code';</script>";
	} else {
		$err = mysqli_error($con);
		echo "<script>alert('Error :$err.');</script>";
		echo "<script>window.location.href='course_details.php?course_code=$course_code';</script>";
	}
	//echo '<script type="text/javascript">window.location.href = "courses.php";</script>';
	exit;
}
if (isset($_GET['del_sub_code'])) {
	$del_code = $_GET['del_sub_code'];
	$crs_code = $_GET['course_code'];
	$del_query = "DELETE FROM `subjects` WHERE subjects_code='$del_code'";
	$del_run = mysqli_query($con, $del_query);
	if ($del_run) {
		echo "<script>window.location.href='course_details.php?course_code=$crs_code';</script>";
	} else {
		$err = mysqli_error($con);
		echo "<script>alert('Error :$err.');</script>";
		echo "<script>window.location.href='course_details.php?course_code=$crs_code';</script>";
	}
}
?>
<!-- --------------------------------update subjectss------------------------------------- -->



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
			height: 50px;
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

		td.button {
			margin-top: 11px;
			display: inline-table;
		}
	</style>
	<style>
		.col-md-2 {
			display: flex;
			align-items: center;
			justify-content: center;
		}

		#add {
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #4CAF50;
			border-radius: 50%;
			width: 50px;
			height: 50px;
			color: white;
			font-size: 24px;
			cursor: pointer;
			transition: background-color 0.3s ease-in-out;
		}

		#add:hover {
			background-color: #3e8e41;
		}

		select.form-control {
			border-radius: 20px;
		}
	</style>
	<title>Admin - Register Teacher</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">

			<div class="p-0 rounded text-center">
				<h1>Subjects</h1>
			</div>
			<div class="container">
				<div class="modal-body">
					<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

					<script type="text/javascript">
						$(document).ready(function () {
							var count = 2; // start with 2 fields (subject_name, credit)

							// Add new subject name and credit fields when "Add More" button is clicked
							$("#add").click(function () {
								// var html = '<div class="form-group"><label for="subject_name_' + count + '">Subject Name:</label><input type="text" name="subject_name_' + count + '" class="form-control"><label for="credit_' + count + '">Credit:</label><input type="text" name="credit_' + count + '" class="form-control"></div>';
								var html = '<div class="row"><div class="col-md-4"><div class="form-group"><label for="exampleInputEmail1">Subject:</label><input type="text" name="subjects_name_' + count + '" class="form-control" required placeholder="Enter Subject"></div></div><div class="col-md-3"><div class="form-group"><label for="exampleInputEmail1">Credits: </label><input type="text" name="credit_' + count + '" class="form-control" required	placeholder="Enter Credits"></div></div><div class="col-md-3"><div class="form-group"><label for="exampleInputEmail1">Type: </label><select name="type_' + count + '" class="form-control" required><option> Select Subject Type</option><option value="T">Theory (T)</option><option value="P">Practical (P)</option></select></div></div></div>';
								$("#subject_fields").append(html); count++;
							});
						});
					</script>
					<?php
					// define a function to fetch data from the database
					// echo $course_code;
					
					if (isset($_GET['course_code'])) {
						$course_code = $_GET['course_code'];
						?>
						<form action="subjects.php" method="post">
							<div class="row mt-3">
								<div class="col-md-5">
									<div class="form-group">
										<input type="hidden" name="action" value="update">
										<label for="exampleInputEmail1">Course:</label>
										<input value="<?php echo $course_code; ?>" type="text" name="course_code"
											class="form-control" required placeholder="Enter course" readonly>
									</div>
								</div>
								<?php
								$sql = "SELECT `no_of_semester` FROM `courses` WHERE `course_code` = '$course_code'";
								$result = mysqli_query($con, $sql);
								$data = mysqli_fetch_assoc($result);
								$select_options = '';
								for ($i = 1; $i <= $data['no_of_semester']; $i++) {
									$select_options .= '<option value="' . $i . '">' . $i . '</option>';
								}
								?>


								<!-- Display the select input with generated options -->
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputPassword1">Select Semester:</label>
										<select name="semester" class="form-control" required>
											<?php echo $select_options; ?>
										</select>
									</div>
								</div>
							</div>
							<div id="subject_fields">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInputEmail1">Subject:</label>
											<input type="text" name="subjects_name_1" class="form-control" required
												placeholder="Enter Subject">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="exampleInputEmail1">Credits: </label>
											<input type="text" name="credit_1" class="form-control" required
												placeholder="Enter Credits">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="exampleInputEmail1">Type: </label>
											<select name="type_1" class="form-control" required>
												<option> Select Subject Type</option>
												<option value="T">Theory (T)</option>
												<option value="P">Practical (P)</option>
											</select>
										</div>
									</div>

									<div class="col-md-2 align-self-center">
										<div class="form-group">
											<button type="button" id="add" class="btn btn-primary btn-block">+</button>
										</div>
									</div>
								</div>
							</div>

							<div class="row w-100">
								<div class="col-md-12">
									<input type="submit" name="sub" value="Add" class="btn btn-primary ml-auto">
								</div>
							</div>
						</form>
					<?php } ?>
					<?php
					if (isset($_GET['subject_code'])) {
						$sub_code = $_GET['subject_code'];
						$sub_query = "SELECT * FROM subjects WHERE subjects_code='$sub_code'";
						$sub_run = mysqli_query($con, $sub_query);
						if ((mysqli_num_rows($sub_run)) > 0) {
							$sub_row = mysqli_fetch_array($sub_run);
							?>
							<form action="subjects.php" method="post">
								<div class="row mt-3">
									<div class="col-md-5">
										<div class="form-group">
											<input type="hidden" name="action" value="update">
											<label for="exampleInputEmail1">Subject Code:</label>
											<input value="<?php echo $sub_code; ?>" type="text" name="subject_code"
												class="form-control" readonly>
										</div>
									</div>
									<?php
									$course_code = $sub_row['course_code'];
									$sql = "SELECT `no_of_semester` FROM `courses` WHERE `course_code` = '$course_code'";
									$result = mysqli_query($con, $sql);
									$data = mysqli_fetch_assoc($result);
									$select_options = '';
									for ($i = 1; $i <= $data['no_of_semester']; $i++) {
										$select_options .= '<option value="' . $i . '">' . $i . '</option>';
									}
									?>


									<!-- Display the select input with generated options -->

									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInputPassword1">Select Semester:</label>
											<input type="hidden" name="course_code" value="<?php echo $course_code; ?>" />
											<select name="semester" class="form-control" required>
												<?php echo '<option value="' . $sub_row['semester'] . '"selected hidden>' . $sub_row['semester'] . '</option>';
												echo $select_options; ?>
											</select>
										</div>
									</div>
								</div>
								<div id="subject_fields">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="exampleInputEmail1">Subject:</label>
												<input type="text" name="subjects_name_1" class="form-control" required
													placeholder="Enter Subject" value="<?php echo $sub_row['subjects_name']; ?>">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="exampleInputEmail1">Credits: </label>
												<input type="text" name="credit_1" class="form-control" required
													placeholder="Enter Credits" value="<?php echo $sub_row['credits']; ?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="exampleInputEmail1">Type:</label>
												<select name="type_1" class="form-control" required>
													<option value="T" <?= $sub_row['type'] == 'T' ? 'selected' : '' ?>>Theory (T)
													</option>
													<option value="P" <?= $sub_row['type'] == 'P' ? 'selected' : '' ?>>Practical
														(P)</option>
												</select>
											</div>
										</div>

									</div>
								</div>

								<div class="row w-100">
									<div class="col-md-12">
										<input type="submit" name="upd-sub" value="Update" class="btn btn-primary ml-auto">
									</div>
								</div>
							</form>
							<?php
						} else {
							echo "NO DATA FOUND";
						}
					}
					?>

				</div>
			</div>
			<!-- </div> -->
		</div>

	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>