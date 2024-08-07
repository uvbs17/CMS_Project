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
if (isset($_POST['sub'])) {
	$count = $_POST['count'];
	for ($i = 0; $i < $count; $i++) {
		$date = date("d-m-y");
		$que = "insert into student_attendance(course_code,subject_code,semester,student_id,attendance,attendance_date)values('" . $_POST['course_code'][$i] . "','" . $_POST['subject_code'][$i] . "','" . $_POST['semester'][$i] . "','" . $_POST['roll_no'][$i] . "','" . $_POST['attendance'][$i] . "','$date')";
		$run = mysqli_query($con, $que);
		if ($run) {
			echo "Insert Successfully";
		} else {
			echo " Insert Not Successfully";
		}
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
	<title>Admin - Student Attendance</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Student Attendance Management System </h1>
			</div>
			<div class="row w-100">
				<div class="col-md-12">
					<form action="student-attendance.php" method="post">
						<div class="row mt-3">
							<div class="col-md-4">
								<div class="form-group" style="z-index: 10;">
									<label>Enter Class Id:</label>
									<select class="browser-default custom-select" name="course_code">
										<option>Select Course</option>
										<?php
										$teacher_code=$_POST['teacher_code'];
										$query = "select distinct(course_code) as course_code from time_table";
										$run = mysqli_query($con, $query);
										while ($row = mysqli_fetch_array($run)) {
											echo "<option value=" . $row['course_code'] . ">" . $row['course_code'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Select Semester:</label>
									<select class="browser-default custom-select" name="semester">
										<option>Select Semester</option>
										<?php
										$teacher_code=$_POST['teacher_code'];
										$query = "select distinct(semester) as semester from course_subjects";
										$run = mysqli_query($con, $query);
										while ($row = mysqli_fetch_array($run)) {
											echo "<option value=" . $row['semester'] . ">" . $row['semester'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Enter Subject:</label>
									<select class="browser-default custom-select" name="subject_code" required="">
										<option>Select Subject</option>
										<?php
										$teacher_code=$_POST['teacher_code'];
										$query = "select subject_code from time_table";
										$run = mysqli_query($con, $query);
										while ($row = mysqli_fetch_array($run)) {
											echo "<option value=" . $row['subject_code'] . ">" . $row['subject_code'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<input type="submit" name="submit" class="btn btn-primary px-5" value="Press">
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<section class="mt-3">
						<table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="5">
							<thead class="thead-dark">
								<tr class="table-tr-head text-white table-three">
									<th style="border-radius: 20px 0 0 0;">Sr.No</th>
									<th>Roll No</th>
									<th>Course Name</th>
									<th>Subject Name</th>
									<th>Semester</th>
									<th>Student Name</th>
									<th>Present/Absent</th>
									<th>Percentage</th>
									<th style="border-radius: 0 20px 0 0;">Add Attendance</th>
								</tr>
							</thead>
							<?php
							$i = 1;
							$count = 0;

							if (isset($_POST['submit'])) {
								$course_code = $_POST['course_code'];
								$semester = $_POST['semester'];
								$subject_code = $_POST['subject_code'];


								$que = "select student_info.roll_no,first_name,middle_name,last_name,student_courses.semester,student_courses.course_code,subject_code from student_courses inner join student_info on student_info.roll_no=student_courses.roll_no where student_courses.course_code='$course_code' and student_courses.semester='$semester' and student_courses.subject_code='$subject_code'";
								$run = mysqli_query($conn, $que);
								while ($row = mysqli_fetch_array($run)) {
									$count++;
							?>
									<form action="student-attendance.php" method="post">
										<tr>
											<td>
												<?php echo $i++ ?>
											</td>
											<?php $roll_no = $row['roll_no']; ?>
											<td>
												<?php echo $row['roll_no'] ?>
											</td>
											<input type="hidden" name="roll_no[]" value=<?php echo $row['roll_no'] ?>>
											<td>
												<?php echo $row['course_code'] ?>
											</td>
											<input type="hidden" name="course_code[]" value=<?php echo $row['course_code'] ?>>
											<td>
												<?php echo $row['subject_code'] ?>
											</td>
											<input type="hidden" name="subject_code[]" value=<?php echo $row['subject_code'] ?>>
											<td>
												<?php echo $row['semester'] ?>
											</td>
											<input type="hidden" name="semester[]" value=<?php echo $row['semester'] ?>>
											<td>
												<?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?>
											</td>
											<?php
											$query1 = "select count(attendance_id) as attendance_id,sum(attendance) as attendance from student_attendance where student_id='$roll_no' and subject_code='$subject_code'";
											$run1 = mysqli_query($con, $query1);
											while ($row1 = mysqli_fetch_array($run1)) { ?>
												<td class="text-center">
													<?php echo $row1['attendance'] . "/" . ($row1['attendance_id'] - $row1['attendance']) ?>
												</td>
												<td>
													<?php echo $row1['attendance_id'] > 0 ? round(($row1['attendance'] * 100) / $row1['attendance_id']) . "%" : "0" ?>
												</td>
											<?php }
											?>
											<td>
												Present <input type="radio" style="caret-color: #1f5b6e;" name="attendance" value="1">
												Absent <input type="radio" style="caret-color: #1f5b6e;" name="attendance" value="0">
											</td>
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