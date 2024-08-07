<?php include('../common/header.php') ?>
<?php
//session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!isset($_SESSION["Logininfo"])) {
		echo '<script type="text/javascript">window.location.href = "index.php";</script>';
	}  else {
    $userid = $_SESSION['Logininfo']['user_id'];
    $password = $_SESSION['Logininfo']['password'];
   
	$query = "SELECT *
    FROM department AS d
    INNER JOIN teacher_info AS t
    ON t.dept_id = d.dept_id
    WHERE t.user_id = '$userid'
    AND t.password = '$password'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);

    $teacher_code = $row["teacher_code"];
    $pass = $row["password"];
    $name = $row["first_name"];
    $dept_id = $row["dept_id"];
    $email = $row["email"];
    $dept = $row["dept_name"];
    //echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['user_type']) && $_POST['user_type'] == "all_students") {
        // Insert a new notification for all students
        $user_student = isset($_POST['user_student']);
        $duration = isset($_POST["duration"]) ? $_POST["duration"] : '';
        $insert_query = "INSERT INTO notifications (title, message, sender_id, usertype, duration) 
                         VALUES (?, ?, ?, 'student', ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "ssss", $_POST['title'], $_POST['message'], $row["first_name"], $duration);

        if (mysqli_stmt_execute($stmt)) {
            // Notification inserted successfully
        } else {
            echo "<script> alert ('Record not inserted');</script>";
        }
        mysqli_stmt_close($stmt);
    } 
    if (isset($_POST['user_type']) && $_POST['user_type'] == "specific_user") {
        // Insert a new notification for a specific user
        $duration = isset($_POST["duration"]) ? $_POST["duration"] : '';

        $insert_query = "INSERT INTO notifications (title, message, sender_id, receiver_id, duration) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssis", $_POST['title'], $_POST['message'], $row["first_name"], $_POST['user_id'], $duration);

        if (mysqli_stmt_execute($stmt)) {
            // Notification inserted successfully
        } else {
            echo "<script> alert ('Record not inserted');</script>";
        }
        mysqli_stmt_close($stmt);
    } 
    if(isset($_POST['user_type']) && $_POST['user_type'] == "class") {
        // Insert a new notification for a class of users
        // $class = "403";
        $class = isset($_POST["class_id"]) ? $_POST["class_id"] : '';
        $duration = isset($_POST["duration"]) ? $_POST["duration"] : '';
        $insert_query = "INSERT INTO notifications (title, message, sender_id, usertype, duration) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssss", $_POST['title'], $_POST['message'], $row["first_name"], $class, $duration);

        if (mysqli_stmt_execute($stmt)) {
            // Notification inserted successfully
        } else {
            echo "<script> alert ('Record not inserted');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}


// function check_redirect() {
//     if (isset($_SESSION['redirect_url'])) {
//         $redirect_url = $_SESSION['redirect_url'];
//         unset($_SESSION['redirect_url']);
//         header('Location: ' . $redirect_url);
//     } else {
//         header('Location: notification.php');
//     }
// }
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
        div.modal-content {
            border-radius: 30px;
        }
        td {
            height: 45px;
            text-align: center;
        }
        .btn {
            border: 0;
            border-radius: 30px;
        }
        .btn-primary {
            border: 0;
            background-color: #1f5b6e;
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
            margin-bottom: 20px;
        }
        input.btn.btn-primary.ml-auto {
            border-radius: 30px;
            background-color: #1f5b6e;
        }
        input.form-control {
            border-radius: 30px;
        }
        a.btn.btn-danger {
            border-radius: 20px;
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
    <title>Admin - Register Teacher</title>
    <!-- css style go to end here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
</head>

<body>
<?php include('../common/teacher-sidebar.php') ?>
    <main role="main" class="col-xl-10 col-lg-12 col-md-12 ml-sm-auto px-md-4 mb-2 w-100">
        <div class="sub-main">
            <div class="p-0 rounded text-center">
                <h1>Notification:</h1>
            </div>
            <button type="button" class="btn btn-primary stdadd" data-toggle="modal" data-target=".bd-example-modal-lg">Add New Notification</button>
            <div class="col-md-12 pt-2 mb-2">
                <!-- Large modal -->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h4 class="modal-title text-center">Add New Notification</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Send to all students</label>
                                                <input type="radio" name="user_type" value="all_students" checked>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Send to a specific user:</label>
                                                <input type="radio" name="user_type" value="class">
                                                <select class="browser-default custom-select" name="class_id">
                                                    <option value="">Select a Class</option>
                                                    <?php
                                                    // Query to select all students
                                                    $student_query = "SELECT `class_id` FROM class WHERE teacher_code= $teacher_code";

                                                    // Execute the query
                                                    $student_result = mysqli_query($con, $student_query);

                                                    // Loop through the results and create an option for each student
                                                    while ($student_row = mysqli_fetch_assoc($student_result)) {
                                                        echo '<option value="' . $student_row['class_id'] . '">Class: ' . $student_row['class_id']  . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Send to a specific user:</label>
                                                <input type="radio" name="user_type" value="specific_user">
                                                <select class="browser-default custom-select" name="user_id">
                                                    <option value="">Select a user</option>
                                                    <?php
                                                    // Query to select all students
                                                    $student_query = "SELECT * FROM student_info WHERE class_id IN (SELECT `class_id` FROM class WHERE teacher_code= $teacher_code);";

                                                    // Execute the query
                                                    $student_result = mysqli_query($con, $student_query);
                                                    // Loop through the results and create an option for each student
                                                    while ($student_row = mysqli_fetch_assoc($student_result)) {
                                                        echo '<option value="' . $student_row['user_id'] . '">Student: ' . $student_row['first_name'] . ' ' . $student_row['middle_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="durationSelect">Duration:</label>
                                                <select class="form-control" name="duration" id="durationSelect">
                                                    <option value="24" selected>1 Day</option>
                                                    <option value="48">2 Day</option>
                                                    <option value="72">3 Day</option>
                                                    <option value="96">4 Day</option>
                                                    <option value="120">5 Day</option>
                                                    <option value="144">6 Day</option>
                                                    <option value="168">7 Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Title:</label>
                                                <input type="text" name="title" class="form-control" required placeholder="Enter Title">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Message:</label>
                                                <textarea name="message" cols="10" rows="1" class="form-control" placeholder="Enter Message" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row w-100">
                                        <div class="col-md-12">
                                            <input type="submit" name="submit" value="Add Message" class=" btn btn-primary ml-auto">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="row">
               <div class="col-md-1 ml-2"></div>
               <div class="col-md-10 ml-2">
                   <section class="mt-3">
                       <table style="margin-left: 0 ;margin-right:0;" class="w-100  table-dark container table-striped table-hover table-elements table-one-tr " cellpadding="10">
                           <thead class="thead-dark">
                               <tr class="table-tr-head table-three text-white">
                                   <th style="border-radius: 20px 0 0 0;">No</th>
                                   <th>Title</th>
                                   <th>Message</th>
                                   <th>Sender</th>
                                   <th>Receiver</th>
                                   <th style="border-radius: 0 20px 0 0;">Action</th>
                               </tr>
                           </thead>
                           <?php
                           $limit = 5; // number of items per page
                           $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // current page
                           $offset = ($current_page - 1) * $limit; // offset for SQL query
                           $sr = $offset + 1;
                           $query = "SELECT notification_id, title, message, sender_id, receiver_id FROM notifications ORDER BY notification_id DESC LIMIT $offset, $limit";
                           
                           $run = mysqli_query($con, $query);
                           while ($row = mysqli_fetch_array($run)) {
                               echo    "<tr>";
                               echo    "<td>" . $sr++ . "</td>";
                               echo    "<td>" . $row['title'] . "</td>";
                               echo    "<td>" . $row['message'] . "</td>";
                               echo    "<td>" . $row['sender_id'] . "</td>";
                               echo    "<td>" . $row['receiver_id'] . "</td>";
                               echo	'<td width="20"><a class="btn btn-danger" href="/CMS/dept_admin/delete-function.php?notification_id=' . $row["notification_id"] . '">Delete</a></td>';
                               echo    "</tr>";
                           }
                           ?>
                       </table>
           
                       <?php
                       $rows_query = "SELECT COUNT(*) FROM notifications";
                       $rows_result = mysqli_query($con, $rows_query);
                       $rows = mysqli_fetch_array($rows_result)[0];
                       $total_pages = ceil($rows / $limit);
           
                       // Show pagination links
                       if ($total_pages > 1) {
                           ?>
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
                                   <li
                                       class="page-item <?php echo ($current_page == $total_pages ? 'disabled' : ''); ?>">
                                       <a class="page-link"
                                          href="<?php echo ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1)); ?>">
                                           Next <i class="material-icons">chevron_right</i>
                                       </a>
                                   </li>
                               </ul>
                           </nav>
                       <?php
                       }
                       ?>
           
                   </section>
               </div>
           </div>
           
            
            
        </div>
    </main>
    <script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>