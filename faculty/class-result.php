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
	LEFT JOIN class AS c ON t.teacher_code = c.teacher_code
	INNER JOIN department AS d ON t.dept_id = d.dept_id
	WHERE t.user_id = '$userid'
	AND t.password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);

	$urname = $row["user_id"];
	$pass = $row["password"];
	$teacher_code = $row["teacher_code"];
	$name = $row["first_name"];
	$dept_id = $row["dept_id"];
	$email = $row["email"];
	$dept = $row["dept_name"];
	$class = $row["class_id"];

	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}
?>
<!---------------- Session Ends form here ------------------------>

<?php
if (isset($_POST['sub'])) {
	$count = $_POST['count'];
	for ($i = 0; $i < $count; $i++) {
		$date = date("d-m-y");
		$que = "insert into class_result(roll_no,course_code,subject_code,semester,total_marks,obtain_marks,result_date)values('" . $_POST['roll_no'][$i] . "','" . $_POST['course_code'][$i] . "','" . $_POST['subject_code'][$i] . "','" . $_POST['semester'][$i] . "','" . $_POST['total_marks'][$i] . "','" . $_POST['obtain_marks'][$i] . "','$date')";
		$run = mysqli_query($con, $que);
		if ($run) {
		} else {
		}
	}
}
?>
<?php
if(isset($_POST['res-btn']))
{
    foreach ($_POST['result'] as $i => $res_status) 
	{    
        $std_id = $_POST['enrollment_no'][$i];
		$a_query = "UPDATE `student_info` SET `exam_status`='$res_status' WHERE `enrollment_no` = '$std_id'";
       	$a_run = mysqli_query($con , $a_query);	   
    }
	if($a_run)
	{
		//echo "<script>window.location.href='class-result.php';</script>";
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

		.btn {
			border: 0;
		}

		.btn-primary {
			border: 0;
			background-color: #1f5b6e;
		}

		div.btn.btn-block.table-two.d-flex {
			background-color: #245e71;
		}

		input.btn {
			border-radius: 30px;
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
	<title>Class - Result</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/teacher-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Add Class Result</h1>
			</div>
			
			<div class="row">
				<div class="col-md-12 ml-2">
					<section class="mt-3">
						<table style="margin-bottom: 10px;"
							class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
							cellpadding="5">
							<thead class="thead-dark">
								<tr class="table-tr-head text-white table-three">
									<th style="border-radius: 20px 0 0 0;">Sr.No</th>
									<th>Enrollment No</th>
									<th>Student Name</th>
									<th>Cource Name</th>
									<th>Semester</th>
									<th>Class</th>
									<th style="border-radius: 0 20px 0 0;">Overall Status</th>
								</tr>
							</thead>
							<?php
							$i = 0;
							$count = 0;
								$que = "SELECT * FROM student_info  
								where dept_id = '$dept_id' AND class_id = '$class' AND exam_status = ''";
								$run = mysqli_query($con, $que);
								if((mysqli_num_rows($run)) > 0)
								{
									while ($row = mysqli_fetch_array($run)) 
									{
										$count++;
										?>
										<form action="class-result.php" method="post">
											<tr>
												<td>
													<?php echo ($i+1); $i++; ?>
												</td>
												<td>
													<?php echo $row['enrollment_no'] ?>
												</td>
												<input type="hidden" name="enrollment_no[<?php echo $i;?>]" value=<?php echo $row['enrollment_no'] ?>>
												<td>
													<?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?>
												</td>
												<td>
													<?php echo $row['course_code'] ?>
												</td>
												<td>
													<?php echo $row['current_semester'] ?>
												</td>
												<td>
													<?php echo $row['class_id'] ?>
												</td>
												<td>
													Pass <input type="radio" style="caret-color: #1f5b6e;" name="result[<?php echo $i ?>]" value="1">
													Fail <input type="radio" style="caret-color: #1f5b6e;" name="result[<?php echo $i ?>]" value="0">
												</td>
											</tr>
										<?php
									}
								
							?>
								<tr><td colspan="7"><input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Save" name="res-btn" /></td></tr>
							<?php
								}
								else
								{
									echo "<tr><td colspan='7'>Result Already Submitted</td></tr>";
								}
							?>

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