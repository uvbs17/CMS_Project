<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!isset($_SESSION["Logininfo"])) {
	echo '<script type="text/javascript">window.location.href = "../login/login.php";</script>';
} else {
	$userid = $_SESSION['Logininfo']['user_id'];
	$password = $_SESSION['Logininfo']['password'];
}

?>
<!---------------- Session Ends form here ------------------------>


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

		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}
	</style>
	<title>Student Dashboard</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/student-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Student Result Summary</h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<section class="table-responsive-md mt-3">
						<table style="margin-bottom: 10px;" class="w-100  table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="10">
							<thead class="thead-dark">
								<tr class="text-center text-white table-three table-tr-head">
									<th style="border-radius: 20px 0 0 0;">Term</th>
									<th>Course</th>
									<th>Subject</th>
									<th>Cr.Hr</th>
									<th>Total Marks</th>
									<th>Obtain Marks</th>
									<th>Grade</th>
									<th style="border-radius: 0 20px 0 0;">CGPA</th>
								</tr>
							</thead>
							<?php
							$cgpa = 0;
							$gpa = 0;
							$total_marks = 0;
							$obtain_marks = 0;
							$count = 0;
							$query = "SELECT * FROM student_info WHERE user_id = '$userid' AND password = '$password'";

							$result = mysqli_query($con, $query);
							$row = mysqli_fetch_array($result);
							$enrollment_no = $row["enrollment_no"];
							$query = "SELECT * FROM class_result cr inner join course_subjects cs on cr.subject_code=cs.subject_code where cr.enrollment_no='$enrollment_no'";
							$run = mysqli_query($con, $query);
							while ($row = mysqli_fetch_array($run)) { ?>
								<tr class="text-center">
									<td>
										<?php echo $row['course_code'] . "-" . $row['semester'] ?>
									</td>
									<td>
										<?php echo $row['course_code'] ?>
									</td>
									<td>
										<?php echo $row['subject_code'] ?>
									</td>
									<td>
										<?php echo $row['credit_hours'] ?>
									</td>
									<td>
										<?php echo $row['total_marks'] ?>
									</td>
									<td>
										<?php echo $row['obtain_marks'] ?>
									</td>
									<?php
									if ($row['obtain_marks'] > 85) {
										$grade = 'A+';
										$credits = 4.0;
									} else if ($row['obtain_marks'] > 80) {
										$grade = 'A';
										$credits = 4.0;
									} else if ($row['obtain_marks'] > 75) {
										$grade = 'B+';
										$credits = 3.7;
									} else if ($row['obtain_marks'] > 70) {
										$grade = 'B';
										$credits = 3.3;
									} else if ($row['obtain_marks'] > 65) {
										$grade = 'C+';
										$credits = 3.0;
									} else if ($row['obtain_marks'] > 60) {
										$grade = 'C';
										$credits = 2.7;
									} else if ($row['obtain_marks'] > 55) {
										$grade = 'D+';
										$credits = 2.5;
									} else if ($row['obtain_marks'] > 50) {
										$grade = 'D';
										$credits = 2.0;
									} else {
										$grade = 'F';
										$credits = 0.0;
									}
									?>
									<td>
										<?php echo $grade ?>
									</td>
									<td>
										<?php echo $credits ?>
									</td>
								</tr>
							<?php
								$count++;
								$score = $credits * $row['credit_hours'];
								$gpa = $gpa + $score;
								$cgpa = $cgpa + $row['credit_hours'];
								$obtain_marks = $obtain_marks + $row['obtain_marks'];
								$total_marks = $total_marks + $row['total_marks'];
							}
							?>
							<tr class=" text-white bg-success text-center">
								<td style="border-radius: 0 0 0 20px;">
									<?php echo "1." ?>
								</td>
								<td>
									<?php echo "FINAL RESULT " ?>
								</td>
								<td>
									<?php echo $count; ?>
								</td>
								<td>
									<?php echo $cgpa ?>
								</td>
								<td>
									<?php echo $total_marks; ?>
								</td>
								<td>
									<?php echo $obtain_marks; ?>
								</td>
								<?php
								$marks_grade = $total_marks == true ? ($obtain_marks * 100) / $total_marks : "";
								$marks_grade = round($marks_grade);
								if ($marks_grade > 85) {
									$final = 'A+';
								} else if ($marks_grade > 80) {
									$final = 'A';
								} else if ($marks_grade > 75) {
									$final = 'B+';
								} else if ($marks_grade > 70) {
									$final = 'B';
								} else if ($marks_grade > 65) {
									$final = 'C+';
								} else if ($marks_grade > 60) {
									$final = 'C';
								} else if ($marks_grade > 55) {
									$final = 'D+';
								} else if ($marks_grade > 50) {
									$final = 'D';
								} else {
									$marks_grade == true ? $final = 'F' : $final = "0";
								}
								?>
								<td>
									<?php echo $final ?>
								</td>
								<td style="border-radius:  0 0 20px 0;">
									<?php echo $gpa > 0 ? round($total_cgpa = $gpa / $cgpa, 2) : "0" ?>
								</td>

							</tr>
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