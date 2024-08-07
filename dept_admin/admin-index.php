<!---------------- Session starts form here ----------------------->
<?php include('../common/header.php'); ?>
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
		FROM admin_info AS a
		INNER JOIN department AS d
		ON a.dept_id = d.dept_id
		WHERE a.user_id = '$userid'
		AND a.password = '$password'";

	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$admin_dept_id = substr($row["dept_id"], 0, 2);
	$dept_name = $row['dept_name'];

	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<?php
$stmt = $con->prepare("SELECT * FROM admission_form WHERE form_status IN ('rejected')");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
	$app_date = $row["application_date"];
	$form_id = $row["form_id"];
	$y = date('Y', strtotime($app_date));
	$m = date('m', strtotime($app_date));
	$cy = date('Y');
	$cm = date('m');
	$cfy;
	// echo "<br>" .  $y;
	// echo "<br>" . $m . "<br>";
	// echo "<br>" .  $cy;
	// echo "<br>" . $cm . "<br>";
	// echo "<br>" . $form_id . "<br>";
	if ($cm >= 4) {
		// echo "<br>" ;
		$cfy = $cy . '-' . ($cy + 1);
		// echo $cfy;
	} else {
		$cfy = ($cy - 1) . '-' . $cy;
	}
	if ($m >= 4) {
		$fy = $y . '-' . ($y + 1);
	} else {
		$fy = ($y - 1) . '-' . $y;
	}
	if ($cfy != $fy) {
		$queryd = "DELETE FROM admission_form WHERE form_id = '$form_id'";
		$resultd = mysqli_query($con, $queryd);
		if ($resultd) {
			//echo "sucess";
		} else {
			//echo "najh";
		}
	} else {
		//echo "<br>" ;

		//echo "nah";
	}
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

		.cardinfos {
			padding: 10px;
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 10px;
		}

		.cardinfo {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			justify-content: space-between;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
			overflow: hidden;
			position: relative;
			transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
		}

		.cardinfo:hover {
			transform: translateY(-10px);
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
		}

		.cardinfo1 {
			background-color: #FFB347;
			/* Mango Orange */
		}

		.cardinfo2 {
			background-color: #77DD77;
			/* Pastel Green */
		}

		.cardinfo3 {
			background-color: #AEC6CF;
			/* Blue-Gray */
		}

		.cardinfo4 {
			background-color: #FF6961;
			/* Watermelon Red */
		}

		.cardinfo5 {
			background-color: #B19CD9;
			/* Periwinkle */
		}

		.cardinfo6 {
			background-color: #F49AC2;
			/* Pink Lavender */
		}

		.cardinfo7 {
			background-color: #D7BDE2;
			/* Lilac Gray */
		}

		.cardinfo8 {
			background-color: #85C1E9;
			/* Steel Blue */
		}



		.cardinfo h2 {
			display: flex;
			flex-direction: column;
			/* justify-content: center; */
			align-items: flex-start;
			position: relative;
			top: -30px;
			height: 100%;
			text-decoration: none;
			color: #fff;
			font-size: 28px;
			margin: 20px 0 10px;
		}

		.cardinfo .digit {
			font-size: 50px;
			font-weight: bold;
			color: #fff;
			margin: 0;
			position: absolute;
			right: 10px;
			bottom: 0px;
		}

		@media screen and (max-width: 768px) {
			.cardinfo .digit {
				font-size: 30px;
			}
		}
	</style>
	<title>Department Admin</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/admin-sidebar.php') ?>

	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 pt-4 mb-2 w-100">
		<div class="p-0 rounded text-center">
			<h1><?php echo $dept_name;?> Dashboard</h1>
		</div>
		<?php
		$query = "SELECT 
					(SELECT COUNT(*) FROM student_info WHERE dept_id = '$admin_dept_id') AS num_of_students,
					(SELECT COUNT(*) FROM teacher_info WHERE dept_id = '$admin_dept_id') AS num_of_teachers,
					(SELECT COUNT(*) FROM admission_form WHERE form_status NOT IN ('rejected', 'accepted') AND dept_id = '$admin_dept_id') AS num_of_admision,
					(SELECT COUNT(*) FROM class WHERE dept_id = '$admin_dept_id') AS num_of_class,
					(SELECT COUNT(*) FROM courses WHERE dept_id = '$admin_dept_id') AS num_of_courses
				  ";

		$result1 = mysqli_query($con, $query);
		$data = mysqli_fetch_assoc($result1);

		$num_of_students = $data['num_of_students'];
		$num_of_teachers = $data['num_of_teachers'];
		$num_of_admision = $data['num_of_admision'];
		$num_of_class = $data['num_of_class'];
		$num_of_courses = $data['num_of_courses'];
		?>


		<div class="cardinfos">
			<div class="cardinfo cardinfo1">
				<h2>Student</h2>
				<p class="digit">
					<?php echo $num_of_students; ?>
				</p>
			</div>
			<div class="cardinfo cardinfo2">
				<h2>Teacher</h2>
				<p class="digit">
					<?php echo $num_of_teachers; ?>
				</p>
			</div>
			<div class="cardinfo cardinfo3">
				<h2>Admission</h2>
				<p class="digit">
					<?php echo $num_of_admision; ?>
				</p>
			</div>
			<div class="cardinfo cardinfo4">
				<h2>Course</h2>
				<p class="digit">
					<?php echo $num_of_courses; ?>
				</p>
			</div>
			<div class="cardinfo cardinfo5">
				<h2>Class</h2>
				<p class="digit">
					<?php echo $num_of_class; ?>
				</p>
			</div>
			<!-- <div class="cardinfo cardinfo6">
				<a href="#">
					<h2>Course</h2>
					<p class="digit">6</p>
				</a>
			</div>
			<div class="cardinfo cardinfo7">
				<a href="#">
					<h2>Course</h2>
					<p class="digit">6</p>
				</a>
			</div> -->
		</div>



		<div class="cards">
			<div onclick="window.location.href = '/CMS/dept_admin/Student.php';" class="card card1">
				<h2>Student</h2>
			</div>
			<div onclick="window.location.href = '/CMS/dept_admin/Teacher.php';" class="card card2">
				<h2>Teacher</h2>
			</div>
			<div onclick="window.location.href = '/CMS/dept_admin/admission_list.php';" class="card card3">
				<h2>admission form</h2>
			</div>
			<!-- <div class="card card3">
				<h2>College</h2>
			</div> -->
		</div>
		<div class="row">
			<div class="col-lg-7 col-md-12 col-sm-12 ">
				<div>
					<section class="mt-3">
						<div style=" border-radius: 20px;" class="btn btn-block table-one text-white d-flex">
							<span class="font-weight-bold"><i class="fa fa-clock-o mr-2" aria-hidden="true"></i> Class</span>
							<a href="" class="ml-auto font-weight-bold" data-toggle="collapse"
								data-target="#collapseOne"><i class="fa text-white fa-caret-down"
									style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>

						</div>
						<div class="collapse show mt-2" id="collapseOne">
							<table style="margin-bottom: 10px;"
								class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
								cellpadding="2">
								<thead class="thead-dark">
									<tr class="pt-5 table-one" style="height: 32px;">
										<th style="border-radius: 20px 0 0 0;">Class Name</th>
										<th>Course code</th>
										<th>Semester</th>
										<th style="border-radius: 0 20px 0 0;">Division</th>
									</tr>
								</thead>
								<?php
								$query = "SELECT * FROM class where dept_id='$admin_dept_id' ORDER BY course_code ASC , sem ASC";
								$run = mysqli_query($con, $query);
								$i = 0;
								$num_rows = mysqli_num_rows($run);
								while ($row = mysqli_fetch_array($run)) {
									$i++;
									echo "<tr>";
									echo "<td";
									if ($i == $num_rows) {
										echo " style='border-radius: 0 0 0 20px;'";
									}
									echo ">" . $row["class_id"] . "</td>";
									echo "<td>" . $row["course_code"] . "<br> </td>";
									echo "<td>" . $row["sem"] . "</td>";
									echo "<td";
									if ($i == $num_rows) {
										echo " style='border-radius:  0 0 20px 0;'";
									}
									echo ">" . $row["division"] . "</td>";
									echo "</tr>";
								}
								?>
							</table>
						</div>
					</section>
				</div>
			</div>
			<div class=" col-lg-5 col-md-12 col-sm-12">
				<div>
					<section class="mt-3">
						<div style=" border-radius: 20px;" class="btn btn-block text-white table-two d-flex">
							<span class="font-weight-bold"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
								Course List</span>
							<a href="" class="ml-auto" data-toggle="collapse" data-target="#collapsetwo"><i
									class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;"
									aria-hidden="true"></i></a>

						</div>
						<div style="height: 360px; overflow: auto; border-radius: 20px;"
							class="collapse scroll show mt-2" id="collapsetwo">
							<table class="w-100 table-dark table-striped table-hover table-elements table-two-tr"
								cellpadding="2">
								<thead class="thead-dark">
									<tr class="pt-5 table-two" style="height: 32px;">
										<th style="border-radius: 20px 0 0 0;">Course Code</th>
										<th style="border-radius: 0 20px 0 0;">Course Name</th>
									</tr>
								</thead>
								<?php
								$query = "SELECT course_name,course_code from courses where dept_id ='$admin_dept_id' ORDER BY course_code ASC ";
								$run = mysqli_query($con, $query);
								$i = 0;
								$num_rows = mysqli_num_rows($run);
								while ($row = mysqli_fetch_array($run)) {
									$i++;
									?>
									<tr>
										<td <?php if ($i == $num_rows) {
											echo " style='border-radius: 0 0 0 20px;'";
										} ?>><?php echo $row['course_code'] ?></td>
										<td <?php if ($i == $num_rows) {
											echo "style='border-radius:  0 0 20px 0;'";
										} ?>><?php echo $row['course_name'] ?></td>
									</tr>
								<?php }
								?>

							</table>
						</div>
					</section>
				</div>
			</div>
		</div>
	</main>

	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>