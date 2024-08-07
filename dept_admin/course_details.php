<?php include('../common/header.php') ?>
<?php
// session_start();
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
	$admin_dept_id = substr($row["dept_id"], 0, 2);
	$admin_name = $row["name"];
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
            table {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		    }
            a.btn.btn-primary {
			border-radius: 20px 0 0 20px;
		    }
            a.btn.btn-danger {
                border-radius: 0 20px 20px 0;
            }
            @media only screen and (max-width: 767px) 
            {
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
        <title>Course Details</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- css style go to end here -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php include('../common/admin-sidebar.php') ?>
        <main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 pt-4 mb-2 w-100">
        <?php    
            if(isset($_GET['course_code']))
            {
                $course_code = $_GET['course_code'];
                //echo "<script>alert ('$course_code');</script>";
                $query = "SELECT * FROM courses WHERE course_code ='$course_code'";
                $result = mysqli_query($con,$query);
                if((mysqli_num_rows($result)) > 0)
                {
                    $row = mysqli_fetch_array($result);
                }
                else
                {
                    echo "<script>alert ('NO data found');</script>";
        			echo "<script>window.location.href='courses.php';</script>";
                }
                //print_r($row);
                $semester = $row["no_of_semester"];
        ?>
		<div class="p-0 rounded text-center">
			<h1><?php echo $row['course_name']."(". $row['course_code'].")"; ?></h1>
		</div>
        <?php 
            $cur_sem = 0;
            while($cur_sem < $semester)
            {
                if($cur_sem  % 2 == 0)
                {
                    ?><div class="row"><?php
                }
        ?>
        <div class="col-lg-6 col-md-12 col-sm-12 ">
            <div>
                <section class="mt-3">
                    <div style=" border-radius: 20px;" class="btn btn-block table-one text-white d-flex">
                        <span class="font-weight-bold"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i><?php echo "Semester " .($cur_sem+1); ?></span>
                        <a href="" class="ml-auto font-weight-bold" data-toggle="collapse" data-target="#collapseOne<?php echo $cur_sem; ?>">
                            <i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="collapse show mt-2" id="collapseOne<?php echo $cur_sem; ?>">
                        <table style="margin-bottom: 10px;"
                            class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
                            cellpadding="2">
                            <thead class="thead-dark">
                                <tr class="pt-5 table-one" style="height: 32px;">
                                    <th style="border-radius: 20px 0 0 0;">Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Type</th>
                                    <th>Credits</th>
                                    <th style="border-radius: 0 20px 0 0;">Actions</th>
                                </tr>
                            </thead>
                            <?php
                            $cur_sem1 = $cur_sem + 1;
                            $query = "SELECT * FROM subjects WHERE course_code='$course_code' AND semester='$cur_sem1'";
                            $run = mysqli_query($con, $query);
                            if((mysqli_num_rows($run) > 0))
                            {
                                $i = 0;
                                $num_rows = mysqli_num_rows($run);
                                while ($row = mysqli_fetch_array($run)) {
                                    $i++;
                                    echo "<tr>";
                                    echo "<td";
                                    if ($i == $num_rows) {
                                        echo " style='border-radius: 0 0 0 20px;'";
                                    }
                                    echo ">" . $row["subjects_code"] . "</td>";
                                    echo "<td>" . $row["subjects_name"] . "</td>";
                                    echo "<td>" . $row["type"] . "</td>";
                                    echo "<td>" . $row["credits"] . "</td>";
                                    echo "<td width='170' class='button'";
                                    if ($i == $num_rows) {
                                        echo " style='border-radius:  0 0 20px 0;'";
                                    }
                                    echo ">" ; ?>
                                    <a class="btn btn-primary mr-1"
									href="subjects.php?subject_code=<?= $row['subjects_code'] ?>">Update
                                    </a><a class="btn btn-danger" href="subjects.php?del_sub_code=<?= $row['subjects_code']?>&course_code=<?= $row['course_code']?>"
									onclick="return confirm('Are you sure you want to delete this Subject?')">Delete</a>
                                    <?php
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            else
                            {
                               echo "<tr><td colspan='6' style='text-align: center;'>No Data Found.</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        <?php
            $cur_sem++;
            if($cur_sem  % 2 == 0)
                {
                    ?></div><?php
                }
                }
            }
        ?>
        <script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>