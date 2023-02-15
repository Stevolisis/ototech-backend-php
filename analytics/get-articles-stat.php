<?php
	include '../db_connection.php';
	$month = $_GET['month'];
	$year = $_GET['year'];
	$response = new stdClass();
	$sql = "SELECT * FROM article WHERE month=$month AND year=$year";
	$res = mysqli_query($conn, $sql);
	if ($res == true) {
		$data = array();
		while ($rows = mysqli_fetch_assoc($res)) {
			$data[] = $rows;		
		}
		$response->status = 'success';
		$response->data = $data;
		header("HTTP/1.1 200");
		echo json_encode($response);
	}else{
		$response->status ='error';
		header("HTTP/1.1 404");
		json_encode($response);
	}
?>