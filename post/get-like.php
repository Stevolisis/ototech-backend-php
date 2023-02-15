
<?php
	include '../db_connection.php';
	$pageId = $_GET['id'];
	$response = new stdClass;
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if ($pageId !== '' && isset($_POST['like'])) {
		$check = "SELECT * FROM likes WHERE ip_address = '$ip' AND pageId = '$pageId'";
		$res = mysqli_query($conn, $check);
		$count = mysqli_num_rows($res);
		if ($count<1) {
			# code...
			$date = new DateTime;
			$month = date_format($date, 'm');
			$day = date_format($date, 'd');
			$year = date_format($date, 'y');
			$sql = "INSERT INTO likes SET
			ip_address = '$ip',
			pageId = '$pageId',
			month = '$month',
			day = '$day',
			year = '$year'";
			$res = mysqli_query($conn, $sql);
			if ($res== true) {
				$sql = "SELECT * FROM likes WHERE pageId='$pageId'";
				$res = mysqli_query($conn, $sql);
				$count = mysqli_num_rows($res);
				$response->status = 'success';
				$response->likes = $count;
				header("HTTP/1.1 200");
				echo json_encode($response);
			}else{
				$response->status = 'error';
				header("HTTP/1.1 404");
				echo json_encode($response);
			}
		}else{
				$sql = "SELECT * FROM likes WHERE pageId='$pageId'";
				$res = mysqli_query($conn, $sql);
				$count = mysqli_num_rows($res);
				$response->status = 'success';
				$response->likes = $count;
				header("HTTP/1.1 200");
				echo json_encode($response);
		}
		
	}elseif (!isset($_POST['like'])) {
		$sql = "SELECT * FROM likes WHERE pageId='$pageId'";
				$res = mysqli_query($conn, $sql);
				$count = mysqli_num_rows($res);
				$response->status = 'success';
				$response->likes = $count;
				header("HTTP/1.1 200");
				echo json_encode($response);
	}
?>