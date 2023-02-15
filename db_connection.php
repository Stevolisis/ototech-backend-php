<?php
	$conn = mysqli_connect("localhost", "root","", "ototechblog");
	if (!$conn) {
		die("connection error:" .mysqli_connect_error());
	}
?>