<?php
	include '../db_connection.php';
	$response = new stdClass();
	$slug=$_GET['slug'];

	$sql = "SELECT * FROM category WHERE slug = '$slug' AND status='active'";
	$res = mysqli_query($conn, $sql);

	if($res==true){
		$data=new stdClass();
		$rows = mysqli_fetch_assoc($res);

		$response->status = "success";
		$response->data = $rows;

		header('HTTP/1.1 200');
		echo json_encode($response);
	}else{
		$response->status = "error";

		header('HTTP/1.1 404');
		echo json_encode($response);

	}

?>