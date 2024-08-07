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
	$check = $_SESSION['Logininfo']['role'];

	$stmt = mysqli_prepare($con, "SELECT *
	FROM teacher_info AS t
	LEFT JOIN class AS c ON t.teacher_code = c.teacher_code
	INNER JOIN department AS d on t.dept_id = d.dept_id 
	WHERE t.user_id = ? AND t.password = ?");
	mysqli_stmt_bind_param($stmt, "ss", $userid, $password);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	$urname = $row["user_id"];
	$pass = $row["password"];
	$teacher_code = $row["teacher_code"];
	$name = $row["first_name"];
	$teacher_email = $row["email"];
	$dept = $row["dept_name"];
	$subjects = $row['teaching_subject'];

}
?>
<?php
$time_from = ['08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 12:30', '12:30 - 01:30', '01:30 - 02:30'];
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
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
	<title>Teacher - Dashboard</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

	<?php include('../common/teacher-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">

			<div class="p-0 mt-4 rounded text-center">
				<h1>
					Welcome
					<?php echo $row['first_name'] . " " . $row['middle_name']; ?> To Dashboard
				</h1>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div>
						<section class="mt-3">
							<div style=" border-radius: 20px;" class="btn btn-block text-white table-one d-flex">
								<span class="font-weight-bold"><i class="fa  fa-list mr-2" aria-hidden="true"></i> Your
									Schedule</span>
								<a href="" class="ml-auto  font-weight-bold" data-toggle="collapse"
									data-target="#collapseOne"><i class="fa text-white fa-caret-down"
										style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>
							</div>
							<div class="collapse show mt-2" id="collapsetwo">
								<table style="margin-bottom: 10px;"
									class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
									cellpadding="2">
									<thead class="thead-dark">
										<tr class="pt-5 table-one" style="height: 32px;">
											<th style="border-radius: 20px 0 0 0;">Time</th>
											<th>Monday</th>
											<th>Tuesday</th>
											<th>Wednesday</th>
											<th>Thursday</th>
											<th>Friday</th>
											<th style="border-radius: 0 20px 0 0 ;">Saturday</th>
										</tr>
									</thead>
									<?php
									foreach ($time_from as $time) {
										if ($time != '12:00 - 12:30') {
											$del_id[$time] = array();
											echo "<tr>";
											echo "<td>" . $time . "</td>";
											$i = 1;
											foreach ($days as $d) {
												$tt_query = "SELECT t.*, s.subjects_name , c.division
													FROM time_table AS t 
													INNER JOIN subjects AS s ON s.subjects_code = t.subject_code
													INNER JOIN class AS c ON c.class_id = t.class_id
													WHERE t.subject_code='$subjects' AND t.day = '$i' AND t.time ='$time'
													ORDER BY t.day ASC , t.time ASC";
												$tt_run = mysqli_query($con, $tt_query);
												//$cur_class++;
												$c = "";
												$id = "";
												//echo mysqli_num_rows($tt_run) . $i; 
												if (mysqli_num_rows($tt_run) > 0) {
													$tt_row = mysqli_fetch_assoc($tt_run);
													$c = ($tt_row['room'] . " - " . $tt_row['subjects_name'] . "<br>" . "SEM : " . $tt_row['sem'] . "<br>" . "DIVISION : " . $tt_row['division']);
													$id = $tt_row['id'];
												}
												echo "<td>" . $c . "</td>";
												$i++;
											}
										} else {
											echo "<tr>
													<td>$time</td>
													<td colspan='7' style='text-align: center;'>Break.</td></tr>";
											continue;
										}
										?>
										<?php
										echo "</tr>";
									}
									?>
								</table>
							</div>
						</section>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div>
						<section class="mt-3">

							<div style=" border-radius: 20px;" class="btn btn-block text-white table-one d-flex">
								<span class="font-weight-bold"><i class="fa  fa-money mr-2" aria-hidden="true"></i>
									Salary Report</span>
								<a href="" class="ml-auto  font-weight-bold" data-toggle="collapse"
									data-target="#collapseOne"><i class="fa text-white fa-caret-down"
										style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>
							</div>
							<div class="collapse show mt-2" id="collapseOne">
								<table style="margin-bottom: 10px;"
									class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
									cellpadding="2">
									<thead class="thead-dark">
										<tr class="pt-5 table-three" style="height: 32px;">
											<th style="border-radius: 20px 0 0 0;">Salary Voucher</th>
											<th>Basic Salary</th>
											<th>Medical Allowance</th>
											<th>HR Allowance</th>
											<th>Pay Scale</th>
											<th>Paid Date</th>
											<th style="border-radius: 0 20px 0 0;">Total Amount</th>
										</tr>
									</thead>
									<?php

									$query = "SELECT salary_id, basic_salary, medical_allowance, hr_allowance, scale, paid_date AS paid_date, total_amount FROM teacher_salary_allowances INNER JOIN teacher_salary_report ON teacher_salary_allowances.teacher_code = teacher_salary_report.teacher_code WHERE teacher_salary_allowances.teacher_code = '$teacher_code'";
									$run = mysqli_query($con, $query);
									while ($row = mysqli_fetch_array($run)) { ?>
										<tr>
											<td>
												<?php echo $row['salary_id'] ?>
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
						</section>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>