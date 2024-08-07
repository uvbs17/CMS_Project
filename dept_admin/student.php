<?php include('../common/header.php') ?>
<?php
// session_start();
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




	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}
$std = 'current';
if(isset($_POST['std']))
{
	$std = $_POST['std'];
}

?>
<!---------------- Session Ends form here ------------------------>


<!--*********************** PHP code starts from here for data insertion into database ******************************* -->
<?php
if (isset($_POST['btn_save'])) {

	$roll_no = $_POST["roll_no"];

	$first_name = $_POST["first_name"];

	$middle_name = $_POST["middle_name"];

	$last_name = $_POST["last_name"];

	$father_name = $_POST["father_name"];

	$email = $_POST["email"];

	$mobile_no = $_POST["mobile_no"];

	$course_code = $_POST['course_code'];

	$session = $_POST['session'];

	$prospectus_issued = $_POST["prospectus_issued"];

	$prospectus_amount = $_POST["prospectus_amount"];

	$form_b = $_POST["form_b"];

	$applicant_status = $_POST["applicant_status"];

	$application_status = $_POST["application_status"];

	$cnic = $_POST["cnic"];

	$dob = $_POST["dob"];

	$gender = $_POST["gender"];

	$permanent_address = $_POST["permanent_address"];

	$current_address = $_POST["current_address"];

	$place_of_birth = $_POST["place_of_birth"];

	$matric_complition_date = $_POST["matric_complition_date"];

	$matric_awarded_date = $_POST["matric_awarded_date"];

	$fa_complition_date = $_POST["fa_complition_date"];

	$fa_awarded_date = $_POST["fa_awarded_date"];

	$ba_complition_date = $_POST["ba_complition_date"];

	$ba_awarded_date = $_POST["ba_awarded_date"];

	$password = $_POST['password'];

	$role = $_POST['role'];



	// *****************************************Images upload code starts here********************************************************** 
	$profile_image = $_FILES['profile_image']['name'];
	$tmp_name = $_FILES['profile_image']['tmp_name'];
	$path = "images/" . $profile_image;
	move_uploaded_file($tmp_name, $path);

	$matric_certificate = $_FILES['matric_certificate']['name'];
	$tmp_name = $_FILES['matric_certificate']['tmp_name'];
	$path = "images/" . $matric_certificate;
	move_uploaded_file($tmp_name, $path);

	$fa_certificate = $_FILES['fa_certificate']['name'];
	$tmp_name = $_FILES['fa_certificate']['tmp_name'];
	$path = "images/" . $fa_certificate;
	move_uploaded_file($tmp_name, $path);

	$ba_certificate = $_FILES['ba_certificate']['name'];
	$tmp_name = $_FILES['ba_certificate']['tmp_name'];
	$path = "images/" . $ba_certificate;
	move_uploaded_file($tmp_name, $path);


	// *****************************************Images upload code end here********************************************************** 

	$query = "Insert into student_info(roll_no,first_name,middle_name,last_name,father_name,email,mobile_no,course_code,session,profile_image,prospectus_issued,prospectus_amount,form_b,applicant_status,application_status,cnic,dob,gender,permanent_address,current_address,place_of_birth,matric_complition_date,matric_awarded_date,matric_certificate,fa_complition_date,fa_awarded_date,fa_certificate,ba_complition_date,ba_awarded_date,ba_certificate)values('$roll_no','$first_name','$middle_name','$last_name','$father_name','$email','$mobile_no','$course_code','$session','$profile_image','$prospectus_issued','$prospectus_amount','$form_b','$applicant_status','$application_status','$cnic','$dob','$gender','$permanent_address','$current_address','$place_of_birth','$matric_complition_date','$matric_awarded_date','$matric_certificate','$fa_complition_date','$fa_awarded_date','$fa_certificate','$ba_complition_date','$ba_awarded_date','$ba_certificate')";
	$run = mysqli_query($con, $query);
	if ($run) {
		echo "Your Data has been submitted";
	} else {
		echo "Your Data has not been submitted";
	}
	$query2 = "insert into login(user_id,Password,Role)values('$roll_no','$password','$role')";
	$run2 = mysqli_query($con, $query2);
	if ($run2) {
		echo "Your Data has been submitted into login";
	} else {
		echo "Your Data has not been submitted into login";
	}
}
?>


