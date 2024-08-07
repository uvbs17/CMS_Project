<?php include('../common/header.php') ?>
<?php
// session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) 
{
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!isset($_SESSION["Logininfo"])) 
{
		echo '<script type="text/javascript">window.location.href = "index.php";</script>';
} 
else 
{
	$userid = $_SESSION['Logininfo']['user_id'];
	$password = $_SESSION['Logininfo']['password'];

	$query = "SELECT *
	FROM teacher_info AS t
	LEFT JOIN class AS c ON t.teacher_code = c.teacher_code
	WHERE t.user_id = '$userid'
	AND t.password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);

	$urname = $row["user_id"];
	$pass = $row["password"];
	$teacher_code = $row["teacher_code"];
	$subject = $row['teaching_subject'];
	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}
?>
<!---------------- Session Ends form here ------------------------>

<?php
$time_from = ['08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 12:30', '12:30 - 01:30', '01:30 - 02:30'];
$lec_time ;
if (isset($_POST['time'])) {
	$lec_time = $_POST['time'];
}
?>

<?php
if(isset($_POST['att-btn']))
{
	$course = $_POST['crs'];
	$sem = $_POST['sem'];
	$sub = $_POST['subject'];
	$today = date('d-m-Y');
	$class = $_POST['class'];
	$time = $_POST['att_time'];
    foreach ($_POST['attendance'] as $i => $att_status) 
	{    
        $std_id = $_POST['enrollment'][$i];
        // echo $std_id;
		$a_query = "INSERT INTO `student_attendance`(`attendance_id`, `course_code`, `subject_code`, `semester`,`class_id` , `student_id`, `attendance`, `attendance_date`, `time`) 
		VALUES (NULL,'$course','$sub','$sem','$class','$std_id','$att_status','$today','$time')";
       	$a_run = mysqli_query($con , $a_query);	   
    }
	if($a_run)
	{
		echo "<script>window.location.href='Student-attendance.php';</script>";
	}
	else
	{
		echo " failed";
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

		input.btn.text-white {
			background-color: #1f5b6e;
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
	<title>Student - Attendance</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/teacher-sidebar.php');
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Student Attendance</h1>
			</div>
			<div class="row">
                <div class="col-md-12">
                    <form id="filter" action="Student-attendance.php" method="post">
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Time/Lecture:</label>
                                    <div class="d-flex">
										<select class="browser-default custom-select" name="time" id="time_select">
											<option hidden>Select Time</option>
											<?php
											foreach ($time_from as $time) {
												if ($time != '12:00 - 12:30') {
													//break;
													echo "<option value='$time'>" . $time . "</option>";
												} else {
												}
											}
											?>
										</select>
                                        <script>
                                            const select = document.getElementById("time_select");
                                            select.addEventListener("change", function () {
                                                document.getElementById("filter").submit();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<section class="mt-3">
					<table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="5">
						<thead class="thead-dark">
							<tr class="table-tr-head text-white table-three">
								<th style="border-radius: 20px 0 0 0;">Sr.No</th>
								<th>Enrollment No.</th>
								<th>Student Name</th>
								<th>Day</th>
								<th>Lecture Time</th>
								<th>Subject</th>
								<th style="border-radius: 0 20px 0 0;">Attendance</th>
							</tr>
						</thead>
							<?php
								$i = 0;
								$date = date('d-m-Y');
								// $count = 0;
								if (isset($lec_time)) 
								{
									$today = date('l');
									// $today = "Wednesday";
									$que = "SELECT t.* , w.day_name , s.enrollment_no ,s.first_name, s.last_name , s.course_code ,s.current_semester,ss.subjects_name 
									FROM time_table AS t 
									INNER JOIN student_info AS s ON s.class_id = t.class_id 
									INNER JOIN subjects AS ss ON ss.subjects_code = t.subject_code 
									INNER JOIN weekdays AS w ON (t.day = w.day_id AND t.sem = s.current_semester AND t.course_code = s.course_code)
									WHERE t.subject_code ='$subject' AND w.day_name='$today' AND t.time='$lec_time' 
									AND NOT EXISTS (
										SELECT * FROM student_attendance AS att 
										WHERE att.student_id = s.enrollment_no 
										AND att.attendance_date = '$date' 
										AND att.subject_code = t.subject_code 
										AND att.semester = s.current_semester 
										AND att.course_code = s.course_code 
										AND att.class_id = s.class_id
										AND att.time = '$lec_time'
									)
									ORDER BY t.time ASC;";
									$run = mysqli_query($con, $que);
									// echo mysqli_num_rows($run);
									if((mysqli_num_rows($run)) > 0)
									{
										while ($att_row = mysqli_fetch_assoc($run)) 
										{
											// $count++;
											// print_r($att_row);
							?>
										<form action="Student-attendance.php" method="post">
										<tr>
											<input type="hidden" name="crs" value="<?php echo $att_row['course_code'] ?>" />
											<input type="hidden" name="class" value="<?php echo $att_row['class_id'] ?>" />
											<input type="hidden" name="sem" value="<?php echo $att_row['current_semester'] ?>" />
											<td><?php echo ($i+1); $i++; ?></td>
											<td><?php echo $att_row['enrollment_no']; ?></td>
											<input type="hidden" name="enrollment[<?php echo $i;?>]" value="<?php echo $att_row['enrollment_no'] ?>" />
											<td><?php echo $att_row['first_name'] . " " . $att_row['last_name']; ?></td>
											<td><?php echo $today; ?></td>
											<input type="hidden" name="day" value=<?php echo $today ?> />
											<td><?php echo $lec_time; ?></td>
											<input type="hidden" name="att_time" value="<?php echo $lec_time; ?>" />
											<td><?php echo $att_row['subjects_name']; ?></td>
											<input type="hidden" name="subject" value="<?php echo $subject ?>" />
											<td>
												Present <input type="radio" style="caret-color: #1f5b6e;" name="attendance[<?php echo $i ?>]" value="1">
												Absent <input type="radio" style="caret-color: #1f5b6e;" name="attendance[<?php echo $i ?>]" value="0" checked>
											</td>
										</tr>
							<?php
										}
							?>	
										<tr><td colspan="7"><input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Save" name="att-btn" /></td></tr>
							<?php	}
									else
									{
										echo "<tr><td colspan='3'>Attendance filled</td><td> OR </td><td colspan='3'> No class found for the selected time </td></tr>";
									}
								}
								else
								{
									echo "<tr><td colspan='7'>Select Your Lecture Time</td></tr>";
								}
							?>
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