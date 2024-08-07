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
<?php
$course_code = "";
$row = "";
$select = 1;
$option = "";
$semester = "";
if (isset($_GET['course_code'])) {
    $course_code = $_GET['course_code'];
    $query = "SELECT * FROM courses WHERE course_code ='$course_code'";
    $result = mysqli_query($con, $query);
    if ((mysqli_num_rows($result)) > 0) {
        $row = mysqli_fetch_array($result);
        $semester = $row["no_of_semester"];
    } else {
        echo "<script>alert ('NO data found');</script>";
        echo "<script>window.location.href='time-table.php';</script>";
    }
}

if (isset($_POST['sem'])) {
    $select = $_POST['sem'];
    $option = '<option value="' . $select . '"selected hidden>' . $select . '</option>';
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
        td 
        {
			height: 45px;
			text-align: center;
		}

		thead tr th 
        {
			height: 45px;
			background-color: darkslategrey;
			color: white;
			text-align: center;
		}

		div.btn.btn-block.table-one.d-flex 
        {
			background-color: #245e71;
		}

		div.btn.btn-block.table-three.d-flex 
        {
			background-color: #245e71;
		}

		div.btn.btn-block.table-two.d-flex 
        {
			background-color: #245e71;
		}

		table 
        {
			border-radius: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}
    </style>
    <title>Promote Student</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- css style go to end here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include('../common/admin-sidebar.php') ?>
    <main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 pt-4 mb-2 w-100">
        <div class="sub-main">
            <div class="p-0 rounded text-center">
                <h1>
                    <?php echo $row['course_name'] . "(" . $row['course_code'] . ")"; ?>
                </h1>
            </div>  
        <div class="row">
            <div class="col-md-12">
                <form id="filter" action="promote_class.php?course_code=<?= $course_code ?>" method="post">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Semester:</label>
                                <div class="d-flex">
                                    <select class="browser-default custom-select" name="sem" required=""
                                        id="sem_select">
                                        <option value="" hidden>Select Semester</option>
                                        <?php
                                        //$course_code = $_GET['course_code'];
                                        echo $option;
                                        $sem = $row['no_of_semester'];
                                        $select_options = '';
                                        for ($i = 1; $i <= $sem; $i++) {
                                            $select_options .= '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        echo $select_options;
                                        ?>
                                    </select>
                                    <script>
                                        const select = document.getElementById("sem_select");
                                        select.addEventListener("change", function () {
                                            document.getElementById("filter").submit();
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 align-items-baseline pt-4" style="text-align: center;"></div>
                        <div class="col-md-3 align-items-baseline pt-4" style="text-align: center;"></div>
                    </div>
                </form>
            </div>
        </div>
        <?php 
            // echo $_POST['sem']; 
            $class = "SELECT * FROM class WHERE course_code = '$course_code' AND sem='$select'";
            $c_run = mysqli_query($con , $class);
            if((mysqli_num_rows($c_run)) > 0)
            {
                $class_id = "";
                while($c_row = mysqli_fetch_assoc($c_run))
                {
                    $class_id = $c_row['class_id'];
        ?>
                    <div class="row">
                        <div class="col-md-12 ml-2">
                            <section class="mt-3">
                                <div style=" border-radius: 20px;" class="btn btn-block text-white table-two d-flex">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>Class : <?php echo $class_id;?>
                                    </span>
                                    <a class="ml-auto">
                                        <i class="ml- auto" aria-hidden="true"></i><b>Sem : <?php echo $select;?></b>
                                    </a>
                                    
                                    <a href="" class="ml-auto" data-toggle="collapse" data-target="#collapse<?php echo $class_id; ?>">
                                        <i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;"
                                            aria-hidden="true">
                                        </i>
                                    </a>
                                </div>
                                <div class="collapse show mt-2" id="collapse<?php echo $class_id; ?>">
                                    <table style="margin-bottom: 10px;"
                                        class="w-100 table-dark container table-striped table-hover table-elements table-one-tr"
                                        cellpadding="5">
                                        <thead class="thead-dark">
                                            <tr class="table-tr-head text-white table-three">
                                                <th style="border-radius: 20px 0 0 0;">Sr.No</th>
                                                <th>Enrollment No</th>
                                                <th>Student Name</th>
                                                <th>Cource Name</th>
                                                <th>Semester</th>
                                                <th>Fees Status</th>
                                                <th style="border-radius: 0 20px 0 0;">Overall Exam Status</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 0;
                                        $count = 0;
                                        $res = 0;
                                        $fee = 0;
                                            $que = "SELECT * FROM student_info  
                                            WHERE course_code = '$course_code' AND current_semester = '$select' AND class_id = '$class_id' ";
                                            $run = mysqli_query($con, $que);
                                            if((mysqli_num_rows($run)) > 0)
                                            {
                                                while ($row = mysqli_fetch_array($run)) 
                                                {
                                                    $count++;
                                        ?>
                                                    <form action="promote_function.php" method="post">
                                                        <tr>
                                                            <td>
                                                                <?php echo ($i+1); $i++; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['enrollment_no'] ?>
                                                            </td>
                                                            <input type="hidden" name="enrollment_no[<?php echo $i;?>]" value=<?php echo $row['enrollment_no'] ?>>
                                                            <td>
                                                                <?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['course_code'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['current_semester'] ?>
                                                                <input type="hidden" name="sem" value=<?php echo $row['current_semester'] ?>>
                                                                <input type="hidden" name="crs" value=<?php echo $course_code ?>>
                                                                <input type="hidden" name="admin_dep_id" value=<?php echo $admin_dept_id ?>>
                                                                <input type="hidden" name="count[<?php echo $i;?>]" value=<?php echo $i; ?>>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    if($row['fees_status'] == 'unpaid')
                                                                    {
                                                                        echo "fees not Updated";
                                                                        $fee = $fee + 1 ; 
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $row['fees_status'];
                                                                    }

                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    if($row['exam_status'] == '')
                                                                    {
                                                                        echo "Result not Updated";
                                                                        $res = $res + 1 ; 
                                                                    }
                                                                    elseif($row['exam_status'] == '0')
                                                                    {
                                                                        echo "Failed";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "Passed";
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                                if($fee == 0)
                                                {
                                                    if($res == 0)
                                                    {
                                                        echo '<tr><td colspan="7"><input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Promote" name="res-btn" /></td></tr>';
                                                    }
                                                    else
                                                    {
                                                        echo '<tr><td colspan="7">'.$res.'  Student\'s Result pending</td></tr>';

                                                    }
                                                }
                                                else
                                                {
                                                    echo '<tr><td colspan="7">'.$fee.'  Student\'s Fees pending</td></tr>';
                                                }
                                            }
                                            else
                                            {
                                                echo "<tr><td colspan='7'>No student Found </td></tr>";
                                            }
                                        ?>
                                        </form>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
        <?php
                }
            }
            else
            {
                echo "<center><h2> No Class Found</h2></center>";
            }
        ?>
        </div>
    </main>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>