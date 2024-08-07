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

//-----------------------------Semester filter

if (isset($_POST['sem'])) {
    $select = $_POST['sem'];
    $option = '<option value="' . $select . '"selected hidden>' . $select . '</option>';
}
function get_t_id($course_code, $class_id, $semester, $con)
{

    $query1 = "SELECT course_id FROM courses WHERE course_code = ?";
    $stmt = mysqli_prepare($con, $query1);
    mysqli_stmt_bind_param($stmt, "s", $course_code);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result1);
    $course = $row["course_id"];
    $course_id = str_pad($course, 2, '0', STR_PAD_LEFT);

    // Check if there is any existing subjects code for the given combination
    $query = "SELECT id FROM time_table WHERE class_id = ? AND course_code = ? AND sem = ? ORDER BY id DESC LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $class_id, $course_code, $semester);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $sem = str_pad($semester, 2, '0', STR_PAD_LEFT);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // If there is an existing subjects code, increment the last 2 digits by 1
        mysqli_stmt_bind_result($stmt, $last_subjects_code);
        mysqli_stmt_fetch($stmt);
        $last_digits = substr($last_subjects_code, -2);
        $next_digits = str_pad(intval($last_digits) + 1, 2, '0', STR_PAD_LEFT);
        $next_subjects_code = $course_id . $class_id . $sem . $next_digits;

    } else {
        // If there is no existing subjects code, start from 01
        $next_subjects_code = $course_id . $class_id . $sem . "01";
    }

    return $next_subjects_code;
}

//--------------------------------Insert button------------------------

if (isset($_POST['btn_save'])) {
    $course_code = $_POST['course_code'];
    $semester = $_POST['semester'];
    $time = $_POST['time'];
    $day = $_POST['day'];
    $subject_code = $_POST['subject_code'];
    $class_id = $_POST['class'];
    $room = $class_id;

    $id = get_t_id($course_code, $class_id, $semester, $con);

    $check = "SELECT * FROM time_table WHERE class_id='$class_id' AND day='$day' AND time='$time' AND sem='$semester' AND course_code='$course_code'";
    $check_query = mysqli_query($con, $check);
    $count = mysqli_num_rows($check_query);
    if ($count == 0) {
        $insert = "INSERT INTO `time_table`(`id`, `class_id`, `day`, `time`,  `subject_code`, `course_code`, `sem`, `room`) 
        VALUES ('$id','$class_id','$day','$time','$subject_code','$course_code','$semester','$room')";
        $insert_run = mysqli_query($con, $insert);
        if ($insert_run) {
            // echo "<script>alert('There was an error inserting your record.');</script>";
            echo "<script>window.location.href='course_time-table.php?course_code=$course_code';</script>";
        } else {
            echo "<script>alert('There was an error inserting your record.');</script>";
            echo "<script>window.location.href='course_time-table.php?&course_code=$course_code';</script>";
        }
    } else {
        echo "<script>alert('The Class is Occupied.');</script>";
        echo "<script>window.location.href='course_time-table.php?&course_code=$course_code';</script>";

    }

}

//------------------------------------Delete button-------------------------

if (isset($_GET['del'])) {
    $del = $_GET['del'];
    $crs = $_GET['course_code'];
    $del = "DELETE FROM `time_table` WHERE `id`='$del'";
    $del_run = mysqli_query($con, $del);
    if ($del_run) {
        echo "<script>alert('Record Deleted Scuessfully.');</script>";
        echo "<script>window.location.href='course_time-table.php?course_code=$crs';</script>";
    } else {
        $err = mysqli_error($con);
        echo "<script>alert('Error processing your Request : $err.');</script>";
        echo "<script>window.location.href='course_time-table.php?course_code=$crs';</script>";
    }
}




