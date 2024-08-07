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
	$admin_dept_id = $row['dept_id'];
	 

	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<!---------------- Session Ends form here ------------------------>

<?php
if (isset($_POST['att-btn'])) {

	$date = date("d-m-Y");
	foreach ($_POST['attendance'] as $i => $att_status) 
	{
		$teacher_code=$_POST['teacher_code'][$i];

		$que = "INSERT INTO `teacher_attendance`(`attendance_id`, `teacher_code`, `dept_id`, `attendance`, `attendance_date`) VALUES (NULL,'$teacher_code','$admin_dept_id','$att_status','$date')";
		$run = mysqli_query($con, $que);
		if ($run) 
		{ 
			echo "<script>window.location.href='Teacher-attendance.php';</script>";
		} 
		else 
		{
			echo "<script>alert('There was an error inserting your record.');</script>";
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
	<title>Admin - Teacher Attendance</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Teacher Attendance Management System </h1>
			</div>
			<div class="row w-100">
				<div class="col-md-12 ml-2">
					<section class="mt-3">
						<table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="5">
							<thead class="thead-dark">
								<tr class="table-tr-head text-white table-three">
									<th style="border-radius: 20px 0 0 0;">Sr.No</th>
									<th>Teacher code</th>
									<th>Teacher Name</th>
									<th>Date</th>
									<th style="border-radius: 0 20px 0 0;">Attendance</th>
								</tr>
							</thead>
							<?php
								$i = 0;
								$date = date('d-m-Y');
								$que = "SELECT t.first_name,t.last_name,t.teacher_code FROM teacher_info AS t WHERE t.dept_id = '$admin_dept_id' 
								AND NOT EXISTs(
									SELECT * FROM `teacher_attendance`
									WHERE `teacher_code`=t.teacher_code 
									AND `dept_id` = '$admin_dept_id'
									AND `attendance_date` = '$date')";
								$run = mysqli_query($con, $que);
								if(mysqli_num_rows($run) > 0)
								{
									while ($row = mysqli_fetch_array($run)) 
									{
							?>
										<form action="Teacher-attendance.php" method="post">
											<tr>
												<td><?php echo ($i+1); $i++; ?></td>
												<td><?php echo $row['teacher_code'] ?></td>
												<input type="hidden" name="teacher_code[<?php echo $i; ?>]" value=<?php echo $row['teacher_code'] ?>>
												<td><?php echo $row["first_name"] . " " . $row["last_name"] ?></td>
												<td><?php echo $date ?></td>
												<td>
													Present <input type="radio" style="caret-color: #1f5b6e;" name="attendance[<?php echo $i; ?>]" value="1">
													Absent <input type="radio" style="caret-color: #1f5b6e;" name="attendance[<?php echo $i; ?>]" value="0" checked>
												</td>
											</tr>
										<?php
									}
							?>
								<tr><td colspan="5"><input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Save" name="att-btn" /></td></tr>
									</form>
							<?php
								}
								else
								{
									echo "<tr><td colspan='5'>Attendance filled</td></tr>";
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