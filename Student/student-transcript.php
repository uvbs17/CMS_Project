<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!$_SESSION["Logininfo"]) {
    header('location:../login/login.php');
} else {
    $userid = $_SESSION['Logininfo']['user_id'];
    $password = $_SESSION['Logininfo']['password'];
}

?>
<!---------------- Session Ends form here ------------------------>
<?php
function grade($obtain_marks, $assign_date)
{

    if ($assign_date <= 15) {
        if ($obtain_marks >= 85) {
            $grade = "A+";
        } else if ($obtain_marks >= 80) {
            $grade = "A";
        } else if ($obtain_marks >= 75) {
            $grade = "B+";
        } else if ($obtain_marks >= 70) {
            $grade = "B";
        } else if ($obtain_marks >= 65) {
            $grade = "C+";
        } else if ($obtain_marks >= 60) {
            $grade = "C";
        } else if ($obtain_marks >= 55) {
            $grade = "D+";
        } else if ($obtain_marks >= 50) {
            $grade = "D";
        } else {
            $grade = "F";
        }
    } else {
        if ($obtain_marks >= 85 and $obtain_marks) {
            $grade = "A+";
        } else if ($obtain_marks >= 80) {
            $grade = "A";
        } else if ($obtain_marks >= 75) {
            $grade = "B+";
        } else if ($obtain_marks >= 70) {
            $grade = "B";
        } else if ($obtain_marks >= 65) {
            $grade = "C+";
        } else if ($obtain_marks >= 60) {
            $grade = "C";
        } else if ($obtain_marks >= 55) {
            $grade = "D+";
        } else if ($obtain_marks >= 50) {
            $grade = "D";
        } else {
            $grade = "F";
        }
    }

    return $grade;
}
?>

