<!---------------- Session starts form here ----------------------->
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

	$class ="";
	$sem ="";
	$crs ="";
	$enrollment_no ="";
	$check = "SELECT * FROM `student_info` WHERE `user_id`='$userid' AND `password`='$password'";
	$check_run = mysqli_query($con ,$check);
	if($check_run)
	{
		$check_row = mysqli_fetch_assoc($check_run);
		$class = $check_row['class_id'];
		$sem = $check_row['current_semester'];
		$crs = $check_row['course_code'];
		$enrollment_no = $check_row['enrollment_no'];
		// echo "<h1>".$class."-".$sem." - ".$crs ."</h1>";
	}
	else
	{
		echo "<script>alert('There was an error inserting your record.');</script>";

	}
}

?>
<?php
$time_from = ['08:00 - 09:00','09:00 - 10:00','10:00 - 11:00','11:00 - 12:00','12:00 - 12:30','12:30 - 01:30','01:30 - 02:30'];
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
?>
<!---------------- Session Ends form here ------------------------>


<!doctype html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" sizes="32x32" href="../Images/fav.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../Images/fav.png">

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
	</style>
	<title>Student Dashboard</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/student-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">

			<div class="p-0 mt-2 rounded text-center">
				<h1>Student Dashboard</h1>
			</div>
			<div class="row">
				<div class=" col-lg-12 col-md-12 col-sm-12 ">
					<section class="mt-3">
						<div style=" border-radius: 20px;" class="btn btn-block table-one text-white d-flex">
							<span class="font-weight-bold"><i class="fa fa-list mr-3" aria-hidden="true"></i> Your Schedule</span>
							<a href="" class="ml-auto font-weight-bold" data-toggle="collapse" data-target="#collapsetwo"><i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>

						</div>
						<div class="collapse show mt-2" id="collapsetwo">
							<table style="" class="w-100 time-table table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
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
									foreach($time_from as $time)
									{
										if($time != '12:00 - 12:30')
										{
											$del_id[$time] = array();
											echo "<tr>";
											echo "<td>" . $time ."</td>";
											$i = 1;
											foreach($days as $d)
											{		
												
												// WHERE t.course_code='$course_code' AND t.sem='$select' AND t.class_id='$class'  
												$tt_query = "SELECT t.*, s.subjects_name, f.first_name, f.last_name 
												FROM time_table AS t 
												INNER JOIN subjects AS s ON s.subjects_code = t.subject_code
												LEFT JOIN teacher_info AS f ON t.subject_code = f.teaching_subject
												WHERE t.class_id='$class' AND t.course_code='$crs' AND t.sem='$sem' AND t.day = '$i' AND t.time ='$time'
												ORDER BY t.day ASC , t.time ASC";
												$tt_run = mysqli_query($con, $tt_query);
												//$cur_class++;
												$c ="";
												$id ="";
												//echo mysqli_num_rows($tt_run) . $i; 
												if(mysqli_num_rows($tt_run) > 0)
												{
													$tt_row = mysqli_fetch_assoc($tt_run);
													$c = ($tt_row['room'] . " - " . $tt_row['subjects_name'] ."<br>" . $tt_row['first_name'] . $tt_row['last_name']);
													$id = $tt_row['id'];
												}
												echo "<td>" . $c . "</td>";
												$del_id[$time][$i] = $id;
												$i++;
											}
										}
										else
										{
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
			<div class="row">
				<div class=" col-lg-6 col-md-12 col-sm-12">
					<section class="mt-3">
						<div style=" border-radius: 20px;" class="btn btn-block text-white table-two d-flex">
							<span class="font-weight-bold"><i class="fa fa-check-square-o mr-3" aria-hidden="true"></i>Attendance Status</span>
							<a href="" class="ml-auto" data-toggle="collapse" data-target="#collapse3"><i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>

						</div>
						<div class="collapse show mt-2" id="collapse3">
							<table style="margin-bottom: 10px;" class="w-100 table-dark table-striped table-hover table-elements table-two-tr" cellpadding="2">
								<thead class="thead-dark">
									<tr class="pt-5 table-two" style="height: 32px;">
										<th style="border-radius: 20px 0 0 0;">Present</th>
										<th>Absent</th>
										<th style="border-radius: 0 20px 0 0;">Percentage</th>
									</tr>
								</thead>
								<?php
									$query4 = "SELECT COUNT(attendance_id) AS attendance_id, SUM(attendance) AS attendance, student_id 
											FROM student_attendance 
											WHERE student_id = '$enrollment_no'";
											$run4 = mysqli_query($con, $query4);
											$i = 0;
											$num_rows = mysqli_num_rows($run4);
											while ($row4 = mysqli_fetch_array($run4)) {
											$i++;
								?>
									<tr>
										<td <?php if ($i == $num_rows) {
												echo " style='border-radius: 0 0 0 20px;'";
											} ?>><?php echo $row4['attendance'] ? $row4['attendance'] : "0" ?></td>
										<td><?php echo $row4['attendance_id'] - $row4['attendance'] ?></td>
										<?php $attendace =  $row4['attendance_id'] > 0 ? round(($row4['attendance'] * 100) / $row4['attendance_id']) . "%" : "0%" ?>
										<td <?php if ($i == $num_rows) {
												echo "style='border-radius:  0 0 20px 0;'";
											} ?>><?php echo $attendace ?></td>
									</tr>
								<?php }
								?>
							</table>
						</div>
					</section>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<section class="mt-3">
						<div style=" border-radius: 20px;" class="btn btn-block text-white table-two d-flex">
							<span class="font-weight-bold"><i class="fa fa-book mr-3" aria-hidden="true"></i>Subject details</span>
							<a href="" class="ml-auto" data-toggle="collapse" data-target="#collapse3"><i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>

						</div>
						<div class="collapse show mt-2" id="collapse3">
							<table style="margin-bottom: 10px;" class="w-100 table-dark table-striped table-hover table-elements table-two-tr" cellpadding="2">
								<thead class="thead-dark">
									<tr class="pt-5 table-two" style="height: 32px;">
										<th style="border-radius: 20px 0 0 0;">Sr No</th>
										<th>Subject Name</th>
										<th style="border-radius: 0 20px 0 0;">Credit hrs</th>
									</tr>
								</thead>
								<?php
									$query4 = "SELECT * FROM subjects WHERE semester = '$sem' AND course_code='$crs'";
											$run4 = mysqli_query($con, $query4);
											$i = 0;
											$num_rows = mysqli_num_rows($run4);
											while ($row4 = mysqli_fetch_array($run4)) {
								?>
									<tr>
										<td <?php if ($i == $num_rows) {
												echo " style='border-radius: 0 0 0 20px;'";
											} ?>><?php echo $i+1; $i++; ?></td>
										<td><?php echo $row4['subjects_name'] ?></td>
										<td <?php if ($i == $num_rows) {
												echo "style='border-radius:  0 0 20px 0;'";
											} ?>><?php echo $row4['credits'] ?></td>
									</tr>
								<?php }
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