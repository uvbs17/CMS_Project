
<?php
session_start();
require_once "../connection/connection.php";
if (!isset($_SESSION['redirect_url'])) 
{
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
 
if (!isset($_SESSION["Logininfo"])) 
{
	echo '<script type="text/javascript">window.location.href = "index.php";</script>';
} 
else 
{
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
	//echo "<h1><br> $urname <br> $name <br>$dept_id<br>$dept</h1>";
}

?>
<!-- --------------------------------Delete Student------------------------------------- -->
<?php
if(isset($_GET['enrollment_no']))
{
	$enro = $_GET['enrollment_no'];
	$student_query = "UPDATE `student_info` SET `enrollment_no_genrator`='left' WHERE `enrollment_no` = '$enro'";
	$run_query = mysqli_query($con , $student_query);
	if ($run_query)
	{
		echo "<script>window.location.href='Student.php';</script>";
	}
	else
	{
		echo "Student not deleted";
	}
}
?>
<!-- --------------------------------Delete Course------------------------------------- -->
<?php
if (isset($_GET['course_code'])) {
	$course_code = $_GET['course_code'];
	$query2 = "delete from courses where course_code='$course_code'";
	$run2 = mysqli_query($con, $query2);
	if ($run2) {
		header('Location:courses.php');
	} else {
		echo "Course not deleted";
	}
}
?>
<!-- --------------------------------Delete Subject------------------------------------- -->
<?php
if (isset($_GET['subjects_code'])) 
{
	$subject_code = $_GET['subjects_code'];
	$query3 = "DELETE FROM `subjects` WHERE `subjects_code`='$subject_code'";
	$run3 = mysqli_query($con, $query3);
	if ($run3) 
	{
		header('Location: subjects.php');
	}
	else 
	{
		echo "Subject not deleted";
	}
}
?>
<!-- --------------------------------Delete Teacher------------------------------------- -->
<?php
if (isset($_GET['teacher_code'])) 
{
	$teacher_code = $_GET['teacher_code'];
	$query3 = "delete from teacher_info where teacher_code='$teacher_code'";
	$run3 = mysqli_query($con, $query3);
	if ($run3) {
		if (isset($_SESSION['redirect_url'])) {
			$redirect_url = $_SESSION['redirect_url'];
			unset($_SESSION['redirect_url']);
			header('Location: ' . $redirect_url);
		} else {
			header('Location: teacher.php');
		}
	} else {
		echo "Teacher not deleted";
	}
}
?>

<!-- --------------------------------Delete Notification------------------------------------- -->
<?php
if (isset($_GET['notification_id'])) 
{
	$notification_id = $_GET['notification_id'];
	$query4 = "DELETE FROM `notifications` WHERE notification_id = ?";
	$stmt = mysqli_prepare($con, $query4);
	mysqli_stmt_bind_param($stmt, 'i', $notification_id);
	$run4 = mysqli_stmt_execute($stmt);

	if ($run4) {
		header('Location: notification.php');
		exit;
	} else {
		 http_response_code(500);
		 exit('Record not deleted');
	}
}
?>
