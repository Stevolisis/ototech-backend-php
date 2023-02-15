<?php
	include '../db_connection.php';

	$pageId =$_GET['pageId'];
	$sql = "SELECT * FROM comments WHERE pageId = '$pageId' ORDER BY id DESC";
	$response = new stdClass();
	$res = mysqli_query($conn, $sql);

	if ($res==true) {
		$data = array();
		while ($rows = mysqli_fetch_assoc($res)) {
            $rowuserId=$rows['userId'];

            $sql3 = "SELECT * FROM users WHERE id='$rowuserId'";
            $res3 = mysqli_query($conn, $sql3);    
            $userInfo = mysqli_fetch_assoc($res3);
            $rows['user']=$userInfo;
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