<?php
	include '../db_connection.php';

	$limit = (int)$_GET['limit'];
	$sql = "SELECT * FROM users ORDER BY id DESC LIMIT $limit";
	$response = new stdClass();
	$res = mysqli_query($conn, $sql);
	
	if ($res==true) {
		$data = array();
		
		while ($rows = mysqli_fetch_assoc($res)) {
			$rowuserId=$rows['id'];

            $sql2 = "SELECT * FROM comments WHERE userId='$rowuserId'";
            $res2 = mysqli_query($conn, $sql2);    
            $rows['comments']=mysqli_num_rows($res2);

			$data[] = $rows;
		}

		$response->status='success';
		$response->data = $data;
		header("HTTP/1.1 200");
		echo json_encode($response);
	}else{
		$response->status ='error';
		header('HTTP/1.1 404');
		echo json_encode($response);
	}
?>