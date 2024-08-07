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
}
?>
<!---------------- Session Ends form here ------------------------>

<!-- --------------------------------DELETE STREAM------------------------------------- -->
<?php
if(isset($_GET['del_stream_id']))
{
	$del_id = $_GET['del_stream_id'];
	$del_query = "DELETE FROM `stream` WHERE id='$del_id'";
	$del_run = mysqli_query($con, $del_query);
	if($del_run)
	{
		echo "<script>window.location.href='stream.php';</script>";
	}
	else{
		$err = mysqli_error($con);
		echo "<script>alert('Error :$err.');</script>";
		echo "<script>window.location.href='stream.php';</script>";

	}
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
		div.modal-header.bg-info.text-white {
			border-radius: 20px;
			margin: 10;
		}

		table {
			border-radius: 30px;
			text-align: center;
		}

		a.btn.btn-primary {
			border-radius: 20px 0 0 20px;
		}

		a.btn.btn-danger {
			border-radius: 0 20px 20px 0;
		}

		@media only screen and (max-width: 767px) {
			a.btn.btn-primary {
				border-radius: 20px;
				margin: 2px;
			}

			a.btn.btn-danger {
				border-radius: 20px;
				margin: 2px;
			}


			button.btn.btn-primary.ml-auto {
				width: 100%;
				margin-bottom: 4px;
			}

			a.btn.btn-success {
				width: 100%;
				margin-bottom: 4px;
			}

			button.btn.btn-primary.stdadd {
				width: 100%;
				margin-bottom: 4px;
			}

		}


		a.btn.btn-success {
			border-radius: 30px;
		}

		button.btn.btn-primary.ml-auto {
			border-radius: 30px;
		}

		button.btn.btn-primary.stdadd {
			border-radius: 30px;
		}

		.btn {
			border: 0;
		}

		.btn-primary {
			border: 0;
		}

		td {
			height: 50px;
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

		div.modal-content {
			border-radius: 30px;
		}

		select.browser-default.custom-select {
			border-radius: 20px;
		}


		input.form-control {
			border-radius: 20px;
		}

		input.btn.btn-primary {
			border-radius: 20px;
		}

		button.btn.btn-secondary {
			border-radius: 20px;
		}

		td.button {
			margin-top: 11px;
			display: inline-table;
		}

		/* Pagination styles */
		.pagination {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 20px;
		}

		.pagination li {
			display: inline-block;
			margin: 0 5px;
		}

		.pagination li a {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 30px;
			border-radius: 5px;
			color: #333;
			background-color: #fff;
			border: 1px solid #ccc;
			text-decoration: none;
			font-size: 14px;
			font-weight: bold;
			transition: background-color 0.2s ease;
			padding: 5px 10px;
		}

		.pagination li.active a,
		.pagination li a:hover {
			background-color: #007bff;
			border-color: #007bff;
			color: #fff;
		}

		.pagination li.disabled a {
			background-color: #ccc;
			border-color: #ccc;
			color: #666;
			pointer-events: none;
		}

		.material-icons {
			font-family: 'Material Icons';
			font-weight: normal;
			font-style: normal;
			font-size: 18px;
			line-height: 1;
			text-transform: none;
			letter-spacing: normal;
			word-wrap: normal;
			white-space: nowrap;
			direction: ltr;
		}
	</style>
	<title>Stream managment</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include('../common/uni_admin-sidebar.php') ?>
	<main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
		<div class="sub-main">

			<div class="p-0 rounded text-center">
				<h1>Stream Management System</h1>
			</div>
			<div class="container">
				<div class="modal-body">
					<?php
					// define a function to fetch data from the database
					function get_course_data($con, $stream_id)
					{
						$query = "SELECT * FROM stream WHERE id='$stream_id'";
						$result = mysqli_query($con, $query);
						return mysqli_fetch_assoc($result);
					}

					if (isset($_GET['stream_id'])):
						$stream_id = $_GET['stream_id'];
						$row = get_course_data($con, $stream_id);
						?>
						<form action="function.php" method="post">
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group">
										<input type="hidden" name="action" value="update">
										<label for="exampleInputEmail1">Stream : </label>
										<input value="<?php echo !empty($row['stream_name']) ? $row['stream_name'] : ''; ?>"
											type="text" name="stream_name" class="form-control" required
											placeholder="Enter Stream" >
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<!-- <label for="exampleInputPassword1">Deaprtment Name:</label> -->
										<input value="<?php echo !empty($row['id']) ? $row['id'] : ''; ?>"
											type="hidden" name="stream_id" class="form-control" required
											placeholder="Enter Department Name" readonly>
									</div>
								</div>
							</div>
							<div class="row w-100">
								<div class="col-md-12">
									<input type="submit" name="stream_sub" value="Update" class="btn btn-primary ml-auto">
								</div>
							</div>
						</form>
					<?php else: ?>
						<form action="function.php" method="post">
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group">
										<input type="hidden" name="action" value="insert">
										<label for="exampleInputEmail1">Stream : </label>
										<input value="" type="text" name="stream_name" class="form-control" required
											placeholder="Enter Stream">
									</div>
								</div>
								<div class="col-md-6">
									<!-- <div class="form-group">
										<label for="exampleInputPassword1">Department Name:</label>
										<input value="" type="text" name="dept_name" class="form-control" required
											placeholder="Enter Department Name">
									</div> -->
								</div>
							</div>
							<div class="row w-100">
								<div class="col-md-12">
									<input type="submit" name="stream_sub" value="Insert" class=" btn btn-primary ml-auto">
								</div>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-1 ml-2 table-responsive-md"></div>
			<div class="col-md-10 ml-2 table-responsive-md">
				<section class="mt-3">
					<table style="margin-left: 0 ; margin-right:0;"
						class="w-100  table-dark container table-striped table-hover table-elements table-one-tr "
						cellpadding="10">
						<thead class="thead-dark">
							<tr class="table-tr-head table-three text-white">
								<th style="border-radius: 20px 0 0 0;">Sr.No</th>
								<th>Stream Name</th>
								<th colspan="2" style="border-radius: 0 20px 0 0;">Actions</th>
							</tr>
						</thead>
						<?php
						$rows_per_page = 10;
						if (isset($_GET['page'])) {
							$page = intval($_GET['page']);
						} else {
							$page = 1;
						}
						$sr = ($page - 1) * $rows_per_page + 1;

						$query = "SELECT * FROM stream LIMIT " . ($page - 1) * $rows_per_page . ",$rows_per_page";
						$run = mysqli_query($con, $query);
						while ($row = mysqli_fetch_array($run)) {
							echo "<tr>";
							echo "<td>" . $sr++ . "</td>";
							echo "<td>" . $row['stream_name'] . "</td>";?>
							<td width='170' class="button">
								<a class="btn btn-primary mr-1"
									href="stream.php?stream_id=<?= $row['id'] ?>">Update</a>
								<a class="btn btn-danger" href="stream.php?del_stream_id=<?= $row['id'] ?>"
									onclick="return confirm('Are you sure you want to delete this Stream?')">Delete</a>
							</td>
							<?php echo "</tr>";
						}

						if (isset($_GET['page'])) {
							$current_page = $_GET['page'];
						} else {
							$current_page = 1;
						}
						$total_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM stream"));
						$total_pages = ceil($total_rows / $rows_per_page);

						?>
					</table>

					<?php if ($total_pages) { ?>
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center mt-3">
								<li class="page-item <?php echo ($current_page == 1 ? 'disabled' : ''); ?>">
									<a class="page-link"
										href="<?php echo ($current_page === 1 ? '#' : '?page=' . ($current_page - 1)); ?>"
										tabindex="-1">
										<i class="material-icons">chevron_left</i> Previous
									</a>
								</li>
								<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
									<li class="page-item <?php echo ($current_page == $i ? 'active' : ''); ?>">
										<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
									</li>
								<?php } ?>
								<li class="page-item <?php echo ($current_page == $total_pages ? 'disabled' : ''); ?>">
									<a class="page-link"
										href="<?php echo ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1)); ?>">
										Next <i class="material-icons">chevron_right</i>
									</a>
								</li>
							</ul>
						</nav>
					<?php } ?>

				</section>
			</div>
			<div class="col-md-1 ml-2 table-responsive-md"></div>
		</div>


		</div>
	</main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>