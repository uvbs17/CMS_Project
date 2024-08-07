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
	$check = $_SESSION['Logininfo']['role'];
	if ($check == 'std') {
		
		$query = "SELECT * FROM student_info WHERE user_id = '$userid' AND password = '$password'";

		$result = mysqli_query($con, $query);
		if($result)
		{
			$row = mysqli_fetch_array($result);
			$urname = $row["user_id"];
			$pass = $row["password"];
			$enrollment_no = $row["enrollment_no"];
		}
		else
		{
			echo "nah";
		}
		
	} else if ($check == 'admin') {

		$enrollment_no = $_GET['enrollment_no'];
	} else if ($check == 'fac') {

		$enrollment_no = $_GET['enrollment_no'];
	} else if ($check == 'dept') {

		$enrollment_no = $_GET['enrollment_no'];
	} else {

		$enrollment_no = 0;
	}



	//echo "<a><hr> $urname <hr> $name <hr>$dept_id<hr>$dept</a>";
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
		div.container.data {
			margin-top: 50px;
			border-radius: 30px;
			margin-bottom: 40px;
			background-color: white;
			border: 0;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		h3 {
			margin-left: -2px;
			font-weight: bold;
		}

		div.row.text-white.pt-5 {
			border-radius: 30px 30px 0 0;
			background-color: #1f5b6e;
		}

		div.row.pt-3 {
			margin: 5px;
		}

		div div h5 {
			font-weight: bold;
		}

		div.details {
			padding: 10px;
		}

		img.mb-5 {
			border-radius: 20px;
			margin-left: 30px;
			margin-top: -10;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}
	</style>
	<title>Student Dashboard</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<main role="main" class="ml-sm-auto px-md-4 mb-2 w-100"><br><br>
		<?php
		//echo $roll_no;
		$query = "select * from student_info where enrollment_no='$enrollment_no'";
		$run = mysqli_query($con, $query);
		while ($row = mysqli_fetch_array($run)) {
		?>
			<div class="container data">
				<div class="row text-white pt-5">
					<div class="col-md-4">
						<?php
						$profile_image = $row["profile_image"];
						if ($profile_image) {
							// Display the image from the database
							echo '<img class="mb-5" height="290px" width="250px" alt="img" src="' . $profile_image . '">';
						} else {
							// Display a default image if there is no image in the database
							echo '<img class="mb-5" height="290px" width="250px" alt="no img" src="/CMS/Images/student-no-image.jpg">';
						}
						?>

					</div>
					<div class="col-md-8">
						<h3><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></h3><br>
						<div class="row">
							<div class="col-md-6">
								<h5>Father Name:</h5> <?php echo $row['father_name']  ?><br><br>
								<h5>Email:</h5> <?php echo $row['email']  ?><br><br>
								<h5>Contact:</h5> <?php echo $row['mobile_no']  ?><br><br>
							</div>
							<div class="col-md-6">
								<h5>Enrollment No:</h5> <?php echo $row['enrollment_no']  ?><br><br>
								<h5>Current Address:</h5> <?php echo $row['current_address']  ?><br><br>
								<h5>Permanent Address:</h5> <?php echo $row['permanent_address']  ?><br><br>
							</div>
						</div>
					</div>
					<hr>
				</div>
				<div class="details">
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Phone No:</h5> <?php echo $row['mobile_no']  ?>
						</div>
						<div class="col-md-4">
							<h5>State:</h5> <?php echo $row['state']  ?>
						</div>
						<div class="col-md-4">
							<h5>Current Semester:</h5> <?php echo $row['current_semester']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Gender:</h5> <?php echo $row['gender']  ?>
						</div>
						<div class="col-md-4">
							<h5>Course:</h5> <?php echo $row['course_code']  ?>
						</div>
						<div class="col-md-4">
							<h5>Admission Date:</h5> <?php echo $row['admission_date']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Date of Birth:</h5> <?php echo $row['dob']  ?>
						</div>
						<div class="col-md-4">
							<h5>Place of Birth:</h5> <?php echo $row['place_of_birth']  ?>
						</div>
						<!-- <div class="col-md-4">
						</div> -->
					</div>
					
					<!-- <div class="row pt-3">
						<div class="col-md-4">
							<h5>Matric Complition Date:</h5> <?php echo $row['matric_complition_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>Matric Awarded Date:</h5> <?php echo $row['matric_awarded_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>Matric Certificate:</h5> <?php echo $row['matric_certificate']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Fa Complition Date:</h5> <?php echo $row['fa_complition_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>Fa Awarded Date:</h5> <?php echo $row['fa_awarded_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>Fa Certificate:</h5> <?php echo $row['fa_certificate']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>BA Complition Date:</h5> <?php echo $row['ba_complition_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>BA Awarded Date:</h5> <?php echo $row['ba_awarded_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>BA Certificate:</h5> <?php echo $row['ba_certificate']  ?>
						</div> -->
					</div>
				</div>
			</div>
		<?php } ?>
	</main>
</body>
<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</html>