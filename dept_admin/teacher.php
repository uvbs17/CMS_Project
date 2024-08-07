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

	$query = "SELECT * FROM admin_info
		WHERE user_id = '$userid'
		AND password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$admin_dept_id = $row["dept_id"];

}

?>
<!---------------- Session Ends form here ------------------------>

<!--*********************** PHP code starts from here for data insertion into database ******************************* -->
<?php 
if (isset($_POST['btn_save2'])) {
	$teacher_id = $_POST['teacher_code'];
	$sub_id = $_POST['subjects_code'];
	$s_query = "UPDATE `teacher_info` SET `teaching_subject`='$sub_id' WHERE `teacher_code`='$teacher_id'";
	$s_run =mysqli_query($con ,$s_query);
	if($s_run)
	{
		// echo "<script>alert('Subject assigned sucessfully.');</script>";
		echo "<script>window.location.href='Teacher.php';</script>";
	}
	else
	{
		echo "<script>alert('There was an error in processing your request.');</script>";
		echo "<script>window.location.href='Teacher.php';</script>";
	}
}
if (isset($_POST['btn_save'])) {

	function getTeacherCode($con, $dept_id)
	{
		$stmt = mysqli_prepare($con, "SELECT teacher_code FROM teacher_info WHERE dept_id = ? ORDER BY teacher_code DESC LIMIT 1");
		if (!$stmt) {
			die(mysqli_error($con));
		}
		mysqli_stmt_bind_param($stmt, 'i', $dept_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);

		if (mysqli_stmt_num_rows($stmt) > 0) {
			mysqli_stmt_bind_result($stmt, $last_teacher_code);
			mysqli_stmt_fetch($stmt);
			if ($last_teacher_code !== null) {
				$last_digits = substr($last_teacher_code, -3);
				$next_digits = str_pad(intval($last_digits) + 1, 3, '0', STR_PAD_LEFT);
				$next_teacher_code = $dept_id . $next_digits;
			} else {
				$next_teacher_code = $dept_id . "001";
			}
		} else {
			$next_teacher_code = $dept_id . "001";
		}

		mysqli_stmt_close($stmt);
		return $next_teacher_code;
	}

	function sanitizeInput($input) 
	{
		return htmlspecialchars(stripslashes(trim($input))); 
	}

	//Sanitize and validate user input
	$first_name = sanitizeInput($_POST["first_name"]);
	$middle_name = sanitizeInput($_POST["middle_name"]);
	$last_name = sanitizeInput($_POST["last_name"]);
	$email = filter_var(sanitizeInput($_POST["email"]), FILTER_VALIDATE_EMAIL);
	$phone_no = sanitizeInput($_POST["phone_no"]);
	$teacher_status = sanitizeInput($_POST["teacher_status"]);
	$aadhar = sanitizeInput($_POST["aadhar"]);
	$dob = sanitizeInput($_POST["dob"]);
	$other_phone = sanitizeInput($_POST["other_phone"]);
	$gender = sanitizeInput($_POST["gender"]);
	$permanent_address = sanitizeInput($_POST["permanent_address"]);
	$place_of_birth = sanitizeInput($_POST["place_of_birth"]);
	// $password = sanitizeInput($_POST['password']);
	$default_password = 'teacher123';

	//Insert data into teacher_info table
	$current_date = date('Y-m-d');
	$teacher_code = getTeacherCode($con, $admin_dept_id);
	// $profile_image = $_FILES['profile_image']['name'];
	// $tmp_name = $_FILES['profile_image']['tmp_name'];
	// $path = "CMS/faculty/images/" . $profile_image;
	// move_uploaded_file($tmp_name, $path);

	$query = "INSERT INTO `teacher_info`(`id`, `teacher_code`, `user_id`, `password`, `first_name`, `middle_name`, `last_name`, `email`, `phone_no`, 
	`dept_id`, `profile_image`, `teacher_status`, `aadhar_no`, `dob`, `other_phone`, `gender`, `permanent_address`, `place_of_birth`, 
	`hire_date`, `teaching_subject`, `teaching_level`, `education_level`, `experience`, `contract_start_date`, `contract_end_date`, `salary`, 
	`emergency_contact_name`, `emergency_contact_phone`, `emergency_contact_relationship`, `teaching_schedule`, `classroom_resources`, `notes`) 
	VALUES (NULL,'$teacher_code','$email','$default_password','$first_name','$middle_name','$last_name','$email','$phone_no','$admin_dept_id',NULL,'$teacher_status','$aadhar',
	'$dob','$other_phone','$gender','$permanent_address','$place_of_birth',$current_date,'',NULL,NULL,NULL,NULL,
	NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)";
	$run = mysqli_query($con, $query);
	if($run)
	{
		echo "<script>alert('Teacher Added.');</script>";
		echo "<script>window.location.href='Teacher.php';</script>";
	}
	else
	{
		echo "<script>alert('There was an error inserting your record.');</script>";
		echo "<script>window.location.href='Teacher.php';</script>";

	}		
	
	
}
?>



