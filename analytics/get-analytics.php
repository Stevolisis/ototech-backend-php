<?php
	include '../db_connection.php';
	$response = new stdClass();
	$sql = "SELECT * FROM views";
	$res = mysqli_query($conn, $sql);
	$views = mysqli_num_rows($res);
	$sql2 = "SELECT * FROM likes";
	$res = mysqli_query($conn, $sql2);
	$likes = mysqli_num_rows($res);
	$sql3 = "SELECT * FROM comments";
	$res = mysqli_query($conn, $sql3);
	$comments = mysqli_num_rows($res);
	$sql4 = "SELECT * FROM users";
	$res = mysqli_query($conn, $sql4);
	$users = mysqli_num_rows($res);
	$sql5 = "SELECT * FROM category";
	$res = mysqli_query($conn, $sql5);
	$category = mysqli_num_rows($res);
	$sql6 = "SELECT * FROM article";
	$res = mysqli_query($conn, $sql6);
	$article = mysqli_num_rows($res);
	$sql7 = "SELECT * FROM staff";
	$res = mysqli_query($conn, $sql7);
	$staff = mysqli_num_rows($res);

	$data = array();
	$data['views'] = $views;
	$data['comments'] = $comments;
	$data['likes'] = $likes;
	$data['users'] = $users;
	$data['categories'] = $category;
	$data['articles'] = $article;
	$data['staffs'] = $staff;

	$response->status = 'success';
	$response->data = $data;
	header("HTTP/1.1 200");
	echo json_encode($response);
	

?>