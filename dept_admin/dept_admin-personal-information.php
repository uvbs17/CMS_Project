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

	 

	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<!---------------- Session Ends form here ------------------------>


<?php

$teacher_code
 = $_SESSION['Logininfo'];
$query1 = "select * from teacher_info where email='$teacher_code
'";
$run1 = mysqli_query($con, $query1);
while ($row = mysqli_fetch_array($run1)) {
	$teacher_code=$_POST['teacher_code'];
}


if (isset($_POST['sub'])) {

	$first_name = $_POST['first_name'];

	$middle_name = $_POST['middle_name'];

	$last_name = $_POST['last_name'];

	$father_name = $_POST['father_name'];

	$cnic = $_POST['cnic'];

	$phone_no = $_POST['phone_no'];

	$gender = $_POST['gender'];

	$last_qualification = $_POST['last_qualification'];

	$current_address = $_POST['current_address'];

	$permanent_address = $_POST['permanent_address'];

	$state = $_POST['state'];

	$place_of_birth = $_POST['place_of_birth'];

	$query = "update teacher_info set first_name='$first_name',middle_name='$middle_name',last_name='$last_name',father_name='$father_name',cnic='$cnic',phone_no='$phone_no',gender='$gender',current_address='$current_address',permanent_address='$permanent_address',place_of_birth='$place_of_birth',last_qualification='$last_qualification',state='$state' where teacher_code
='$teacher_code
'";
	$run = mysqli_query($con, $query);
	if ($run) {  ?>
		<script type="text/javascript">
			alert("Teacher data has been updated");
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
	<title>Teacher Personal Information</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="text-center d-flex flex-wrap flex-md-nowrap pt-3 pb-2 mb-4 text-white admin-dashboard pl-3">
				<h4 class="">Update Your Personal Infromation</h4>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<form action="teacher-personal-information.php" method="post">
						<?php $teacher_code
 = $_SESSION['Logininfo'];
						$query = "select * from teacher_info where email='$teacher_code
'";
						$run = mysqli_query($con, $query);
						while ($row = mysqli_fetch_array($run)) { ?>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">First Name:*</label>
										<input type="text" class="form-control" name="first_name" value=<?php echo $row['first_name'] ?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Middle Name:*</label>
										<input type="text" class="form-control" name="middle_name" value=<?php echo $row['middle_name'] ?>>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Last Name:*</label>
										<input type="text" class="form-control" name="last_name" value=<?php echo $row['last_name'] ?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Father Name:*</label>
										<input type="text" class="form-control" name="father_name" placeholder="Enter Father Name" value=<?php echo $row['father_name'] ?>>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">CNIC:*</label>
										<input type="text" class="form-control" name="cnic" placeholder="Enter CNIC" value=<?php echo $row['cnic'] ?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Mobile:*</label>
										<input type="text" class="form-control" name="phone_no" value=<?php echo $row['phone_no'] ?>>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Gender</label>
										<input type="text" class="form-control" name="gender" value=<?php echo $row['gender'] ?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Qualifiacation</label>
										<input type="text" class="form-control" name="last_qualification" placeholder="Last Qualifiacation" value=<?php echo $row['last_qualification'] ?>>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Current Address:*</label>
										<input type="text" class="form-control" name="current_address" value=<?php echo $row['current_address'] ?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Permanent Address:*</label>
										<input type="text" class="form-control" name=" permanent_address" value=<?php echo $row['permanent_address'] ?>>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">State Or Province: *</label>
										<input type="text" class="form-control" name="state" placeholder="State Province" value=<?php echo $row['state'] ?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Place of Birth:*</label>
										<input type="text" class="form-control" name="place_of_birth" value=<?php echo $row['place_of_birth'] ?>>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-4 offset-5 mt-3">
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