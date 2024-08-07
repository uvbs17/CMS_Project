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


<?php
if (isset($_POST['submit'])) {
	$query = "SELECT *
		FROM department AS d
		INNER JOIN student_info AS s
		ON s.dept_id = d.dept_id
		WHERE s.user_id = '$userid'
		AND s.password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$user_id = $row["user_id"];
	$password = $_POST['password'];
	$query = "UPDATE student_info set password='$password' where user_id='$user_id'";
	$run = mysqli_query($con, $query);
	if ($run) { 
		echo "<script type='text/javascript'>window.location.href='../Login/logout.php';</script>";
		
		?>
		<script type="text/javascript">
			alert("Your Password Has Been Changed");
		</script>
	<?php } else { ?>
		<script type="text/javascript">
			alert("Your Password Has Not Been Changed");
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
			border-radius: 30px;
		}

		input.btn.btn-primary {
			border-radius: 30px;
			position: absolute;
			left: 1;
		}

		div.col-md-12 {
			padding-bottom: 40px;
		}
	</style>
	<title>Student Password</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/student-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Update Your Password</h1>
			</div>
			<div class="container pt-5">
				<div class="row">
					<div class="col-md-12">
						<form action="student-password.php" method="post">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Enter New Password</label>
										<input type="text" name="password" class="form-control" required placeholder="Enter New Password">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group pt-4 pl-5">
										<input type="submit" name="submit" value="Update Password" class="btn btn-primary">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

