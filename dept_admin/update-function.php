<?php
session_start();
require_once "../connection/connection.php";
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

?>

<!-- _____________________________________ Application processing function _____________________________________ -->
<?php
if (isset($_GET['process_id'])) {
	$process_id = $_GET['process_id'];
	$premark = $_GET['remark'];
	echo $process_id;
	echo $premark;
	$query5 = "UPDATE admission_form SET form_status = 'processing' , remark = '$premark' WHERE form_id = $process_id";
	$run5 = mysqli_query($con, $query5);
	if ($run5) {
		echo "<script>alert('Application Accepted successfully.');</script>";
		$query6 = "SELECT * FROM admission_form WHERE form_id = $process_id";
		$run6 = mysqli_query($con, $query6);
		if (mysqli_num_rows($run6) > 0) {
			$row = mysqli_fetch_array($run6);
			$email = $row['email'];
			$mname = $row['middle_name'];
		rearksendmail($email, $mname, $process_id, $premark);

		}
		header("Location: admission_list.php");

	} else {
		echo "<script>alert('There was a error.');</script>";
	}
} else {
}
?>

<!-- processing function ends here  -->
<!-- _____________________________________ Application Reject function _____________________________________ -->
<?php
if (isset($_GET['reject_id'])) {
	$reject_id = $_GET['reject_id'];
	$remark = $_GET['reason'];
	echo $reject_id;
	echo $remark;
	$query5 = "UPDATE admission_form SET form_status = 'rejected' , remark = '$remark' WHERE form_id = $reject_id";
	$run5 = mysqli_query($con, $query5);
	if ($run5) {
		echo "<script>alert('Application Rejected.');</script>";
		$query9 = "SELECT * FROM admission_form WHERE form_id = $reject_id";
		$run9 = mysqli_query($con, $query9);
		if (mysqli_num_rows($run9) > 0) {
			$row = mysqli_fetch_array($run9);
			$email = $row['email'];
			$mname = $row['middle_name'];
		rearksendmail($email, $mname, $reject_id, $remark);

		}
		// header("Location: admin_index.php");
	} else {
		echo "<script>alert('There was a error.');</script>";
	}
} else {
}
?>
<!-- Reject function ends here  -->

<!-- _____________________________________ Application accept function _____________________________________ -->
<!-- <?php

function rearksendmail($email, $mname, $form_id, $remarks)
{
	//Load Composer's autoloader
	require '../vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_OFF; //Disable verbose debug output in production
		$mail->isSMTP(); //Send using SMTP
		$mail->Host = 'smtp.sendgrid.net'; //Set the SMTP server to send through
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->Username = 'apikey'; //SMTP username
		$mail->Password = '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'; //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
		$mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom('smitzaveri123@gmail.com', 'BMU');
		$mail->addAddress($email, $mname); //Add a recipient
		// $mail->addAddress('smitzaveri1003@gmail.com'); //Name is optional
		$mail->addReplyTo('smitzaveri123@gmail.com', 'Information');

		//Content
		$mail->isHTML(true); //Set email format to HTML
		$mail->Subject = 'Admission Remark';
		$mail->isHTML(true);

		// set the body of the message with the enrollment details table
		$mail->Body = '<html>
											<head>
											<style>
												body {
												font-family: Arial, sans-serif;
												font-size: 16px;
												line-height: 1.5;
												color: #333;
												margin: 0;
												padding: 0;
												background-color: #f5f5f5;
												}
												h1 {
												font-size: 24px;
												font-weight: bold;
												margin-top: 0;
												}
												ul {
												list-style: none;
												margin: 0;
												padding: 0;
												}
												li {
												margin-bottom: 10px;
												}
												p {
												margin-bottom: 20px;
												}
												.container {
												max-width: 600px;
												margin: 0 auto;
												padding: 20px;
												background-color: #fff;
												}
											</style>
											</head>
											<body>
											<div class="container">
												<h1>Admission Form</h1>
												<p>Dear ' . $mname . ',</p>
												<p>You Got Remark</p>
												
												<p>As requested, please find below your formid details:</p>
												<ul>
												<li><strong>Form id:</strong> ' . $form_id . '</li>
												<li><strong>Remark:</strong> ' . $remarks . '</li>
												</ul>
							
												<p>Best regards,<br>BMU</p>
											</div>
											</body>
										</html>';


		$mail->send();
		// header("Location: sent.html");                               //Redirect to success page on successful send

	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

}

?> 



