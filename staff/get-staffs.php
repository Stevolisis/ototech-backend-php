<?php
	include '../db_connection.php';
	require_once '../vendor/autoload.php';
	// use Firebase\JWT\JWT;
	// use Firebase\JWT\Key;	
?>


<?php

	$response = new stdClass();

	try{
	// $JWT_SECRET = 'secure_coding';
	$limit = (int)$_GET['limit'];
	$sql = "SELECT * FROM staff ORDER BY id DESC LIMIT $limit ";
	// $cookie=$_COOKIE['tryCookie'];
	
    // $decodeJWT=JWT::decode($cookie,new Key($JWT_SECRET, 'HS256'));


	$res = mysqli_query($conn, $sql);
	if ($res == true) {
		$data = array();
		while ($rows = mysqli_fetch_assoc($res)) {
            $authorId=$rows['id'];

            $sql2 = "SELECT * FROM article WHERE authorId='$authorId'";
            $res2 = mysqli_query($conn, $sql2);    
            $authorArticles = mysqli_num_rows($res2);

            $rows['posts']=$authorArticles;

			$data[] = $rows;
		}
		$response->status = "success";
		// $response->decodeJWT = $decodeJWT;
		$response->data = $data;
		header('HTTP/1.1 200');
		echo json_encode($response);
	}else{


	}

    }catch(Exception $e){
			$response->status = $e->getMessage();
			header('HTTP/1.1 404');
			echo json_encode($response);    	
    }
?>