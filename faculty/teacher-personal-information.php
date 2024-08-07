<!---------------- Session starts form here ----------------------->
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
	$teacher_code = $row["teacher_code"];
	$name = $row["first_name"];
	$dept_id = $row["dept_id"];
	$email = $row["email"];
}


if (isset($_POST['sub'])) {

	$query = "UPDATE teacher_info SET
    phone_no = '{$_POST['phone_no']}',
    gender = '{$_POST['gender']}',
    emergency_contact_phone = '{$_POST['emergency_contact_phone']}',
    emergency_contact_name = '{$_POST['emergency_contact_name']}',
    emergency_contact_relationship = '{$_POST['emergency_contact_relationship']}',
    certification = '{$_POST['certification']}',
    education_level = '{$_POST['education_level']}',
    current_address = '{$_POST['current_address']}',
    permanent_address = '{$_POST['permanent_address']}',
    place_of_birth = '{$_POST['place_of_birth']}'
WHERE email='$email'";
	$run = mysqli_query($con, $query);
	if ($run) { 
		?>
		<script type="text/javascript">
			header("Location: teacher-personal-information.php");
		</script>
	<?php } else { ?>
		<script type="text/javascript">
			alert("Teacher data has not been updated paid due to some errors");
		</script>
<?php }
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
		input.form-control {
			border-radius: 5px;
		}

		div.col-lg-12.col-md-12.col-sm-12 {
			border-radius: 30px;
			margin-bottom: 40px;
		}

		button.btn {
			border-radius: 30px;
			background-color: #1f5b6e;
		}
	</style>
	<title>Teacher Personal Information</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/teacher-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Update Your Personal Infromation</h1>
			</div>
			<div style="padding:10px;" class="row">
				<div class="col-lg-12 col-md-12">
					<form action="teacher-personal-information.php" method="post">
						<?php
							$query = "SELECT * FROM teacher_info WHERE email='$email'";
					
							// assuming that you have already established a database connection
							$run = mysqli_query($con, $query);
							while ($row = mysqli_fetch_array($run)) { 
						?>
						<div style=" margin-top:20px;" class="row">
							<!-- First Name -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">First Name</label>
									<input readonly type="text" class="form-control" name="first_name" value="<?php echo $row['first_name']; ?>">
								</div>
							</div>
							<!-- Middle Name -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Middle Name</label>
									<input readonly type="text" class="form-control" name="middle_name" value="<?php echo $row['middle_name']; ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<!-- Last Name -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Last Name</label>
									<input readonly type="text" class="form-control" name="last_name" value="<?php echo $row['last_name']; ?>">
								</div>
							</div>
							<!-- CNIC -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Aadhar No</label>
									<input readonly type="text" class="form-control" name="cnic" placeholder="Enter CNIC" value="<?php echo $row['aadhar_no']; ?>">
								</div>
							</div>
						</div>
						<div class="row">
						<!-- Mobile -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Mobile</label>
									<input type="number" pattern="[0-9]{10}" class="form-control" name="phone_no" value="<?php echo $row['phone_no']; ?>">
								</div>
							</div>
							<!-- Gender -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Gender</label>
									<select class="form-control" name="gender">
										<option <?php if($row['gender'] == '') echo 'selected'; ?> value="">Select Gender</option>
										<option <?php if($row['gender'] == 'male') echo 'selected'; ?> value="male">Male</option>
										<option <?php if($row['gender'] == 'female') echo 'selected'; ?> value="female">Female</option>
										<option <?php if($row['gender'] == 'other') echo 'selected'; ?> value="other">Other</option>
									</select>
								</div>
							</div>
							
						</div>
						<div class="row">
						<!-- Mobile -->
							<div class="col-md-4">
								<div class="form-group">
									<label for="">Emergency Mobile</label>
									<input type="number" class="form-control" pattern="[0-9]{10}" name="emergency_contact_phone" value="<?php echo $row['emergency_contact_phone']; ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="">Emergency name</label>
									<input type="text" class="form-control" name="emergency_contact_name" value="<?php echo $row['emergency_contact_name']; ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="">Emergency Relation</label>
									<input type="text" class="form-control" name="emergency_contact_relationship" value="<?php echo $row['emergency_contact_relationship']; ?>">
								</div>
							</div>
						</div>
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Certification</label>
									<input type="text" class="form-control" name="certification" value="<?php echo $row['certification']; ?>">
								</div>
							</div>
							<!-- Qualification -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Qualification</label>
									<input type="text" class="form-control" name="education_level" placeholder="Last Qualification" value="<?php echo $row['education_level']; ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<!-- Current Address -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Current Address:*</label>
									<input type="text" class="form-control" name="current_address" value="<?php echo $row['current_address']; ?>">
								</div>
							</div>
							<!-- Permanent Address -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Permanent Address:*</label>
									<input type="text" class="form-control" name="permanent_address" value="<?php echo $row['permanent_address']; ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<!-- State/Province -->
							<!-- <div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">State Or Province: *</label>
									<input type="text" class="form-control" name="state" placeholder="State Province" value="<?php echo $row['dept_id']; ?>">
								</div>
							</div> -->
							<!-- Place of Birth -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Place of Birth:*</label>
									<input type="text" class="form-control" name="place_of_birth" value="<?php echo $row['place_of_birth']; ?>">
								</div>
							</div>
						</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-4 mt-3">
								<button type="submit" name="sub" class="btn text-white">Update Information</button>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>