 <!---------------- Session starts form here ----------------------->
 <?php include('../common/header.php') ?>
 <?php
	//session_start();
	require_once "../connection/connection.php";
	if (!$_SESSION["Logininfo"]) {
		header('location: index.php');
		echo "hello";
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
 	<title>Uni_Admin</title>
 	<!-- css style go to end here -->
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 </head>

 <body>
 	<?php include('../common/uni_admin-sidebar.php') ?>
 	<main role="main" class="col-xl-10 col-lg-9 mt-4 col-md-8 ml-sm-auto px-md-4 mb-2 w-100 page-content-index">
 		<div class="p-0 mt-4 rounded text-center">
 			<h1>University Admin Dashboard</h1>
 		</div>
 		<div class="row">
 			<div class=" col-lg-5 col-md-12 col-sm-12 ">
 				<div>
 					<section class="mt-3">
 						<div style=" border-radius: 20px;" class="btn btn-block table-one text-white d-flex">
 							<span class="font-weight-bold"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i>Departments</span>
 							<a href="" class="ml-auto font-weight-bold" data-toggle="collapse" data-target="#collapseOne"><i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>

 						</div>
 						<div class="collapse show mt-2" id="collapseOne">
 							<table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
 								<thead class="thead-dark">
 									<tr class="pt-5 table-one" style="height: 32px;">
 										<th style="border-radius: 20px 0 0 0;">Sr No.</th>
 										<th>Department ID</th>
 										<th style="border-radius: 0 20px 0 0;">Department name</th>
 									</tr>
 								</thead>
 								<?php
									$query = "SELECT * FROM department";
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
										echo ">".  $i . " </td>";
										echo "<td>" . $row["dept_id"] . "</td>";
										echo "<td";
										if ($i == $num_rows) {
											echo " style='border-radius:  0 0 20px 0;'";
										}
										echo ">" . $row["dept_name"] . "</td>";
										echo "</tr>";
									}
									?>
 							</table>
 						</div>
 					</section>
 				</div>
 			</div>
 			<div class=" col-lg-7 col-md-12 col-sm-12">
 				<div>
 					<section class="mt-3">
 						<div style=" border-radius: 20px;" class="btn btn-block text-white table-two d-flex">
 							<span class="font-weight-bold"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i> Department's Admin List</span>
 							<a href="" class="ml-auto" data-toggle="collapse" data-target="#collapsetwo"><i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i></a>

 						</div>
 						<div class="collapse show mt-2" id="collapsetwo">
 							<table style="margin-bottom: 10px;" class="w-100 table-dark table-striped table-hover table-elements table-two-tr" cellpadding="2">
 								<thead class="thead-dark">
 									<tr class="pt-5 table-two" style="height: 32px;">
 										<th style="border-radius: 20px 0 0 0;">Sr No.</th>
 										<th>Department ID</th>
 										<th>Admin Name</th>
 										<th style="border-radius: 0 20px 0 0;">Email</th>
 									</tr>
 								</thead>
 								<?php
									$query = "SELECT * FROM admin_info";
									$run = mysqli_query($con, $query);
									$i = 0;
									$num_rows = mysqli_num_rows($run);
									while ($row = mysqli_fetch_array($run)) {
										$i++;
									?>
 									<tr>
 										<td <?php if ($i == $num_rows) {
													echo " style='border-radius: 0 0 0 20px;'";
												} ?>><?php echo $i ?></td>
										<td><?php echo $row["dept_id"] ?></td>
										<td><?php echo $row["name"] ?></td>
 										<td <?php if ($i == $num_rows) {
													echo "style='border-radius:  0 0 20px 0;'";
												} ?>><?php echo $row['email'] ?></td>
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