<?php
if (isset($_POST['btn_save2'])) {
	$course_code = $_POST['course_code'];

	$semester = $_POST['semester'];

	$teacher_code=$_POST['teacher_code'];

	$subject_code = $_POST['subject_code'];

	$total_classes = $_POST['total_classes'];

	$date = date("d-m-y");

	$query3 = "insert into teacher_courses(course_code,semester,teacher_code
,subject_code,assign_date,total_classes)values('$course_code','$semester','$teacher_code
','$subject_code','$date','$total_classes')";
	$run3 = mysqli_query($con, $query3);
	if ($run3) {
		echo "Your Data has been submitted";
	} else {
		echo "Your Data has not been submitted";
	}
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

		button.btn.btn-primary {
			position: absolute;
			left: 40%;
			top: 10%;
			border-radius: 20px;
		}

		button.btn.btn-primary.ml-5 {
			position: absolute;
			left: -20%;
			top: 10%;
			border-radius: 20px;
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

			button.btn.btn-primary.ml-5 {
				position: relative;
				top: -10%;
				left: -94%;
				width: 300px;
			}

			button.btn.btn-primary {
				position: relative;
				top: 2px;
				left: -250px;
				width: 300px;
			}

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

		.btn {
			border: 0;
		}

		.btn-primary {
			border: 0;
			background-color: #1f5b6e;
		}

		div.btn.btn-block.text-white.table-two.d-flex {
			background-color: #245e71;
		}

		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
			<div class="p-0 mt-4 rounded text-center">
				<h1>Teacher Management System</h1>
			</div>
			<div class="row w-100">
				<div class=" col-lg-6 col-md-6 col-sm-12 mt-1 ">
					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
						aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header bg-info text-white">
									<h4 class="modal-title text-center">Add New Teacher</h4>
								</div>
								<div class="modal-body">
									<form action="Teacher.php" method="post" enctype="multipart/form-data">
										<div class="row mt-3">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">First Name: </label>
													<input type="text" name="first_name" class="form-control" required
														placeholder="First Name">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Middle Name: </label>
													<input type="text" name="middle_name" class="form-control" required
														placeholder="Middle Name">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Last Name: </label>
													<input type="text" name="last_name" class="form-control" required
														placeholder="Last Name">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Teacher Email:</label>
													<input type="text" name="email" class="form-control" required
														placeholder="Enter Email">
												</div>
											</div>
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Mobile No</label>
													<input type="number" name="phone_no" class="form-control"
														placeholder="Enter Mobile Number">
												</div>
											</div>
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Other Phone:</label>
													<input type="number" name="other_phone" class="form-control" placeholder="Other Phone No">
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Teacher Status: </label>
													<select class="browser-default custom-select" name="teacher_status"
														id="statusSelect">
														<option value="" selected disabled>Select Status</option>
														<option value="Permanent">Permanent</option>
														<option value="Contract">Contract</option>
													</select>

												</div>
											</div>
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Aadhar No:</label>
													<input type="text" name="aadhar" class="form-control" required
														placeholder="Aadhar No">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Date of Birth: </label>
													<input type="date" name="dob" required class="form-control">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Select Your Profile </label>
													<input type="file" name="profile_image" 
														class="form-control">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Permanent Address: </label>
													<input type="text" name="permanent_address" 
													class="form-control" placeholder="Enter Permanent Address">
												</div>
											</div>
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Current Address:</label>
													<input type="text" name="salary" 
														class="form-control" placeholder="Enter Current Address">
												</div>
											</div>
										</div>
										<div class="row">
										
											<div class="col-md-4">
												<div class="formp">
													<label for="exampleInputPassword1">Place of Birth:</label>
													<input type="text" name="place_of_birth" required
														class="form-control" placeholder="Enter Place of Birth">
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
			<div class="row w-100">
				<div class="col-md-12 ml-2">
					<section class="mt-3">
						<div class="row">
							<div class="col-md-3 offset-9 pt-5 mb-2">
								<!-- Large modal -->

								<button type="button" class="btn btn-primary ml-5" data-toggle="modal"
									data-target=".bd-example-modal-lg">Add Teacher</button>
								<button type="button" class="btn btn-primary" data-toggle="modal"
									data-target=".bd-example-modal-lg1">Assign Subjects</button>

								<div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog"
									aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header bg-info text-white">
												<h4 class="modal-title text-center">Assign Subjects To Teachers</h4>
											</div>
											<div class="modal-body">
												<form action="" method="POST" enctype="multipart/form-data">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="exampleInputPassword1">Enter Teacher Code:*</label>
																<select class="browser-default custom-select"
																	name="teacher_code" required="">
																	<option>Select Teacher</option>
																	<?php
																	$query = "SELECT * FROM teacher_info where dept_id='$admin_dept_id' AND teaching_subject IS NULL OR teaching_subject = ''";
																	$run = mysqli_query($con, $query);
																	while ($row = mysqli_fetch_array($run)) {
																		echo "<option value=".$row['teacher_code'].">" .$row['first_name']. " ". $row['last_name'] . "(" .$row['teacher_code'].")" . "</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="exampleInputPassword1">Please Select
																	Subject:*</label>
																<select class="browser-default custom-select"
																	name="subjects_code" required="">
																	<option>Select Subject</option>
																	<?php
																	$query = "SELECT * FROM subjects
																	WHERE subjects_code NOT IN (SELECT teaching_subject FROM teacher_info) AND dept_id= '$admin_dept_id'";
																	$run = mysqli_query($con, $query);
																	while ($row = mysqli_fetch_array($run)) {
																		echo "<option value=" . $row['subjects_code'] . ">"."[". $row['subjects_code']."] ". $row['subjects_name']." (". $row['course_code'].")". "</option>";
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="submit" class="btn btn-primary" name="btn_save2">
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
						<div class="table-responsive-md">
							<table id="teacher-table"
								   class="w-100 table-dark container table-striped table-hover table-elements table-one-tr">
								<thead class="thead-dark">
									<tr class="table-tr-head table-three text-white">
										<th style="border-radius: 20px 0 0 0;">Teacher ID</th>
										<th>Teacher Name</th>
										<th>Hire Date</th>
										<th>Subject</th>
										<th>Email</th>
										<th style="border-radius: 0 20px 0 0;">Operations</th>
									</tr>
								</thead>
								<?php
								$query = "SELECT * FROM teacher_info AS t 
								LEFT JOIN subjects AS s ON t.teaching_subject = s.subjects_code 
								WHERE t.dept_id = '$admin_dept_id'";
								$run = mysqli_query($con, $query);
								while ($row = mysqli_fetch_array($run)) {
									echo "<tr>";
									echo "<td>" . $row["teacher_code"] . "</td>";
									echo "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";
									echo "<td>" . date("j F, Y", strtotime($row["hire_date"])) . "</td>";
									echo "<td>" . $row["subjects_name"] . "</td>";
									echo "<td>" . $row["email"] . "</td>";
									echo "<td width='170'><a class='btn btn-primary' href=display-teacher.php?profile=" . $row['teacher_code'] . ">Profile</a> <a class='btn btn-danger' href=delete-function.php?teacher_code=" . $row['teacher_code'] . ">Delete</a></td>";
									echo "</tr>";
								}
								?>
							</table>
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