<?php
session_start();
require_once "../connection/connection.php";
// -------------------------------------------- Admin Functions Starts here ------------------------------------------------------
if (isset($_POST['sub'])) 
{
	// Get form data
	$action = $_POST['action'];
	$user_id = mysqli_real_escape_string($con, $_POST['user_id']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$n_dept_id = mysqli_real_escape_string($con, $_POST['dept_id']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$name = mysqli_real_escape_string($con, $_POST['name']);
	//Perform insert or update based on action
	if ($action == 'insert') 
	{
		$c_query = "SELECT * FROM admin_info WHERE user_id = '$user_id'";
		$c_run = mysqli_query($con, $c_query);
		if(mysqli_num_rows($c_run) > 0)
		{
			echo "<script>alert('User ID cannot be same');</script>";
		}
		else
		{
			$query = "INSERT INTO admin_info (`id`,`user_id`,`password`,`name`,`dept_id`,`email`) 
					VALUES (NULL,'$user_id','$password','$name','$n_dept_id','$email');";
			$run = mysqli_query($con, $query);
			if ($run) 
			{
				echo "<script>alert('Success');</script>";
				header('Location: admin.php');	

			} 
			else 
			{
				echo "<script>alert('There was an error inserting your record.');</script>";
			}
		}
	} 
	elseif ($action == 'update') 
	{
		$query = "UPDATE admin_info SET `dept_id`='$n_dept_id',`email`='$email', `name`='$name' WHERE user_id='$user_id' AND password='$password'";
		$run = mysqli_query($con, $query);
		if ($run) 
		{
			header('Location: admin.php');	
		} 
		else 
		{
			echo "Error updating record: " . mysqli_error($con);
		}
	}
}


?>
<?php
if (isset($_GET['del_user_id'])) {
	$del_user_id = $_GET['del_user_id'];
	$password = $_GET['password'];
	$query2 = "DELETE FROM admin_info where user_id='$del_user_id' AND password='$password'";
	$run2 = mysqli_query($con, $query2);
	if ($run2) {
		header('Location: admin.php');
	} else {
		echo "Record not deleted";
	}
}
// -------------------------------------------- Admin Functions ends here ------------------------------------------------------

// uni admin add

if (isset($_POST['uni'])) 
{
	// Get form data
	$action = $_POST['action'];
	$user_id = mysqli_real_escape_string($con, $_POST['user_id']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$name = mysqli_real_escape_string($con, $_POST['name']);
	//Perform insert or update based on action
	if ($action == 'insert') 
	{
		$c_query = "SELECT * FROM uniadmin_info WHERE user_id = '$user_id'";
		$c_run = mysqli_query($con, $c_query);
		if(mysqli_num_rows($c_run) > 0)
		{
			echo "<script>alert('User ID cannot be same');</script>";
		}
		else
		{
			$query = "INSERT INTO uniadmin_info (`id`,`user_id`,`password`,`name`,`email`) 
					VALUES (NULL,'$user_id','$password','$name','$email');";
			$run = mysqli_query($con, $query);
			if ($run) 
			{
				echo "<script>alert('Success');</script>";
				header('Location: adduniadmin.php');	

			} 
			else 
			{
				echo "<script>alert('There was an error inserting your record.');</script>";
			}
		}
	} 
	elseif ($action == 'update') 
	{
		$query = "UPDATE uniadmin_info SET `email`='$email', `name`='$name' WHERE user_id='$user_id' AND password='$password'";
		$run = mysqli_query($con, $query);
		if ($run) 
		{
			header('Location: adduniadmin.php');	
		} 
		else 
		{
			echo "Error updating record: " . mysqli_error($con);
		}
	}
}


if (isset($_GET['del_user_id'])) {
	$del_user_id = $_GET['del_user_id'];
	$password = $_GET['password'];
	$query2 = "DELETE FROM uniadmin_info where user_id='$del_user_id' AND password='$password'";
	$run2 = mysqli_query($con, $query2);
	if ($run2) {
		header('Location: adduniadmin.php');
	} else {
		echo "Record not deleted";
	}
}

// -------------------------------------------- Stream Functions starts here ------------------------------------------------------

if (isset($_POST['stream_sub'])) {
	// Get form data
	$action = $_POST['action'];
	$stream_id = mysqli_real_escape_string($con, $_POST['stream_id']);
	$stream_name = mysqli_real_escape_string($con, $_POST['stream_name']);
	echo $stream_id;
	echo $stream_name;
	//Perform insert or update based on action
	if ($action == 'insert') {
		$query = "INSERT INTO stream (id,stream_name) 
                VALUES (NULL, '$stream_name');";
		$run = mysqli_query($con, $query);
		if ($run) {
			header('Location: stream.php');
		} else {
			echo "<script>alert('There was an error inserting your record.');</script>";
		}
	} elseif ($action == 'update') {
		$query = "UPDATE stream SET stream_name='$stream_name' WHERE id='$stream_id'";
		$run = mysqli_query($con, $query);
		if ($run) {
			header('Location: stream.php');
		} else {
			echo "Error updating record: " . mysqli_error($con);
			echo "fucked";
		}
	}
}


?>
<?php
if (isset($_GET['del_stream_id'])) {
	$del_stream_id = $_GET['del_stream_id'];
	$query2 = "DELETE FROM stream where id='$del_stream_id'";
	$run2 = mysqli_query($con, $query2);
	if ($run2) {
		header('Location:stream.php');
	} else {
		echo "Record not deleted";
	}
}


?>
