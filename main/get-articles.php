<?php
	include '../db_connection.php';

	$limit = (int)$_GET['limit'];
	$sql = "SELECT * FROM article WHERE status='active' ORDER BY id DESC LIMIT $limit";
	$response = new stdClass();
	$res = mysqli_query($conn, $sql);
	
	if ($res==true) {
		$data = array();
		
		while ($rows = mysqli_fetch_assoc($res)) {
            $authorId=$rows['authorId'];
            $pageId=$rows['id'];

            $sql2 = "SELECT * FROM staff WHERE id='$authorId'";
            $res2 = mysqli_query($conn, $sql2);    
            $authorInfo = mysqli_fetch_assoc($res2);

            $sql3 = "SELECT * FROM likes WHERE pageId='$pageId'";
            $res3 = mysqli_query($conn, $sql3);    
            $likesCount = mysqli_num_rows($res3);

            $sql4 = "SELECT * FROM views WHERE pageId='$pageId'";
            $res4 = mysqli_query($conn, $sql4);    
            $viewsCount = mysqli_num_rows($res4);

            $sql5 = "SELECT * FROM comments WHERE pageId='$pageId'";
            $res5 = mysqli_query($conn, $sql5);    
            $commentsCount = mysqli_num_rows($res5);

            $rows['author']=$authorInfo;
            $rows['likes']=$likesCount;
            $rows['views']=$viewsCount;
            $rows['comments']=$commentsCount;

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