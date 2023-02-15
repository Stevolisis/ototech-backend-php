<?php
	include '../db_connection.php';
	$response = new stdClass();
	$limit = (int)$_GET['limit'];

	$sql = "SELECT * FROM category WHERE status='active' LIMIT $limit";
	$res = mysqli_query($conn, $sql);

	if($res==true){

		$data=array();
		while ($rows = mysqli_fetch_assoc($res)) {
            $categoryId=$rows['id'];

            $sql2 = "SELECT * FROM article WHERE categoryId='$categoryId'";
            $res2 = mysqli_query($conn, $sql2);    
            $articles = mysqli_num_rows($res2);

            $rows['articles']=$articles;

			$data[] = $rows;
		}

		$response->status = "success";
		$response->data = $data;

		header('HTTP/1.1 200');
		echo json_encode($response);
	}else{
		$response->status = "error";

		header('HTTP/1.1 200');
		echo json_encode($response);

	}

?>