<?php include('../common/header.php');

?>
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

}

?>
<!---------------- Session Ends form here ------------------------>

<!--*********************** PHP code starts from here for data insertion into database ******************************* -->
<?php

if (isset($_POST['btn_save'])) {
	$message = "";
	$success_message = "";
	$error_message = "";
	$course_code = $_POST["course_code"];
	$semester = $_POST["semester"];
	$timing_from = $_POST["timing_from"];
	$timing_to = $_POST["timing_to"];
	$day = $_POST["day"];
	$subject_code = $_POST["subject_code"];
	$room_no = $_POST["room_no"];

	$query = "insert into time_table(course_code,semester,timing_from,timing_to,day,subject_code,room_no)values('$course_code','$semester','$timing_from','$timing_to','$day','$subject_code','$room_no')";
	$run = mysqli_query($con, $query);
	if ($run) {

		$success_message = '<div class="alert success sus mt-4">
		<span class="closebtn">&times;</span>
		<strong>Success!</strong> Your Data has been submitted.
	</div>';
	} else {
		$error_message = '<div class="alert mt-4 ">
		<span class="closebtn ">&times;</span>
		<strong>Danger!</strong> Your Data has not been submitted
	</div>';
	}
}
?>
<!-- ---------------------------------------update time table------------------------------------------------ -->
<?php

if (isset($_POST['btn_update'])) {
	$message = "";
	$success_message = "";
	$error_message = "";
	$course_code = $_POST["course_code"];
	$semester = $_POST["semester"];
	$timing_from = $_POST["timing_from"];
	$timing_to = $_POST["timing_to"];
	$day = $_POST["day"];
	$subject_code = $_POST["subject_code"];
	$room_no = $_POST["room_no"];
	

	$query1 = "update time_table set course_code='$course_code',semester='$semester',timing_from='$timing_from',timing_to='$timing_to',day='$day',subject_code='$subject_code',room_no='$room_no' where subject_code='$subject_code'";
	$run1 = mysqli_query($con, $query1);
	if ($run1) {
		$success_message = '<div class="alert success sus mt-4">
		<span class="closebtn">&times;</span>
		<strong>Success!</strong> Your Data has been updated.
	</div>';
	} else {
		$error_message = '<div class="alert mt-4 ">
		<span class="closebtn ">&times;</span>
		<strong>Danger!</strong> Your Data has not been updated
	</div>';
	}
}
?>
<!-- ---------------------------------------update time table------------------------------------------------ -->

<!--*********************** PHP code end from here for data insertion into database ******************************* -->

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
		.cards {
			display: flex;
			justify-content: space-between;
			margin: 10px;
		}

		.card {
			box-sizing: border-box;
			width: 100%;
			height: 190px;
			/* background: rgba(217, 217, 217, 0.58); */
			/* background: rgba(84, 105, 212, 0.98); */
			/* border: 1px solid white; */
			box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
			backdrop-filter: blur(6px);
			border-radius: 17px;
			text-align: center;
			cursor: pointer;
			transition: all 0.5s;
			display: flex;
			color: white;
			align-items: center;
			justify-content: center;
			user-select: none;
			font-weight: bolder;
		}

		div.card {
			margin-right: 15;

		}

		div.card:last-child {
			margin-right: 0;

		}

		div.card.card1 {
			background-color: #3b4e76;
		}

		div.card.card2 {
			background-color: #19d7e5;
		}

		div.card.card3 {
			background-color: #24ae7a;
		}

		.card:hover {
			/* border: 1px solid #354387; */
			transform: scale(1.05);
		}

		.card:active {
			transform: scale(0.95) rotateZ(1.7deg);
		}

		table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		@media screen and (max-width: 1200px) {

			.cards {
				display: flex;
				justify-content: space-between;
			}

			.card {
				margin: 10px;
			}
		}
		@media only screen and (max-width: 685px) {

			/* CSS rules here */
			.cards {
				display: contents;
				justify-content: space-between;
				margin: 10px;
			}

			.card {
				width: 95%;
				margin: 10px;
			}
		}
		.scroll::-webkit-scrollbar {
			display: none;
		}

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
	</style>
	<title>Admin - Time Table</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12  ml-sm-auto px-md-4 mb-2 w-100">
		<section class=" mt-4">
			<h3 style="text-align: center;">Classes Time Table</h3>
			<?php
				$c_query = "SELECT * FROM courses WHERE dept_id='$admin_dept_id' ";
				$c_run = mysqli_query($con , $c_query);
				if((mysqli_num_rows($c_run)) > 0 )
				{
					$i = 0;
					while ($row = mysqli_fetch_array($c_run))
					{
						if($i % 3 == 0 )
						{
							echo '<div class="cards">';
						} ?>
							<div onclick="window.location.href = '/CMS/dept_admin/promote_class.php?course_code=<?= $row['course_code']; ?>';" class="card card1">
								<h2><?php echo $row['course_code']; ?></h2>
							</div>
			<?php 	
						$i++;
						if($i % 3 == 0 )
						{
							echo '</div>';			
						}
					}
				}
				else
				{
					echo "<h1>No Data Found </h1>";
				}
			?>
		</section>
	</main>
	<script>
		var close = document.getElementsByClassName("closebtn");
		var i;
		for (i = 0; i < close.length; i++) {
			close[i].onclick = function() {
				var div = this.parentElement;
				div.style.opacity = "0";
				setTimeout(function() {
					div.style.display = "none";
				}, 600);
			}
		}
	</script>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>