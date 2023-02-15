
<?php
	include '../db_connection.php';
	$response = new stdClass();

	if (isset($_GET['key'])) {
		$input = $_GET['key'];
		$sql = "SELECT * FROM category WHERE name LIKE '%$input%' AND status='active'";
		$res = mysqli_query($conn, $sql);
		$sql2 = "SELECT * FROM article WHERE title LIKE '%$input%' AND status='active'";
		$res2 = mysqli_query($conn, $sql2);


	if ($res == true && $res2==true) {
		$data = array();

		while ($rows = mysqli_fetch_assoc($res)) {
            $data[] = $rows;
		}

		while ($rows2 = mysqli_fetch_assoc($res2)) {
			$data[] = $rows2;
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
		
	}

?>