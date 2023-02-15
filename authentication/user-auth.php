<?php
	include '../db_connection.php';
	require_once '../vendor/autoload.php';
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	$JWT_SECRET = "secure_coding";

	if (isset($_COOKIE['token'])) {
		$cookie=$_COOKIE['token'];
		$response = new stdClass();

		try{
			$decodeJWT = JWT::decode($cookie,new Key($JWT_SECRET, 'HS256'));

			if($decodeJWT){
			$user=$decodeJWT->data;
			$sql="SELECT * FROM users WHERE email='$user'";
			$res = mysqli_query($conn, $sql);

			if(mysqli_num_rows($res) > 0){
				$userData = mysqli_fetch_assoc($res);
				$response->status='success';
				$response->data = $userData;
				header('HTTP/1.1 200');
				echo json_encode($response);
			}else{

			}
			}

		}catch(Exception $e){
		$response->status = $e->getMessage();
		header('HTTP/1.1 200');
			echo json_encode($response);
	    }
		
	}

	// $res = mysqli_query($conn, $sql);


	// if ($res==true) {
		


	// }else{
	// 	$response->status ='error';
	// 	header('HTTP/1.1 404');
	// 	echo json_encode($response);
	// }
?>