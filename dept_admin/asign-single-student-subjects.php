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

<?php
$message = "";
$success_message = "";
$error_message = "";
if (isset($_POST['sub'])) {
	$count = $_POST['count'];
	for ($i = 0; $i < $count; $i++) {
		$date = date("d-m-y");
		$que = "insert into student_courses(course_code,semester,roll_no,subject_code,assign_date)values('" . $_POST['course_code'][$i] . "','" . $_POST['semester'][$i] . "','" . $_POST['roll_no'][$i] . "','" . $_POST['subject_code'][$i] . "','$date')";
		$run = mysqli_query($con, $que);
		if ($run) {
			$success_message = "All Subjects Successfully Assigned To The Student";
		} else {
			$error_message = "All Subjects Not Successfully Assigned To The Student";
		}
	}
}

?>


<!-- title of this page -->




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

		thead tr th {
			height: 45px;
			background-color: darkslategrey;
			color: white;
			text-align: center;
		}

		input.form-control {
			border-radius: 30px;
		}

		select.browser-default.custom-select {
			border-radius: 30px;
		}

		div.btn.btn-block.table-one.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.table-three.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.table-two.d-flex {
			background-color: #245e71;
		}

		input.btn {
			border-radius: 30px;
		}

		input.btn.attan.text-white {
			position: absolute;
			right: 20px;
			top: -30px;
		}


		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}
	</style>
	<title>Admin - Assign Subject To Student</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Assign Subject to Single Student </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<?php
						if ($success_message == true) {
							$bg_color = "alert-success";
							$message = $success_message;
						} else if ($error_message == true) {
							$bg_color = "alert-danger";
							$message = $error_message;
						}
						?>
						<h5 class="py-2 pl-3 <?php echo $bg_color; ?>">

							<?php echo $message ?>
						</h5>
					</div>
					<form action="asign-single-student-subjects.php" method="post">
						<div class="row mt-3">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Select Course:</label>
									<select class="browser-default custom-select" name="course_code">
										<option>Select Course</option>
										<?php
										$query = "select distinct(course_code) as course_code from course_subjects";
										$run = mysqli_query($con, $query);
										while ($row = mysqli_fetch_array($run)) {
											echo "<option value=" . $row['course_code'] . ">" . $row['course_code'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Enter Student ID:</label>
									<input type="text" name="roll_no" class="form-control" placeholder="Enter ID">
								</div>
							</div>
							<div class="col-md-4">
								<input type="submit" name="submit" class="btn btn-primary px-5" value="Press">
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ml-2">
					<section class="mt-3">
						<table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="5">
							<thead class="thead-dark">
								<tr class="table-tr-head text-white table-three">
									<th style="border-radius: 20px 0 0 0;">Sr.No</th>
									<th>Roll No</th>
									<th>Course Code</th>
									<th>Subject Code</th>
									<th>Subject Name</th>
									<th style="border-radius: 0 20px 0 0;">Semester</th>
								</tr>
							</thead>
							<?php
							$i = 1;
							$count = 0;
							if (isset($_POST['submit'])) {
								$course_code = $_POST['course_code'];
								$roll_no = $_POST['roll_no'];
								$que = "select * from course_subjects where course_subjects.course_code='$course_code'";
								$run = mysqli_query($con, $que);
								while ($row = mysqli_fetch_array($run)) {
									$count++;
							?>
									<form action="asign-single-student-subjects.php" method="post">
										<tr>
											<td>
												<?php echo $i++ ?>
											</td>
											<td>
												<?php echo $_POST['roll_no'] ?>
											</td>
											<input type="hidden" name="roll_no[]" value=<?php echo $_POST['roll_no'] ?>>
											<td>
												<?php echo $row['course_code'] ?>
											</td>
											<input type="hidden" name="course_code[]" value=<?php echo $row['course_code'] ?>>
											<td>
												<?php echo $row['subject_code'] ?>
											</td>
											<input type="hidden" name="subject_code[]" value=<?php echo $row['subject_code'] ?>>
											<td>
												<?php echo $row['subject_name'] ?>
											</td>
											<td>
												<?php echo $row['semester'] ?>
											</td>
											<input type="hidden" name="semester[]" value=<?php echo $row['semester'] ?>>
											<input type="hidden" name="count" value="<?php echo $count ?>">
										</tr>
								<?php
								}
							}
								?>
								<input type="submit" name="sub" class="btn btn-primary attan text-white" value="Submit">

									</form>
						</table>
					</section>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>