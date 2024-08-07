<?php

session_start();
require_once "../connection/connection.php";

if (isset($_POST['log_submit'])) {
	$user_id = $_POST['user_id'];
	$id = $_POST['id'];
	$pass = $_POST['password'];
    $c_query = "SELECT * FROM admin_info WHERE user_id = '$user_id'";
    $c_run = mysqli_query($con, $c_query);
    if(mysqli_num_rows($c_run) > 0)
    {
        echo "<script>alert('User ID cannot be same');</script>";
        echo "<script>window.location.href='manage-accounts.php';</script>";
    }
    else
    {
        $que = "UPDATE admin_info SET user_id='$user_id', password='$pass' where id = '$id'";
        $run = mysqli_query($con, $que);
        if ($run) {
            header('Location: ../Login/logout.php');
        } else {
            echo "<script>alert('There was an error..');</script>";
            echo "<script>window.location.href='manage-accounts.php';</script>";
        }
    }
}
?>
