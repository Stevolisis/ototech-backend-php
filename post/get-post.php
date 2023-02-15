<?php
	include '../db_connection.php';
	$response = new stdClass();
	$category = $_GET['category'];
	$slug = $_GET['article'];
	$sql = "SELECT * FROM article WHERE categorySlug = '$category' AND slug = '$slug' AND status='active'";
	$res = mysqli_query($conn, $sql);

	if ($res == true) {
		$data = array();

		while($rows = mysqli_fetch_assoc($res)){
			$authorId = $rows['authorId'];

			$sql2 = "SELECT * FROM staff WHERE id = $authorId";
			$res2 = mysqli_query($conn, $sql2);
			$authorInfo = mysqli_fetch_assoc($res2);
			
			$rows['author']=$authorInfo;
			$data[] = $rows;
		}
			$response->status = 'success';
			$response->data = $data;
			header("HTTP/1.1 200");
			echo json_encode($response);
	}else{
		$response->status = 'error';
		header("HTTP/1.1 404");
		echo json_encode($response);
	}

?>