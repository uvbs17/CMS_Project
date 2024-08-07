<?php //include('../common/header.php') ?>
<?php
session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
else{}

if (!isset($_SESSION["Logininfo"])) 
{
	echo '<script type="text/javascript">window.location.href = "../login/login.php";</script>';
} 
else {
    $userid = $_SESSION['Logininfo']['user_id'];
	$password = $_SESSION['Logininfo']['password'];
	$check = $_SESSION['Logininfo']['role'];
	if(isset($_GET['profile']))
	{
		$teacher_code = $_GET['profile'];
		//echo "<script>alert (' teacher Code');</script>";

	}
	else
	{
		echo "<script>alert ('Error getting teacher Code');</script>";
		echo "<script>window.location.href='teacher.php';</script>";
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
	<main role="main" class="ml-sm-auto px-md-4 mb-2 pt-2 w-100">
		<?php
		$query = "SELECT * FROM teacher_info AS t INNER JOIN department AS d on t.dept_id = d.dept_id WHERE teacher_code=?";
		$stmt = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($stmt, "s", $teacher_code);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		while ($row = mysqli_fetch_array($result)) {
			$subject_code = "";
			if(isset($row['teaching_subject']))
			{
				$teaching_code = $row['teaching_subject'];
				$s_query = "SELECT subjects_name FROM subjects WHERE subjects_code='$teaching_code'";
				$s_run = mysqli_query($con , $s_query);
				if((mysqli_num_rows($s_run)) > 0)
				{
					$s_row = mysqli_fetch_array($s_run);
					$subject_code = $s_row ['subjects_name'];
				}
				else
				{
					$subject_code = "";
				}
			}
		?>
			<div class="container data">
				<div class="row text-white pt-5">
					<div class="col-md-4">
						<?php
						$profile_image = $row["profile_image"];
						if ($profile_image != NULL) {
							echo '<img class="mb-5" height="290px" width="250px" alt="img" src="../images/' . $profile_image . '">';
						} else {
							echo '<img class="mb-5" height="290px" width="250px" alt="no img" src="/CMS/Images/student-no-image.jpg">';
						}
						?>
	
					</div>
					<div class="col-md-8">
						<h3><?php echo $row['first_name'] . " " . $row['last_name'] . " " . $row['middle_name'] ?></h3><br>
						<div class="row">
							<div class="col-md-6">
								<h5>Teacher ID:</h5> <?php echo $row['teacher_code']  ?><br><br>
								<h5>Email:</h5> <?php echo $row['email']  ?><br><br>
								<h5>Contact:</h5> <?php echo $row['phone_no']  ?><br><br>
							</div>
							<div class="col-md-6">
								<h5>User ID:</h5> <?php echo $row['user_id']  ?><br><br>
								<h5>Salary:</h5> <?php echo $row['salary']  ?><br><br>
								<h5>Status:</h5> <?php echo $row['teacher_status']  ?><br><br>
							</div>
						</div>
					</div>
					<hr>
				</div>
				<div class="details">
					<br>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>First Name:</h5> <?php echo $row['first_name']; ?>
						</div>
						<div class="col-md-4">
							<h5>Middle Name:</h5> <?php echo $row['middle_name']  ?>
						</div>
						<div class="col-md-4">
							<h5>Last Name:</h5> <?php echo $row['last_name']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Email:</h5> <?php echo $row['email']  ?>
						</div>
						<div class="col-md-4">
							<h5>Phone No:</h5> <?php echo $row['phone_no']  ?>
						</div>
						<div class="col-md-4">
							<h5>Gender:</h5> <?php echo $row['gender']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Permanent address:</h5> <?php echo $row['permanent_address']  ?>
						</div>
						<div class="col-md-4">
							<h5>Current address:</h5> <?php echo $row['current_address']  ?>
						</div>
						<div class="col-md-4">
							<h5>Date of Birth:</h5> <?php echo $row['dob']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Place of Birth:</h5> <?php echo $row['place_of_birth']  ?>
						</div>
						<div class="col-md-4">
							<h5>Addhar No:</h5> <?php echo $row['aadhar_no']  ?>
						</div>
					</div>
					<br><hr style="border: solid 1px;"><br>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Certification:</h5> <?php echo $row['certification']  ?>
						</div>
						<div class="col-md-4">
							<h5>Education Level:</h5> <?php echo $row['education_level']  ?>
						</div>
					</div>
					<br><hr style="border: solid 1px;"><br>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Department:</h5> <?php echo $row['dept_name']  ?>
						</div>
						<div class="col-md-4">
							<h5>Hiring Date:</h5> <?php echo $row['hire_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>Teaching Subject:</h5> <?php echo $subject_code  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Experience:</h5> <?php echo $row['experience']  ?>
						</div>
						<div class="col-md-4">
							<h5>Contract Start Date:</h5> <?php echo $row['contract_start_date']  ?>
						</div>
						<div class="col-md-4">
							<h5>Contract End Date:</h5> <?php echo $row['contract_end_date']  ?>
						</div>
					</div>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Teaching Level:</h5> <?php echo $row['teaching_level']  ?>
						</div>
						<div class="col-md-4">
							<h5>Status:</h5> <?php echo $row['teacher_status']  ?>
						</div>
						<div class="col-md-4">
							<h5>Salary:</h5> <?php echo $row['salary']  ?>
						</div>
					</div>
					<br><hr style="border: solid 1px;"><br>
					<div class="row pt-3">
						<div class="col-md-4">
							<h5>Emergency Contact:</h5> <?php echo $row['emergency_contact_phone']?>
						</div>
						<div class="col-md-4">
							<h5>Name:</h5> <?php echo $row['emergency_contact_name']  ?>
						</div>
						<div class="col-md-4">
							<h5>Relation:</h5> <?php echo $row['emergency_contact_relationship']  ?>
						</div>
					</div>
					
					
				</div>
			</div>
		<?php } ?>
	</main>
	
</body>
<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</html>