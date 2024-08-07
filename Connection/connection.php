<?php 
	$con = mysqli_connect("localhost", "root", "", "cms");
	if(!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
