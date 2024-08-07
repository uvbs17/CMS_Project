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
		<div class="sub-main ">

			<div class="p-0 mt-4 rounded text-center">
				<h1>Student Fee Summar</h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<section class="table-responsive-md mt-3">
						<table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="10">
							<thead class="thead-dark">
								<tr>
									<th style="border-radius: 20px 20px 0 0;" colspan="9">
										<h4 class="text-center">Student Fee Detail</h4 class="text-center">
									</th>
								</tr>
								<tr>
									<th>Transaction ID.</th>
									<th>Enrollment No.</th>
									<th>Student Name</th>
									<th>Program</th>
									<th>Amount (Rs.)</th>
									<th>Posting Date</th>
									<th>Status</th>
								</tr>
							</thead>
							<?php
							$query = "SELECT * FROM student_info WHERE user_id = '$userid' AND password = '$password'";

							$result = mysqli_query($con, $query);
							$row = mysqli_fetch_array($result);
							$enrollment_no = $row["enrollment_no"];
							$query = "select transaction_id,student_fee.enrollment_no,first_name,middle_name,last_name,course_code,amount,date(posting_date) as posting_date,status from student_fee inner join student_info on student_fee.enrollment_no=student_info.enrollment_no where student_fee.enrollment_no='$enrollment_no'";
							$run = mysqli_query($con, $query);
							$i = 0;
							$num_rows = mysqli_num_rows($run);
							while ($row = mysqli_fetch_array($run)) { ?>
								<tr>
									<td <?php if ($i == $num_rows) {
											echo " style='border-radius: 0 0 0 20px;'";
										} ?>><a download target="_blank"
										title="Generate Invoice"
										href="../invoice.php?transaction_id=<?php echo $row['transaction_id'];?>"><?php echo $row['transaction_id'];?></a></td>
									<td><?php echo $row['enrollment_no'] ?></td>
									<td><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
									<td><?php echo $row['course_code'] ?></td>
									<td><?php echo $row['amount'] ?></td>
									<td><?php echo date($row['posting_date']) ?></td>
									<td <?php if ($i == $num_rows) {
											echo "style='border-radius:  0 0 20px 0;'";
										} ?>><?php echo $row['status'] ?></td>
								</tr>
							<?php
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