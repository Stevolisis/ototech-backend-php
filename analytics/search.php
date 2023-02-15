z
<?php
	include '../db_connection.php';
	$response = new stdClass();
	if (isset($_POST['submit'])) {
		$input = $_POST['input'];
		$sql = "SELECT * FROM category WHERE slug LIKE '$input%'";
		$res = mysqli_query($conn, $sql);
		$sql2 = "SELECT * FROM article WHERE slug LIKE '$input%'";
		$res2 = mysqli_query($conn, $sql2);

		if ($res == true) {
			$data = array();
			$count = mysqli_num_rows($res);

			if ($count>0) {
				# code...
				while ($rows = mysqli_fetch_assoc($res)) {
				$data[] = $rows['slug'];
				$data['type'] = 'category';
				}
				$response->status = 'success';
				$response->data = $data;
				header("HTTP/1.1 200");
				echo json_encode($response);
			
			}elseif ($res2 == true) {
				$data = array();
				$count = mysqli_num_rows($res2);

				if ($count>0) {
					# code...
					while ($rows = mysqli_fetch_assoc($res2)) {
					$data['type'] = 'article';
					$data[] = $rows['slug'];

					}
					$response->status = 'success';
					$response->data = $data;
					header("HTTP/1.1 200");
					echo json_encode($response);

				}else{
					$response->status = 'success';
					$response->data = 'No record found';
					header("HTTP/1.1 200");
					echo json_encode($response);
				}
			

		}else{
			$response->status = 'error';
			header("HTTP/1.1 404");
			echo json_encode($response);
		}
			
		}
	}

?>