<?php
function gpa($obtain_marks, $assign_date)
{

    if ($assign_date <= 15) {
        if ($obtain_marks >= 80) {
            $gpa = "4.00";
        } else if ($obtain_marks >= 75) {
            $gpa = "3.00";
        } else if ($obtain_marks >= 70) {
            $gpa = "3.00";
        } else if ($obtain_marks >= 65) {
            $gpa = "2.00";
        } else if ($obtain_marks >= 60) {
            $gpa = "2.00";
        } else if ($obtain_marks >= 55) {
            $gpa = "1.00";
        } else if ($obtain_marks >= 50) {
            $gpa = "1.00";
        } else {
            $gpa = "0.00";
        }
    } else {
        if ($obtain_marks >= 80) {
            $gpa = "4.00";
        } else if ($obtain_marks >= 75) {
            $gpa = "3.50";
        } else if ($obtain_marks >= 70) {
            $gpa = "3.00";
        } else if ($obtain_marks >= 65) {
            $gpa = "2.50";
        } else if ($obtain_marks >= 60) {
            $gpa = "2.00";
        } else if ($obtain_marks >= 55) {
            $gpa = "1.50";
        } else if ($obtain_marks >= 50) {
            $gpa = "1.00";
        } else {
            $gpa = "0.00";
        }
    }

    return $gpa;
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
        td {
            height: 45px;
            text-align: center;
            padding: 10px;
        }

        thead tr th {
            height: 45px;
            padding: 10px;
            background-color: darkslategrey;
            color: white;
            text-align: center;
        }

        table {
            border-radius: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
    <title>Student - Transcript</title>
    <!-- css style go to end here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php include('../common/student-sidebar.php') ?>
    <main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
        <div class="container mt-4">
            <div class="text-danger text-center m-auto">
                <img src="../Images/logo.png" alt="" width="216" height="100">
                <h2 class="text-dark mt-3"><b>Bhagwan Mahavir University - BMU</b></h2>
            </div>
        </div>
        <div class="container-fluid mb-4 text-dark">
            <div class="program-info">
                <?php
                $query = "SELECT * FROM student_info WHERE user_id = '$userid' AND password = '$password'";

                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                $enrollment_no = $row["enrollment_no"];
                $query = "select * from student_info inner join sessions on sessions.session=student_info.session where enrollment_no = '$enrollment_no'";
                $run = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($run)) { ?>
                    <h5><b>Student Transcript - </b><?php echo $row['course_code']; ?> Program</h5>
            </div>
            <div class="d-flex mt-3">
                <div>
                    <h5><b>Student Name : </b><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']; ?></h5>
                    <h5><b>S/O : </b><?php echo $row['father_name']; ?></h5>
                </div>
                <div class="ml-auto">
                    <h5><b>Student I.D : </b><?php echo $row['enrollment_no']; ?></h5>
                    
                </div>
            </div>
        <?php }
        ?>
        </div>
        <div class="container-fluid table-font-for-transcript">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class=" table-responsive-md mt-3">
                            <div class=" mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='1' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 1</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $completed_ch = 0;
                                    $total_semester_ch = 0;
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $all_semester_quality_points = 0;
                                    $que = "select * from course_subjects where semester=1 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='2' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 2</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=2 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='3' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 3</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=3 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='4' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 4</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=4 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='5' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 5</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=5 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?><thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='6' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 6</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=6 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?><thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='7' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 7</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=7 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?><thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='8' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 8</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=8 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?><thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;"  colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='9' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 9</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=9 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?>
                                        <tr>
                                            <td><?php echo $row['subject_code'] ?></td>
                                            <td><?php echo $row['subject_name'] ?></td>
                                            <td><?php echo $row['credit_hours'] ?></td>
                                            <?php
                                            $subject = $row['subject_code'];
                                            $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                            $run_result = mysqli_query($con, $result_query);
                                            while ($result_row = mysqli_fetch_array($run_result)) {
                                                $obtain_marks = $result_row['obtain_marks'];
                                                $assign_date = date("y", strtotime($result_row['assign_date']));
                                            }
                                            ?>
                                            <td><?php echo $obtain_marks ?></td>
                                            <?php
                                            $gpa = gpa($obtain_marks, $assign_date);
                                            $grade = grade($obtain_marks, $assign_date);
                                            ?>
                                            <td><?php echo $gpa; ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <?php
                                            $total_ch = $total_ch + $row['credit_hours'];
                                            if ($obtain_marks >= 50) {
                                                $quality_points = $gpa * $row['credit_hours'];
                                                $total_quality_points = $total_quality_points + $quality_points;
                                                $completed_ch = $completed_ch + $row['credit_hours'];
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                        $obtain_marks = "";
                                    }
                                    ?><thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">Total Semester CH</th>
                                            <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                            <th><?php echo $total_ch; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">Semester GPA</th>
                                            <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div>
                        <section class="table-responsive-md mt-3">
                            <div class="mt-2">
                                <table style="margin-bottom: 10px;" class="w-100 table-dark container table-striped table-hover table-elements table-one-tr" cellpadding="2">
                                    <thead class="thead-dark">
                                        <tr class="pt-5 table-six" style="height: 32px;">
                                            <?php
                                            $que = "select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='10' and sc.roll_no='$roll_no'";
                                            $run = mysqli_query($con, $que);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $session = $row['session_name'];
                                                $assign_date = date("Y", strtotime($row['assign_date']));;
                                            }
                                            ?>
                                            <th style="border-radius: 20px 0 0 0;" colspan="2">
                                                <div class="d-flex"><span class="mr-5">Semester - 10</span><span class="ml-5"><?php echo  $assign_date . " " . $session; ?> </span></div>
                                            </th>
                                            <th>CH</th>
                                            <th>%</th>
                                            <th>G.P</th>
                                            <th style="border-radius: 0 20px 0 0;">Letter</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que = "select * from course_subjects where semester=10 order By semester asc";
                                    $run = mysqli_query($con, $que);
                                    while ($row = mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                    ?><thead class="thead-dark">
                                            <tr>
                                                <td><?php echo $row['subject_code'] ?></td>
                                                <td><?php echo $row['subject_name'] ?></td>
                                                <td><?php echo $row['credit_hours'] ?></td>
                                                <?php
                                                $subject = $row['subject_code'];
                                                $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                                $run_result = mysqli_query($con, $result_query);
                                                while ($result_row = mysqli_fetch_array($run_result)) {
                                                    $obtain_marks = $result_row['obtain_marks'];
                                                    $assign_date = date("y", strtotime($result_row['assign_date']));
                                                }
                                                ?>
                                                <td><?php echo $obtain_marks ?></td>
                                                <?php
                                                $gpa = gpa($obtain_marks, $assign_date);
                                                $grade = grade($obtain_marks, $assign_date);
                                                ?>
                                                <td><?php echo $gpa; ?></td>
                                                <td><?php echo $grade; ?></td>
                                                <?php
                                                $total_ch = $total_ch + $row['credit_hours'];
                                                if ($obtain_marks >= 50) {
                                                    $quality_points = $gpa * $row['credit_hours'];
                                                    $total_quality_points = $total_quality_points + $quality_points;
                                                    $completed_ch = $completed_ch + $row['credit_hours'];
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        $obtain_marks = "";
                                    }
                                        ?><thead class="thead-dark">
                                            <tr>
                                                <th colspan="2">Total Semester CH</th>
                                                <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                                <th><?php echo $total_ch; ?></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                            <tr>
                                                <th colspan="2">Total C.H for Graduation</th>
                                                <th><?php echo $total_semester_ch; ?></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                            <tr>
                                                <th colspan="2">C.H Completed</th>
                                                <th><?php echo $completed_ch ?></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th colspan="4">.</th>
                                            <th colspan="2">.</th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                            <tr>
                                                <th colspan="4">Semester GPA</th>
                                                <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                                <th colspan="2"><?php echo  round($total_quality_points / $total_ch, 2); ?></th>
                                            </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                            </tr>
                                            <th style="border-radius: 0 0 0 20px;" colspan="4">CGPA</th>
                                            <th style="border-radius:  0 0 20px 0;" colspan="2"><?php echo round(($all_semester_quality_points / $total_semester_ch), 2) ?></th>
                                            </tr>
                                        </thead>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row text-center font-weight-bold mb-5">
                <div class="col-xl-4">PREPARED BY</div>
                <div class="col-xl-4">DEAN</div>
                <div class="col-xl-4">CONTROLLER EXAMINATIONS</div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>