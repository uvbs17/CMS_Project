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
	$admin_dept_id = substr($row["dept_id"], 0, 2);




	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<!---------------- Session Ends form here ------------------------>
<?php
if (isset($_POST['sub'])) {
	// Get form data
	$action = $_POST['action'];
	$class_id = mysqli_real_escape_string($con, $_POST['class_id']);
	//$dept_id = mysqli_real_escape_string($con, $_POST['dept_id']);
	$course_cd = mysqli_real_escape_string($con, $_POST['course']);
	$sem = mysqli_real_escape_string($con, $_POST['sem']);
    $division = mysqli_real_escape_string($con, $_POST['division']);
    $no_of_student = mysqli_real_escape_string($con, $_POST['no_of_student']);
    $teacher_code = mysqli_real_escape_string($con, $_POST['co-ordinater']);
    $course_code = trim($course_cd);

	// Perform insert or update based on action
	if ($action == 'insert') {
		$dept_id = $admin_dept_id;

		$query = "INSERT INTO class (id,class_id,dept_id,course_code,sem,division,no_of_student,teacher_code) 
                VALUES (NULL, '$class_id', '$dept_id','$course_code','$sem','$division','$no_of_student', '$teacher_code');";
		$run = mysqli_query($con, $query);
		if ($run) {
			echo "<script>window.location.href='class.php';</script>";
		} else {
			echo "<script>alert('There was an error inserting your record / Try using different Class Id.');</script>";
			echo "<script>window.location.href='class.php';</script>";

		}
	} elseif ($action == 'update') {
		$query = "UPDATE class SET course_code='$course_code', sem='$sem', division='$division', no_of_student='$no_of_student', teacher_code='$teacher_code' WHERE class_id='$class_id'";
		$run = mysqli_query($con, $query);
		if ($run) {
			echo "<script>window.location.href='class.php';</script>";
		} else {
			echo "Error updating record: " . mysqli_error($con);
			echo "<script>window.location.href='class.php';</script>";
		}
	}
}

