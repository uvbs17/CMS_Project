<!---------------- Session starts form here ----------------------->
<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!$_SESSION["Logininfo"]) {
	header('location:../login/login.php');
} else {
	$userid = $_SESSION['Logininfo']['user_id'];
	$password = $_SESSION['Logininfo']['password'];

	$query = "SELECT * FROM student_info WHERE user_id = '$userid' AND password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);

	$urname = $row["user_id"];
	$enrollment_no = $row["enrollment_no"];
	$pass = $row["password"];


	//echo "<a><hr> $roll_no <hr> $name <hr>$dept_id<hr>$dept</a>";
}

?>
<!---------------- Session Ends form here ------------------------>


<?php
if (isset($_POST['sub'])) {
	$enrollment_no = $_POST['enrollment_no'];
	$mobile_no = $_POST['mobile_no'];
	$email = $_POST['email'];
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$current_address = $_POST['current_address'];
	$permanent_address = $_POST['permanent_address'];
	$state = $_POST['state'];
	$place_of_birth = $_POST['place_of_birth'];
	// Handle uploaded profile picture
	if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
		$temp_name = $_FILES["profile_picture"]["tmp_name"];
		$target_path = "images/"; // Specify the directory where you want to save the uploaded pictures
		$enrollment_no = $_POST['enrollment_no'];
		$profile_picture_name = $enrollment_no . '.' . pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
		$target_file = $target_path . $profile_picture_name;
		$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	
		// Check if the uploaded file is an actual image
		$check = getimagesize($temp_name);
		if ($check !== false) {
			// Move the uploaded file to the target directory
			if (move_uploaded_file($temp_name, $target_file)) {
				// echo "Profile picture uploaded successfully.";
			} else {
				echo "Failed to upload profile picture.";
			}
		} else {
			echo "Invalid image file.";
		}
	}
	

	if (isset($target_file)) {
		$query = "UPDATE student_info SET mobile_no='$mobile_no',profile_image='$target_file', email='$email', dob='$dob', gender='$gender', current_address='$current_address', permanent_address='$permanent_address', state='$state', place_of_birth='$place_of_birth' WHERE enrollment_no='$enrollment_no'";
	} else {
		$query = "UPDATE student_info SET mobile_no='$mobile_no', email='$email', dob='$dob', gender='$gender', current_address='$current_address', permanent_address='$permanent_address', state='$state', place_of_birth='$place_of_birth' WHERE enrollment_no='$enrollment_no'";
	}
	if (mysqli_query($con, $query)) {
		// echo "Information updated successfully";
	} else {
		echo "Error updating information: " . mysqli_error($con);
	}
} ?>


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
			/* border-radius: 30px; */
		}

		div.col-lg-12.col-md-12.col-sm-12 {
			border-radius: 30px;
			margin-bottom: 40px;
		}

		button.btn.btn-primary {
			border-radius: 30px;
			background-color: #1f5b6e;
		}
	</style>
	<style>
	/* Style for the profile picture */
	.profile-picture {
		width: 200px;
		height: auto;
	}

	/* Style for the form container */
	.form-container {
		max-width: 500px;
		margin: 0 auto;
		padding: 20px;
		background-color: #f9f9f9;
		border: 1px solid #ddd;
		border-radius: 5px;
	}

	/* Style for form labels */
	label {
		font-weight: bold;
	}

	/* Style for form inputs */
	input[type="text"],
	input[type="number"],
	input[type="email"],
	input[type="date"],
	select {
		width: 100%;
		padding: 8px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-bottom: 10px;
	}

	/* Style for the submit button */
	.btn-primary {
		background-color: #007bff;
		color: #fff;
		border: none;
		padding: 10px 20px;
		border-radius: 4px;
		cursor: pointer;
	}

	.btn-primary:hover {
		background-color: #0056b3;
	}

	/* Style for the file input */
	.input-file {
		display: inline-block;
	}

	.input-file input[type="file"] {
		display: none;
	}

	.input-file label {
		background-color: #007bff;
		color: #fff;
		padding: 10px 20px;
		border-radius: 4px;
		cursor: pointer;
	}

	img.profile-picture {
  border: 3px solid #1f5b6e;
  border-radius: 15px;
  margin-bottom: 20px;
}

	.input-file label:hover {
		background-color: #0056b3;
	}

	/* Additional styles to adjust spacing and layout */

	.col-md-4,
	.col-md-6 {
		padding: 0 10px;
	}

	.col-md-4:last-child,
	.col-md-6:last-child {
		padding-right: 0;
	}

	@media (max-width: 768px) {
		.col-md-4,
		.col-md-6 {
			padding: 0;
		}
	}
