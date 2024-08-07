<?php
//session_start();
require_once "connection/connection.php";
if (!isset($_SESSION['redirect_url'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
if (!$_SESSION["Logininfo"]) {
    header('location: index.php');
    echo "hello";
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

    $urname = $row["user_id"];
    $pass = $row["password"];
    $name = $row["name"];
    $dept_id = $row["dept_id"];
    $email = $row["email"];
    $dept = $row["dept_name"];

    //echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<?php
if (isset($_POST['sub'])) {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $no_of_semester = $_POST['no_of_semesters'];
    $dep_id = $_POST['dept_id'];
    $stream_id = $_POST['stream_id'];

    $query = "INSERT INTO courses (course_id,course_code,course_name,no_of_semester,dept_id,stream_id) 
			VALUES (NULL, '$course_code','$course_name','$no_of_semester','$dep_id','$stream_id');";
    $run = mysqli_query($con, $query);
    if ($run) {
        header('Location:dept_admin/courses.php');
    } else {
        echo "<script>alert('There was an error inserting your record.');</script>";
    }
}
?>

<?php if (isset($_POST['course_code'])) {
    // Get form data
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $no_of_semester = $_POST['no_of_semester'];
    $dept_id = $_POST['dept_id'];
    $stream_id = $_POST['stream_id'];

    // Update record in database
    $query = "UPDATE courses SET course_code='$course_code', course_name='$course_name', no_of_semester='$no_of_semester', dept_id='$dept_id', stream_id='$stream_id' WHERE course_code='$course_code'";
    $run = mysqli_query($con, $query);

    // Check if update was successful
    if ($run) {
        header('Location:courses.php');
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Get current record from database
$course_code = $_GET['course_code'];
$query = "SELECT * FROM courses WHERE course_code='$course_code'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
?>

<?php
if (isset($_POST['submit'])) {

    // Get the form values
    $user_type = $_POST['user_type'];
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $message = $_POST['message'];
    $name = $row["name"];

    // Insert the notification based on the selected options
    if ($user_type == "all_students" or $user_type == "all_teachers") {
        // Query to select all student IDs
        $student_query = "SELECT user_id FROM student_info";

        // Execute the query
        $student_result = mysqli_query($con, $student_query);

        // Loop through the results and insert a new notification for each student
        while ($student_row = mysqli_fetch_assoc($student_result)) {
            $user_id = $student_row['user_id'];
            $insert_query = "INSERT INTO notifications (title, message, sender_id, receiver_id, usertype) 
                         VALUES ('$title', '$message','$name', '$user_id','student')";

            $run1 = mysqli_query($con, $insert_query);
            if ($run1) {
                if (isset($_SESSION['redirect_url'])) {
                    $redirect_url = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                    header('Location: ' . $redirect_url);
                } else {
                    header('Location: notification.php');
                }
            } else {
                echo "Record not inserted";
            }
        }

        // Query to select all teacher IDs
        $teacher_query = "SELECT user_id FROM teacher_info";

        // Execute the query
        $teacher_result = mysqli_query($con, $teacher_query);

        // Loop through the results and insert a new notification for each teacher
        while ($teacher_row = mysqli_fetch_assoc($teacher_result)) {
            $user_id = $teacher_row['user_id'];
            $insert_query = "INSERT INTO notifications (title, message, sender_id, receiver_id, usertype) 
         VALUES ('$title', '$message','$name', '$user_id','faculty')";

            $run1 = mysqli_query($con, $insert_query);
            if ($run1) {
                if (isset($_SESSION['redirect_url'])) {
                    $redirect_url = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                    header('Location: ' . $redirect_url);
                }
            } else {
                echo "Record not inserted";
            }
        }
    } elseif ($user_type == "specific_user") {
        // Insert a new notification for the selected user
        $insert_query = "INSERT INTO notifications (title, message, sender_id, receiver_id) 
                         VALUES ('$title', '$message','$name', '$user_id')";

        $run1 = mysqli_query($con, $insert_query);
        if ($run1) {
            if (isset($_SESSION['redirect_url'])) {
                $redirect_url = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);
                header('Location: ' . $redirect_url);
            } else {
                header('Location: notification.php');
            }
        } else {
            echo "Record not inserted";
        }
    }
}
?>