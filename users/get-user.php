<?php
	include '../db_connection.php';
	$response = new stdClass();
	$id =(int)$_GET['id'];

	$sql = "SELECT * FROM users WHERE id=$id";
	$res = mysqli_query($conn, $sql);

	if ($res == true) {
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