</style>

	<title>Student Dashboard</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/student-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main sub-main-student">

			<div class="p-0 mt-4 rounded text-center">
				<h1>Student Profile</h1>
			</div>
			<div style="padding:10px;" class="row">
				<div class="col-lg-12 center col-md-12 col-sm-12">
					<form action="student-personal-information.php" method="post" enctype="multipart/form-data">
						<?php $enrollment_no = $row["enrollment_no"];
						$query = "select * from student_info where enrollment_no='$enrollment_no'";
						$run = mysqli_query($con, $query);
						while ($row = mysqli_fetch_array($run)) { ?>

							<div class="row">
								<div class="col-md-12 mt-3">
									<?php
									// Display the uploaded profile picture if it exists
									$profile_picture_path = $row["profile_image"];
									if (isset($profile_picture_path) && file_exists($profile_picture_path)) {
										echo '<img src="' . $profile_picture_path . '" alt="Profile Picture" class="profile-picture">';
									}
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Enrollment No:</label>
										<input type="text" class="form-control" name="enrollment_no"
											value="<?php echo $row['enrollment_no']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Semester</label>
										<input readonly type="number" name="semester" class="form-control"
											placeholder="Semester" value="<?php echo $row['current_semester'] ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">First Name:</label>
										<input readonly type="text" class="form-control" name="first_name"
											value="<?php echo $row['first_name'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputPassword1">Middle Name:</label>
										<input readonly type="text" class="form-control" name="middle_name"
											value="<?php echo $row['middle_name'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Last Name:</label>
										<input readonly type="text" class="form-control" name="last_name"
											value="<?php echo $row['last_name'] ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Mobile Number: *</label>
										<input type="number" class="form-control" name="mobile_no" pattern="[0-9]{10}"
											value="<?php echo $row['mobile_no'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Email: *</label>
										<input type="email" class="form-control" name="email"
											value="<?php echo $row['email'] ?>">
									</div>
								</div>
							</div>
							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">DOB:*</label>
										<input type="date" class="form-control" name="dob"
											value="<?php echo $row['dob'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Gender</label>
										<select class="form-control" name="gender">
											<option value="">--Select Gender--</option>
											<option value="male" <?php if ($row['gender'] == 'male')
												echo "selected"; ?>>Male
											</option>
											<option value="female" <?php if ($row['gender'] == 'female')
												echo "selected"; ?>>
												Female</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Current Address:*</label>
										<textarea type="text" name="current_address" class="form-control"
											value=""><?php echo $row["current_address"] ?></textarea>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputPassword1">Permanent Address:*</label>
										<textarea type="text" name="permanent_address" class="form-control"
											value=""><?php echo $row["permanent_address"] ?></textarea>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">State: *</label>
										<input type="text" name="state" class="form-control" placeholder="State Province"
											value="<?php echo $row['state'] ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputFile">Profile Picture:</label>
										<input type="file" class="form-control-file" name="profile_picture"
											id="exampleInputFile" accept="image/*">
										<small class="form-text text-muted">Please upload an image file.</small>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Place of Birth:*</label>
										<input type="text" name="place_of_birth" class="form-control"
											value="<?php echo $row['place_of_birth'] ?>">
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-4 mt-3">
								<button type="submit" name="sub" class="btn btn-primary">Update Information</button>
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