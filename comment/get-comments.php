<?php
	include '../db_connection.php';

	// $cookie =$_COOKIE['token'];
	$limit =$_GET['limit'];
	$sql = "SELECT * FROM comments ORDER BY id DESC LIMIT $limit";
	$response = new stdClass();
	$res = mysqli_query($conn, $sql);


	if ($res==true) {
		$data = array();

		while ($rows = mysqli_fetch_assoc($res)) {
            $rowpageId=$rows['pageId'];
            $rowuserId=$rows['userId'];

            $sql2 = "SELECT title FROM article WHERE id=$rowpageId";
            $res2 = mysqli_query($conn, $sql2);    
            $pageInfo = mysqli_fetch_assoc($res2);

            $sql3 = "SELECT * FROM users WHERE id='$rowuserId'";
            $res3 = mysqli_query($conn, $sql3);    
            $userInfo = mysqli_fetch_assoc($res3);

            $rows['pageId']=$pageInfo;
            $rows['user']=$userInfo;
			$data[] = $rows;
		}
        
        
		$response->status='success';
		$response->data = $data;
		// $response->cookies = $cookie;
		header("HTTP/1.1 200");
		echo json_encode($response);
	}else{
		$response->status ='error';
		header('HTTP/1.1 404');
		echo json_encode($response);
	}
?>