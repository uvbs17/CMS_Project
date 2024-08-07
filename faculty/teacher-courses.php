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
	FROM teacher_info AS t
	LEFT JOIN class AS c
	ON t.teacher_code = c.teacher_code
	WHERE t.user_id = '$userid'
	AND t.password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);

	$urname = $row["user_id"];
	$pass = $row["password"];
	$name = $row["first_name"];
	$dept_id = $row["dept_id"];
	$email = $row["email"];
	$dept = $row["dept_name"];

	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
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

		div.btn.btn-block.table-one.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.table-three.d-flex {
			background-color: #245e71;
		}

		div.btn.btn-block.table-two.d-flex {
			background-color: #245e71;
		}

		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}
	</style>
	<title>Teacher - Courses</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/teacher-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Teacher Courses Information</h1>
			</div>
			<div class="row">
				<div class="col-md-12 mt-3">
					<table style="margin-bottom: 10px;"
						class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
						cellpadding="5">
						<thead class="thead-dark">
							<tr>
								<th style="border-radius: 20px 0 0 0;">Sr.No</th>
								<th>Course Name</th>
								<th>Subject Name</th>
								<th>Room No</th>
								<th>Semester</th>
								<th>Time</th>
								<th style="border-radius: 0 20px 0 0;">Total Classes</th>
							</tr>
						</thead>
						<?php
						$sr_no = 1;

						$query1 = "select * from teacher_info where email='$email'";
						$run1 = $run = mysqli_query($con, $query1);
						while ($row = mysqli_fetch_array($run1)) {
							$teacher_code = $row["teacher_code"];
						}
						$query = "select tc.teacher_code
,tc.course_code,tc.subject_code,tc.semester,tc.total_classes,tt.room_no,tt.timing_to from teacher_courses tc inner join time_table tt on tc.subject_code=tt.subject_code where teacher_code
='$teacher_code
'";
						$run = mysqli_query($con, $query);
						while ($row = mysqli_fetch_array($run)) {
							echo "<tr>";
							echo "<td>" . $sr_no++ . "</td>";
							echo "<td>" . $row["course_code"] . "</td>";
							echo "<td>" . $row["subject_code"] . "</td>";
							echo "<td>" . $row["room_no"] . "</td>";
							echo "<td>" . $row["semester"] . "</td>";
							echo "<td>" . $row["timing_to"] . "</td>";
							echo "<td>" . $row["total_classes"] . "</td>";
							echo "</tr>";
						}
						$_SESSION['teacher_code
'] = $teacher_code
						;
						?>
					</table>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>