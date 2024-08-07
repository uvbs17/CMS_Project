<?php
session_start();
require_once "../connection/connection.php";

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['accept_id']))
{
	
	$accept_id = $_GET['accept_id'];
	$query5 = "SELECT * FROM admission_form WHERE form_id = $accept_id";
	$run5 = mysqli_query($con, $query5);
	if (mysqli_num_rows($run5) > 0)
	{
		//echo "<script></script";
		$row = mysqli_fetch_array($run5);
		$fees_status = $row["fees_status"];
		$fname = $row["first_name"];
		$mname = $row["middle_name"];
		$lname = $row["last_name"];
		$dob = $row["dob"];
		$gender = $row["gender"];
		$email = $row["email"];
		$mobile = $row["mobile_no"];
		$alt_mno = $row["alter_mno"];
		$aadharno = $row["aadhar_no"];
		$aadhar_path = $row["aadhar_path"];
		$cast = $row["cast"];
		$disability = $row["disability"];
		$course_code = $row["course"];
		$ssc_board = $row["ssc_board"];
		$sqlDate = $row["ssc_m_y"];
		$per_ssc = $row["ssc_percentage"];
		$ssc_path = $row["ssc_result_path"];
		$hsc_board = $row["hsc_board"];
		$sqlDate2 = $row["hsc_m_y"];
		$per_hsc = $row["hsc_percentage"];
		$hsc_path = $row["hsc_result_path"];
		$sem = '1';
		$amount ="";
		$course = "";
		$course_id = "";
		$dept_id = "";
		$total_sem = "";
		$fy = "";
        $s_class = "";

		$query6 = "SELECT * FROM courses WHERE course_code = '$course_code'";
		$result = mysqli_query($con, $query6);

		if (mysqli_num_rows($result) > 0) 
		{
			$row2 = mysqli_fetch_array($result);
			$course = $row2["course_id"];
			$dept_id = $row2["dept_id"];
			$amount = $row2["fees_per_sem"];
			$course_id = str_pad($course, 2, '0', STR_PAD_LEFT);
			$total_sem = $row2["no_of_semester"];
			echo "<script>console.log('course code')</script>";


			$class_query = "SELECT * from class WHERE course_code='$course_code' AND sem ='$sem'";
			$class_run = mysqli_query($con ,$class_query);  
			if(mysqli_num_rows($class_run) > 0)
			{
				$c_row=mysqli_fetch_array($class_run);
				$class = $c_row['class_id'];
				$limit = $c_row['no_of_student'];
				//echo $class ."<br>";
				//echo $limit;
				$s_query = "SELECT * FROM student_info WHERE class_id='$class'";
				$s_run = mysqli_query($con , $s_query);
				if(mysqli_num_rows($s_run) >= $limit)
				{
					echo "<script> alert ('The class is full Create a new class First'); </script>";
					echo "<script>window.location.href='class.php';</script>";
				}
				else
				{
					$s_class = $class;

					function getNextEnrollmentNumber($year, $department, $course)
					{
						// Connect to the database
						$connection = mysqli_connect("localhost", "root", "", "cms");
						//session_start();
						//require_once "../connection/connection.php";
						// Check if there is any existing enrollment number for the given combination
						$query = "SELECT enrollment_no_genrator FROM student_info WHERE enrollment_no_genrator LIKE '{$year}-{$department}-{$course}-%' ORDER BY enrollment_no_genrator DESC LIMIT 1";
						$result = mysqli_query($connection, $query);

						if (mysqli_num_rows($result) > 0) {
							// If there is an existing enrollment number, increment the last 4 digits by 1
							$last_enrollment_number = mysqli_fetch_assoc($result)['enrollment_no_genrator'];
							$last_digits = substr($last_enrollment_number, -4);
							$next_digits = str_pad(intval($last_digits) + 1, 4, '0', STR_PAD_LEFT);
							$next_enrollment_number = "{$year}-{$department}-{$course}-{$next_digits}";
							$user_id = "{$year}{$department}{$course}{$next_digits}";
							$password = $user_id;
						} else {
							// If there is no existing enrollment number, start from 0001
							$next_enrollment_number = "{$year}-{$department}-{$course}-0001";
							$user_id = "{$year}-{$department}-{$course}-0001";
							$password = $user_id;
						}

						// Close the database connection
						mysqli_close($connection);

						return array($next_enrollment_number, $user_id, $password);
					}
					$y = date('Y');
					$m = date('m');
					$a = ($total_sem / 2);
					$fy = $y . '-' . ($y + $a);

					$enroll = getNextEnrollmentNumber($y, $dept_id, $course_id);
					$enrollment_no_genrator = $enroll[0];

					$temp = str_replace("-", "", $enrollment_no_genrator);

					$enrollment_no = $temp;
					$user_id = $temp;
					$password = $temp;

					$fee_query = "INSERT INTO `student_fee`(`fee_voucher`, `enrollment_no`,`paid_sem`, `amount`, `posting_date`, `status`) 
									VALUES (NULL,'$enrollment_no','$sem','$amount',CURRENT_TIMESTAMP,'paid')";
					$fee_run = mysqli_query($con, $fee_query);
					if($fee_query)
					{
						$query7 = "INSERT INTO `student_info`(`id`, `user_id`, `password`, `enrollment_no_genrator`, `enrollment_no`, `dept_id`, `course_code`, `first_name`, `middle_name`, `last_name`, `father_name`, 
						`dob`, `place_of_birth`, `gender`, `email`, `mobile_no`, `alter_mno`, `aadhar_no`, `aadhar_path`, `cast`, `disability`, `ssc_board`, `ssc_m_y`, `ssc_percentage`, `ssc_result_path`, 
						`hsc_board`, `hsc_m_y`, `hsc_percentage`, `hsc_result_path`, `profile_image`, `current_address`, `state`, `permanent_address`,`fees_status`,`exam_status`, `current_semester`,`class_id`,`session`,`admission_date`) 
						VALUES (NULL ,'$user_id' ,'$password','$enrollment_no_genrator' ,'$enrollment_no' ,'$dept_id' ,'$course_code' ,'$fname' ,'$mname' ,'$lname' ,NULL ,
						'$dob' ,NULL ,'$gender' ,'$email','$mobile' ,'$alt_mno' ,'$aadharno' ,'$aadhar_path' ,'$cast' ,'$disability' ,'$ssc_board' ,'$sqlDate' ,'$per_ssc' ,'$ssc_path',
						'$hsc_board' ,'$sqlDate2' ,'$per_hsc' ,'$hsc_path' ,NULL ,NULL ,NULL ,NULL ,'paid','','$sem','$s_class','$fy',CURRENT_TIMESTAMP);";

						function sendmail($email, $mname, $enrollment_no, $password)
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
								$mail->Subject = 'Admission Granted';
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
												<h1>Admission Granted</h1>
												<p>Dear ' . $mname . ',</p>
												<p>It is our pleasure to inform you that your admission has been granted to Bhagwan Mahavir University. We look forward to having you as a part of our institution.</p>
												
												<p>As requested, please find below your enrollment details:</p>
												<ul>
												<li><strong>Enrollment No:</strong> ' . $enrollment_no . '</li>
												<li><strong>Password:</strong> ' . $password . '</li>
												</ul>
							
												<p>Please keep these details safe and secure, as they will be needed throughout your academic journey with us. If you encounter any issues or have any questions, please do not hesitate to reach out to our support team who are always happy to assist.</p>
							
												<p>Once again, congratulations on your admission! We can\'t wait to see all the amazing things you will achieve during your time here.</p>
							
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
						$result2 = mysqli_query($con, $query7);
						echo "<br>".mysqli_affected_rows($con);
						if ($result2) 
						{
							echo " Success";
							sendmail($email, $mname, $enrollment_no, $password);
							$query8 = "UPDATE `admission_form` SET `form_status`='accepted' WHERE `form_id`= $accept_id";
							$result3 = mysqli_query($con, $query8);
							if ($result3) 
							{
								echo "<scipt>alert('Success');</script>";
								echo "<script>window.location.href='admission_list.php';</script>";
							}
						} 
						else 
						{
							echo "<script> alert('Error');</script>";
						}
					} 
					else
					{
						echo "<script>alert('There was an error while genrating fee voucher.');</script>";
						echo "<script>window.location.href='admission_list.php';</script>";
					}
				}
			}
			else
			{
				echo "<script>alert('No class Found for this Course, Create a class first.');</script>";
				echo "<script>window.location.href='class.php';</script>";

			}
		} 
		else 
		{
			echo "<script>console.log('course code failded')</script>";
		}
	}
	else
	{
		echo "hello";
		header('Location: admin-index.php');		
	}
}
else
{
	echo "<script>alert('Not getting ID.');</script>";
}
?>