<?php
if (isset($_POST['btn_save2'])) {
	$course_code = $_POST['course_code'];

	$semester = $_POST['semester'];

	$roll_no = $_POST['roll_no'];

	$subject_code = $_POST['subject_code'];

	$date = date("d-m-y");

	$query3 = "insert into student_courses(course_code,semester,roll_no,subject_code,assign_date)values('$course_code','$semester','$roll_no','$subject_code','$date')";
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
	<title>Admin - Register Student</title>
	<!-- css style go to end here -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Student Management System</h1>
			</div>
			<div class="row">
                <div class="col-md-12">
                    <form id="filter" action="Student.php" method="post">
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select:</label>
                                    <div class="d-flex">
                                        <select class="browser-default custom-select" name="std" required="" id="std_select">
                                            <option value="" hidden>Select Semester</option>
                                            <option value="current">Current Student</option>
                                            <option value="left">Left Student</option>
                                        </select>
                                        <script>
                                            const select = document.getElementById("std_select");
                                            select.addEventListener("change", function () {
                                                document.getElementById("filter").submit();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 align-items-baseline pt-4" style="text-align: center;"></div>
                            <div class="col-md-3 align-items-baseline pt-4" style="text-align: center;"></div>
                        </div>
                    </form>
                </div>
            </div>
			<br>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div style="margin-bottom: 50px;" class="table-responsive-md">

						<?php
						if($std == 'left')
						{
							$records_per_page = 10;
							$total_records_query = "SELECT COUNT(*) as count FROM student_info WHERE dept_id = '$admin_dept_id' AND enrollment_no_genrator = 'left'";
							$total_records_result = mysqli_query($con, $total_records_query);
							$total_records = mysqli_fetch_assoc($total_records_result)['count'];
							$total_pages = ceil($total_records / $records_per_page);

							$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
							$offset = ($current_page - 1) * $records_per_page;
						}
						else
						{
							$records_per_page = 10;
							$total_records_query = "SELECT COUNT(*) as count FROM student_info WHERE dept_id = '$admin_dept_id' AND enrollment_no_genrator != 'left'";
							$total_records_result = mysqli_query($con, $total_records_query);
							$total_records = mysqli_fetch_assoc($total_records_result)['count'];
							$total_pages = ceil($total_records / $records_per_page);

							$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
							$offset = ($current_page - 1) * $records_per_page;
						}
						?>

						<table id="stud" style="margin-left: 0 ;margin-right:0;"
							class="w-100  table-dark container table-striped table-hover table-elements table-one-tr"
							cellpadding="10">
							<thead class="thead-dark">
								<tr class="table-tr-head table-three text-white">
									<th style="border-radius: 20px 0 0 0;">Enrollment.No</th>
									<th>Student Name</th>
									<th>Current Address</th>
									<th>Session</th>
									<th>Course ID</th>
									<th>Admission</th>
									<th>Profile</th>
									<th style="border-radius: 0 20px 0 0;" colspan="1">Operations</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if($std == 'left')
									{
										$query = "SELECT * FROM student_info WHERE dept_id = '$admin_dept_id' AND enrollment_no_genrator = 'left' LIMIT $offset, $records_per_page";
									}
									else
									{
										$query = "SELECT * FROM student_info WHERE dept_id = '$admin_dept_id' AND enrollment_no_genrator != 'left' LIMIT $offset, $records_per_page";
									}

								$run = mysqli_query($con, $query);

								while ($row = mysqli_fetch_array($run)) { ?>
									<tr>
										<td>
											<?php echo $row["enrollment_no"] ?>
										</td>
										<td>
											<?php echo $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] ?>
										</td>
										<td>
											<?php echo $row["current_address"] ?>
										</td>
										<td>
											<?php echo $row["session"] ?>
										</td>
										<td>
											<?php echo $row["course_code"] ?>
										</td>
										<!-- date_format($date,"Y/m/d H:i:s"); -->
										<td>
											<?php echo date("d-m-Y", strtotime($row["admission_date"])); ?>
										</td>
										<td>
											<?php $profile_image = $row["profile_image"] ?>
											<?php $profile_image = $row["profile_image"];
											if ($profile_image) {
												echo '<img style="border-radius:50px;" height="50px" width="50px" alt="img" src="/CMS/Student/' . $profile_image . '">';
											} else {
												echo '<img style="border-radius:50px;" height="50px" width="50px" alt="no img" src="/CMS/Images/student-no-image.jpg">';
											}
											?>
										</td>
										<td width='170'>
											<?php
											echo "<a class='btn btn-primary' href=../Student/display-Student.php?enrollment_no=" . $row['enrollment_no'] . ">Profile</a> ";
											if($std == 'current')
											{
											?>
												<a class="btn btn-danger"
												href="delete-function.php?enrollment_no=<?= $row['enrollment_no'] ?>"
												onclick="return confirm('Are you sure you want to remove this student?')">Delete</a>
											<?php } ?>
										</td>
									</tr>
								<?php }
								?>
							</tbody>
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

									<?php if ($current_page > 2) { ?>
										<li class="page-item">
											<a class="page-link" href="?page=1">1</a>
										</li>
										<li class="page-item disabled">
											<a class="page-link" href="#">...</a>
										</li>
									<?php } ?>

									<?php for ($i = max(1, $current_page - 1); $i <= min($current_page + 1, $total_pages); $i++) { ?>
										<li class="page-item <?php echo ($current_page == $i ? 'active' : ''); ?>">
											<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
										</li>
									<?php } ?>

									<?php if ($current_page < ($total_pages - 1)) { ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">...</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
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



					</div>

					</section>
				</div>
			</div>
		</div>
		</div>
		</div>
	</main>
	<!-- ========== PAGE JS FILES ========== -->
	<script src="../js/prism/prism.js"></script>
	<script src="../js/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>