?>
<!-- --------------------------------^update class------------------------------------- -->
<!-- --------------------------------delete class------------------------------------- -->
<?php
if(isset($_GET['del_class_id']))
{
	$del_id=$_GET['del_class_id'];
	$del_query = "DELETE FROM class WHERE class_id = '$del_id'";
	$del_run = mysqli_query($con, $del_query);
	if($del_run)
	{
		echo "<script>window.location.href='class.php';</script>";
	}
	else
	{
		echo "<script>alert('There was an error in Processing your request.');</script>";
		echo "<script>window.location.href='class.php';</script>";
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
			height: 50px;
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

		td.button {
			margin-top: 11px;
			display: inline-table;
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
	<title>Admin - Register Teacher</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">

			<div class="p-0 rounded text-center">
				<h1>Class Management</h1>
			</div>
			<div class="container">
				<div class="modal-body">
					<?php
					// define a function to fetch data from the database
					function get_course_data($con, $class_id)
					{
						$stmt = $con->prepare("SELECT * FROM class WHERE class_id=?");
						$stmt->bind_param("s", $class_id);
						$stmt->execute();
						$result = $stmt->get_result();
						return $result->fetch_assoc();
					}

					if (isset($_GET['class_id'])):
						$class_id = $_GET['class_id'];
						$row = get_course_data($con, $class_id);

						?>
						<form action="class.php" method="post">
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group">
										<input type="hidden" name="action" value="update">
										<label for="exampleInputEmail1">Class ID: </label>
										<input value="<?php echo !empty($row['class_id']) ? $row['class_id'] : ''; ?>"
											type="text" name="class_id" class="form-control" required readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Course:</label>
										<select class="browser-default custom-select" name="course" required="">
											<?php echo !empty($row['course_code']) ? '<option value="'.$row['course_code'].' " selected>' . $row['course_code'] . '</option>' : ''; ?>
											<?php
											$query = "SELECT * FROM courses WHERE dept_id = '$admin_dept_id'";
											$run = mysqli_query($con, $query);
											while ($row_stream = mysqli_fetch_array($run)) {
												echo "<option value='".$row_stream['course_code']."'>" . $row_stream['course_name'] . " (" . $row_stream['course_code'] . ")</option>";
											}
											?>
											
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">No. of Students:</label>
										<input
										value="<?php echo !empty($row['no_of_student']) ? $row['no_of_student'] : ''; ?>"
										type="text" name="no_of_student" class="form-control" required
										placeholder="Enter No of Student">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Class Co-ordinater:</label>
										<select class="browser-default custom-select" name="co-ordinater" required="">
											<?php echo !empty($row['teacher_code']) ? '<option value="' . $row['teacher_code'] . ' " selected hidden>' . $row['teacher_code'] . '</option>' : ''; ?>

											<?php
											$query = "SELECT t.*
											FROM teacher_info AS t
											LEFT JOIN class AS c ON t.teacher_code = c.teacher_code
											WHERE c.teacher_code IS NULL AND t.dept_id = '$admin_dept_id';";
											$run = mysqli_query($con, $query);
											if(mysqli_num_rows($run) > 0)
											{
												while ($row_stream = mysqli_fetch_array($run)) {
													echo "<option value='".$row_stream['teacher_code']."'>" . $row_stream['first_name'] . " " . $row_stream['last_name'] . " (" . $row_stream['teacher_code'] . ")</option>";
												}
											}
											else
											{
												echo "<option value='NULL'>There is NO available teachers</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Semester:</label>
										<input
										value="<?php echo !empty($row['sem']) ? $row['sem'] : ''; ?>"
										type="text" name="sem" class="form-control" required
										placeholder="Enter Semester">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Division:</label>
										<input
										value="<?php echo !empty($row['division']) ? $row['division'] : ''; ?>"
										type="text" name="division" class="form-control" required
										placeholder="Enter division">
										</select>
									</div>
								</div>
							</div>	
							<div class="row w-100">
								<div class="col-md-12">
									<input type="submit" name="sub" value="Update" class="btn btn-primary ml-auto">
								</div>
							</div>
						</form>
					<?php else: ?>
						<form action="class.php" method="post">
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group">
										<input type="hidden" name="action" value="insert">
										<label for="exampleInputEmail1">Class ID: </label>
										<input value="" type="text" name="class_id" class="form-control" required
											placeholder="Enter Class ID">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Course :</label>
										<select class="browser-default custom-select" name="course" required="">
											<option disabled selected hidden>Select course</option>

											<?php
											$query = "SELECT * FROM courses WHERE dept_id = '$admin_dept_id'";
											$run = mysqli_query($con, $query);
											while ($row = mysqli_fetch_array($run)) {
												echo "<option value=".$row['course_code'].">".$row['course_name']. " (" . $row['course_code'] . ")</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">No.of Students:</label>
										<input value="" type="text" name="no_of_student" class="form-control" required
										placeholder="Enter No of Student">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Class Co-ordinater:</label>
										<select class="browser-default custom-select" name="co-ordinater" required="">
											<option disabled selected hidden>Select Class co-ordinater</option>

											<?php
											$query = "SELECT t.*
											FROM teacher_info AS t
											LEFT JOIN class AS c ON t.teacher_code = c.teacher_code
											WHERE c.teacher_code IS NULL AND t.dept_id = '$admin_dept_id';";
											$run = mysqli_query($con, $query);
											if(mysqli_num_rows($run) > 0)
											{
												while ($row = mysqli_fetch_array($run)) {
													echo "<option value=" . $row['teacher_code'] . ">" . $row['first_name'] . " " . $row['last_name'] . " (" . $row['teacher_code'] . ")</option>";
												}
											}
											else
											{
												echo "<option value='NULL'>There is NO available teachers</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Semesters:</label>
										<input value="" type="text" name="sem" class="form-control" required
										placeholder="Enter Semester">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Division:</label>
										<input value="" type="text" name="division" class="form-control" required
											placeholder="Enter Division">
									</div>
								</div>
							</div>
							<div class="row w-100">
								<div class="col-md-12">
									<input type="submit" name="sub" value="Insert" class=" btn btn-primary ml-auto">
								</div>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 ml-2 table-responsive-md">
				<section class="mt-3">
					<table style="margin-left: 0 ; margin-right:0;"
						class="w-100  table-dark container table-striped table-hover table-elements table-one-tr "
						cellpadding="10">
						<thead class="thead-dark">
							<tr class="table-tr-head table-three text-white">
								<th style="border-radius: 20px 0 0 0;">Sr.No</th>
								<th>Class ID</th>
								<th>Course Code</th>
								<th>Semester</th>
								<th>Division</th>
								<th>No. of Students</th>
								<th>Co-ordinater</th>
								<th colspan="2" style="border-radius: 0 20px 0 0;">Action</th>
							</tr>
						</thead>
						<?php
						$rows_per_page = 15;
						if (isset($_GET['page'])) {
							$page = intval($_GET['page']);
						} else {
							$page = 1;
						}
						$sr = ($page - 1) * $rows_per_page + 1;

						$query = "SELECT * FROM class WHERE dept_id=$admin_dept_id LIMIT " . ($page - 1) * $rows_per_page . ",$rows_per_page";
						$run = mysqli_query($con, $query);
						while ($row = mysqli_fetch_array($run)) {
							echo "<tr>";
							echo "<td>" . $sr++ . "</td>";
							echo "<td>" . $row['class_id'] . "</td>";
							echo "<td>" . $row['course_code'] . "</td>";
							echo "<td>" . $row['sem'] . "</td>";
							echo "<td>" . $row['division'] . "</td>";
							echo "<td>" . $row['no_of_student'] . "</td>";
							echo "<td>" . $row['teacher_code'] . "</td>"; ?>
							<td width='170' class="button">
								<a class="btn btn-primary mr-1"
									href="class.php?class_id=<?= $row['class_id'] ?>">Update</a>
								<a class="btn btn-danger" href="class.php?del_class_id=<?= $row['class_id'] ?>"
									onclick="return confirm('Are you sure you want to delete this class?')">Delete</a>
							</td>
							<?php echo "</tr>";
						}

						if (isset($_GET['page'])) {
							$current_page = $_GET['page'];
						} else {
							$current_page = 1;
						}
						$total_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM courses WHERE dept_id=$admin_dept_id"));
						$total_pages = ceil($total_rows / $rows_per_page);

						?>
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
								<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
									<li class="page-item <?php echo ($current_page == $i ? 'active' : ''); ?>">
										<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
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

				</section>
			</div>
		</div>


		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>