$time_from = ['08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 12:30', '12:30 - 01:30', '01:30 - 02:30'];
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
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

        div.btn.btn-block.table-one.text-white.d-flex {
            background-color: #245e71;
        }

        div.btn.btn-block.text-white.table-three.d-flex {
            background-color: #245e71;
        }

        div.btn.btn-block.text-white.table-two.d-flex {
            background-color: #245e71;
        }

        /* Table styling */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #343a40;
            /* dark gray */
            color: white;
        }

        /* tr:nth-child(even) {background-color: #f2f2f2;} alternate row color */

        .table-one-tr {
            border-radius: 0px !important;
        }

        td.day-col {
            /* background-color: #d6d6c2;  */
        }

        /* Button styling */
        .btn {
            border-radius: 20px;
            font-size: 16px;
            padding: 10px 20px;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        /* Dropdown menu styling */
        .select-wrapper {
            position: relative;
            display: inline-block;
            margin: 0 5px;
        }

        div.btn.btn-block.table-one.text-white.d-flex {
            margin-bottom: 0;
        }

        select.timedel {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-position: right center;
            background-repeat: no-repeat;
            padding-right: 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            color: black;
        }

        /* Caret down icon styling */
        .fa-caret-down {
            transform: rotate(90deg);
            transition: transform ease-in-out 0.3s;
        }

        .custom-dropdown:hover .fa-caret-down {
            transform: rotate(-90deg);
        }

        /* Highlighting selected option */
        option[hidden] {
            display: none;
        }

        option[selected] {
            background-color: yellow;
            color: black;
        }

        /* Dropdown menu styling */
        .select-wrapper {
            position: relative;
            display: inline-block;
            margin: auto;
        }

        select.timedel {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-position: right center;
            background-repeat: no-repeat;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            color: black;
        }

        /* Caret down icon styling */
        .fa-angle-down {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #aaa;
            transition: all ease-in-out 0.3s;
        }

        .select-wrapper:hover .fa-angle-down {
            color: #555;
        }

        /* Highlighting selected option */
        option[hidden] {
            display: none;
        }

        option[selected] {
            background-color: yellow;
            color: black;
        }

        td {
            text-align: center;
        }

        select.timedel {
            border: 1px solid;
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
        <div class="sub-main">
            <div class="p-0 rounded text-center">
                <h1>
                    <?php echo $row['course_name'] . "(" . $row['course_code'] . ")"; ?>
                </h1>
            </div>
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-3 ml-5 ">
                    <div class="col-md-12 pt-3 ml-5">
                        <!-- Large modal -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h4 class="modal-title text-center">Add Time Table</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="course_time-table.php?course_code=<?= $course_code ?>"
                                            method="post">
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Course Code:</label>
                                                        <input type="text" name="course_code" class="form-control"
                                                            value="<?php echo $course_code; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Semester:</label>
                                                        <input type="text" name="semester" class="form-control"
                                                            value="<?php echo $select; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Timing From:</label>
                                                        <select class="browser-default custom-select" name="time">
                                                            <?php
                                                            echo "<option value=''hidden>Select Time</option>";
                                                            foreach ($time_from as $time) {
                                                                if ($time != '12:00 - 12:30') {
                                                                    //break;
                                                                    echo "<option value='$time'>" . $time . "</option>";
                                                                } else {
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Class:</label>
                                                        <select class="browser-default custom-select" name="class"
                                                            required="">
                                                            <option hidden>Select Class</option>
                                                            <?php
                                                            $d_query = "SELECT * FROM class WHERE course_code='$course_code' AND sem ='$select'";
                                                            $d_run = mysqli_query($con, $d_query);
                                                            if ($d_run) {
                                                                while ($d_row = mysqli_fetch_array($d_run)) {

                                                                    echo "<option value=" . $d_row['class_id'] . ">" . $d_row['class_id'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Lecture Day:</label>
                                                        <select class="browser-default custom-select" name="day">
                                                            <option hidden>Select Week Day</option>
                                                            <?php
                                                            $dd = 1;
                                                            foreach ($days as $d) {
                                                                echo "<option value='$dd'>" . $d . "</option>";
                                                                $dd++;
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="formp">
                                                        <label for="exampleInputPassword1">Please Select
                                                            Subject:*</label>
                                                        <select class="browser-default custom-select"
                                                            name="subject_code" required="">
                                                            <option hidden>Select Subject</option>
                                                            <?php
                                                            $s_query = "SELECT * FROM subjects where course_code = '$course_code' AND semester = '$select'";
                                                            $s_run = mysqli_query($con, $s_query);
                                                            while ($s_row = mysqli_fetch_array($s_run)) {
                                                                echo "<option value=" . $s_row['subjects_code'] . ">" . $s_row['subjects_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary" name="btn_save"
                                                    value="Save Data">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                a span span {
                    color: #ffffff;
                }

                a {
                    text-decoration: none;
                    color: white;
                }

                div.btn {
                    display: grid;
                    margin-bottom: 50px;
                }

                .home {
                    font-weight: bold;
                    color: white;
                    border-radius: 2rem;
                    width: 95.02px;
                    margin: auto;
                    height: 42.66px;
                    border: none;
                    background-color: #3653f8;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .home .span-mother {
                    display: flex;
                    overflow: hidden;
                }
            </style>
            <div class="row">
                <div class="col-md-12">
                    <form id="filter" action="course_time-table.php?course_code=<?= $course_code ?>" method="post">
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
                            <div class="col-md-3 align-items-baseline pt-4" style="text-align: center;">
                                <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                    data-target=".bd-example-modal-lg">Add Time Table</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            //print_r($row);
            $class_query = "SELECT * FROM class WHERE course_code='$course_code' AND sem='$select'";
            $class_run = mysqli_query($con, $class_query);
            $if = "";
            $div = "";
            $class = "";
            if ((mysqli_num_rows($class_run) > 0)) {
                $if = 1;
                $cur_class = 0;
                while ($class_row = mysqli_fetch_assoc($class_run)) {
                    // print_r($class_row);
                    $div = $class_row['division'];
                    $class = $class_row['class_id'];
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <div>
                                <section class="mt-3">
                                <div style="border-radius: 20px;" class="btn btn-block table-one text-white d-flex">
    <span class="font-weight-bold">
        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
        <?php echo "Div : " . $div . "   "; ?>
        <?php echo "&nbsp |&nbsp "; ?>
    </span>
    <span class="font-weight-bold">
        <i class="" style="text-align: center;" aria-hidden="true"></i>
        <?php echo "Class : " . $class; ?>
    </span>
    <a href="" class="ml-auto font-weight-bold" data-toggle="collapse" data-target="#collapseOne<?php echo $class; ?>">
        <i class="fa text-white fa-caret-down" style="color: black; padding-top: 5px;" aria-hidden="true"></i>
    </a>
</div>

<!-- JavaScript -->
<script>
    window.addEventListener('DOMContentLoaded', function() {
        var collapseElement = document.querySelector("#collapseOne<?php echo $class; ?>");
        var toggleButton = document.querySelector("[data-target='#collapseOne<?php echo $class; ?>']");

        collapseElement.classList.remove("show");
        toggleButton.classList.remove("collapsed");
    });
</script>

                                    <div class="collapse table-responsive show mt-2" id="collapseOne<?php echo $class; ?>">
                                        <table style="margin-bottom: 10px;"
                                            class="w-100 table container table-striped table-hover table-elements table-one-tr custom-timetable"
                                            cellpadding="2">
                                            <thead class="thead">
                                                <tr class="pt-5 table-one" style="height: 32px;">
                                                    <th>Time</th>
                                                    <th>Monday</th>
                                                    <th>Tuesday</th>
                                                    <th>Wednesday</th>
                                                    <th>Thursday</th>
                                                    <th>Friday</th>
                                                    <th>Saturday</th>
                                                    <th>Delete Lecture</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            foreach ($time_from as $time) {
                                                if ($time != '12:00 - 12:30') {
                                                    $del_id[$time] = array();
                                                    echo "<tr>";
                                                    echo "<td>" . $time . "</td>";
                                                    $i = 1;
                                                    foreach ($days as $d) {
                                                        $tt_query = "SELECT t.*, s.subjects_name, f.first_name, f.last_name 
                                                                FROM time_table AS t 
                                                                INNER JOIN subjects AS s ON s.subjects_code = t.subject_code
                                                                LEFT JOIN teacher_info AS f ON t.subject_code = f.teaching_subject
                                                                WHERE t.course_code='$course_code' AND t.sem='$select' AND t.class_id='$class' AND t.day = '$i' AND t.time ='$time' 
                                                                ORDER BY t.day ASC , t.time ASC;";
                                                        $tt_run = mysqli_query($con, $tt_query);
                                                        $cur_class++;
                                                        $c = "";
                                                        $id = "";
                                                        if (mysqli_num_rows($tt_run) > 0) {
                                                            $tt_row = mysqli_fetch_assoc($tt_run);
                                                            $c = ($tt_row['room'] . " - " . $tt_row['subjects_name'] . "<br>" . $tt_row['first_name'] . $tt_row['last_name']);
                                                            $id = $tt_row['id'];
                                                        }
                                                        echo "<td class='day-col'>" . $c . "</td>";
                                                        $del_id[$time][$i] = $id;
                                                        $i++;
                                                    }
                                                } else {
                                                    echo "<tr>
                                                                <td>$time</td>
                                                                <td colspan='7' style='text-align: center;'>Break.</td></tr>";
                                                    continue;
                                                }
                                                ?>
                                                <td width='170' class='button'>
                                                    <div class="custom-dropdown">
                                                        <form action="" method="post" id="delete-form">
                                                            <input type="hidden" value="<?php echo $course_code; ?>" name="crs">
                                                            <div class="select-wrapper">
                                                                <select class="timedel" name="del" id="dele">
                                                                    <option value="" hidden>Select</option>
                                                                    <?php
                                                                    $j = 1;
                                                                    foreach ($days as $d) {
                                                                        echo "<option value='" . $del_id[$time][$j] . "'>" . $d . "</option>";
                                                                        $j++;
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <i class="fa fa-angle-down"></i>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                                <?php
                                                echo "</tr>";
                                            }
                                            ?>
                                        </table>
                                    </div>

                                    <script>
                                        var selec = document.getElementsByClassName("timedel");
                                        var courseCode = "<?php echo $course_code; ?>"; // Pass the variable value to JavaScript
                                        for (var i = 0; i < selec.length; i++) {
                                            selec[i].addEventListener("change", function () {
                                                var selectedClass = this.value;
                                                var confirmed = confirm("Are you sure you want to delete " + selectedClass + "?");
                                                if (confirmed) {
                                                    // Submit the form with the correct action URL including the course code parameter
                                                    var url = 'course_time-table.php?course_code=' + courseCode + '&del=' + selectedClass + '';
                                                    window.location.href = url;
                                                }
                                            });
                                        }
                                    </script>

                                    </table>
                            </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php
                }
            } else {
                echo '<h2 style="text-align:center;"> No class Found. </h2><br><div class="btn">
                <button style="width: 130;" class="home"><a href="/CMS/dept_admin/class.php">
                        <span class="span-mother">
                            <span>A</span>
                            <span>D</span>
                            <span>D</span>
                            <span>&nbsp;</span>
                            <span>C</span>
                            <span>L</span>
                            <span>A</span>
                            <span>S</span>
                            <span>S</span>
                        </span></a>
                </button>
            </div>';
            }
            ?>
        </div>

        <div class="btn">
            <button class="home"><a href="/CMS/dept_admin/time-table.php">
                    <span class="span-mother">
                        <span>G</span>
                        <span>o</span>
                        <span>&nbsp;</span>
                        <span>B</span>
                        <span>A</span>
                        <span>C</span>
                        <span>K</span>
                    </span></a>
            </button>
        </div>
    </main>
    <script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>