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
	$id = $row['id'];

	 

	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
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
		input.form-control {
			border-radius: 30px;
		}

		select.form-control {
			border-radius: 30px;
		}

		input.btn.btn-primary.px-5 {
			border-radius: 30px;
		}
	</style>
	<title>Admin - Manage Accounts</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">
			<div class="p-0 mt-4 rounded text-center">
				<h1>Manage your Account </h1>
			</div>
			<div class="row">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<form action="manage-function.php" method="post">
								<br><br>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>User ID :</label>
											<input type="text" name="user_id" value="<?= $row['user_id'];?>" class="form-control" required placeholder="User ID" readonly>
											<input type="hidden" name="id" value="<?= $row['id'];?>" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Password :</label>
											<input type="text" name="password" value="<?= $row['password'];?>" class="form-control" required placeholder="Password">
										</div>
									</div>
								</div>
								<div class="row">
									<br><br>
									<div class="col-md-6">
										<div class="form-group">
											<input type="submit" name="log_submit" value="Change" class="btn btn-primary px-5" 
											onclick="return confirm('Are you sure? You will be Logged out of your Acc')">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>