<!-- accpet function ends here  -->
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
<?php
if (isset($_GET['roll_no'])) {
	$roll_no = $_GET['roll_no'];
	$query1 = "delete from student_info where roll_no='$roll_no'";
	$run1 = mysqli_query($con, $query1);
	if ($run1) {
		if (isset($_SESSION['redirect_url'])) {
			$redirect_url = $_SESSION['redirect_url'];
			unset($_SESSION['redirect_url']);
			header('Location: ' . $redirect_url);
		} else {
			header('Location: student.php');
		}
	} else {
		echo "Record not deleted. First of all delete record from the child table then you can delete from here ";
		header('Refresh: 5; url=student.php');
	}
}
?>

<!-- --------------------------------Update Login Info------------------------------------- -->




<!-- --------------------------------Update Course------------------------------------- -->
<?php


if (isset($_POST['course_code'])) {
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
if (isset($_GET['course_code'])) {
	$course_code = $_GET['course_code'];
	$query = "SELECT * FROM courses WHERE course_code='$course_code'";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_assoc($result);
	?>

	<!-- Form HTML -->
	<form method="POST">
		<label for="course_code">Course Code:</label>
		<input type="text" name="course_code" value="<?php echo $row['course_code']; ?>">
		<label for="course_name">Course Name:</label>
		<input type="text" name="course_name" value="<?php echo $row['course_name']; ?>"><br>
		<label for="no_of_semesters">Number of Semester:</label>
		<input type="text" name="no_of_semester" value="<?php echo $row['no_of_semester']; ?>"> <br>
		<label for="dept_id">Department ID:</label>
		<input type="text" name="dept_id" value="<?php echo $row['dept_id']; ?>"><br>
		<label for="stream_id">Stream ID:</label>
		<input type="text" name="stream_id" value="<?php echo $row['stream_id']; ?>"><br>
		<input type="submit" name="sub" value="Update Record">
	</form>

<?php } ?>

<!-- --------------------------------Update Subejct------------------------------------- -->
<?php


if (isset($_POST['subject_code'])) {
	// Get form data
	$subject_code = $_POST['subject_code'];
	$subject_name = $_POST['subject_name'];
	$no_of_semester = $_POST['no_of_semester'];
	$dept_id = $_POST['dept_id'];
	$course_id = $_POST['course_id'];

	// Update record in database
	$query = "UPDATE course_subjects SET subject_code='$subject_code', subject_name='$subject_name', no_of_semester='$no_of_semester', dept_id='$dept_id', course_id='$course_id' WHERE subject_code='$subject_code'";
	$run = mysqli_query($con, $query);

	// Check if update was successful
	if ($run) {
		header('Location:subjects.php');
	} else {
		echo "Error updating record: " . mysqli_error($con);
	}
}

// Get current record from database
if (isset($_GET['subject_code'])) {
	$subject_code = $_GET['subject_code'];
	$query = "SELECT * FROM course_subjects WHERE subject_code='$subject_code'";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_assoc($result);
	?>

	<!-- Form HTML -->
	<form method="POST">
		<label for="subject_code">subject Code:</label>
		<input type="text" name="subject_code" value="<?php echo $row['subject_code']; ?>">
		<label for="subject_name">subject Name:</label>
		<input type="text" name="subject_name" value="<?php echo $row['subject_name']; ?>"><br>
		<label for="no_of_semesters">Number of Semester:</label>
		<input type="text" name="no_of_semester" value="<?php echo $row['no_of_semester']; ?>"> <br>
		<label for="dept_id">Department ID:</label>
		<input type="text" name="dept_id" value="<?php echo $row['dept_id']; ?>"><br>
		<label for="course_id">Course ID:</label>
		<input type="text" name="course_id" value="<?php echo $row['course_id']; ?>"><br>
		<input type="submit" name="sub" value="Update Record">
	</form>

<?php } ?>



<!-- --------------------------------Delete Notification------------------------------------- -->
<?php
if (isset($_GET['notification_id'])) {
	$notification_id = $_GET['notification_id'];
	$query4 = "DELETE FROM `notifications` WHERE notification_id='$notification_id'";
	$run4 = mysqli_query($con, $query4);
	if ($run4) {
		if (isset($_SESSION['redirect_url'])) {
			$redirect_url = $_SESSION['redirect_url'];
			unset($_SESSION['redirect_url']);
			header('Location: ' . $redirect_url);
		} else {
			header('Location: notification.php');
		}

	} else {
		echo "Record not deleted";
	}
}
?>