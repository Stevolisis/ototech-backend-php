<?php
    require_once '../vendor/autoload.php';
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	$JWT_SECRET = "secure_coding";
///
    $response = new stdClass();

	if (isset($_GET['cookie'])) {
	try{
		$JWT_SECRET = "secure_coding";
		$cookie = $_GET['cookie'];
		$decodeJWT = JWT::decode($cookie,new Key($JWT_SECRET, 'HS256'));

		$response->decodeJWT = $decodeJWT;
		$response->status ='success';
		header("HTTP/1.1 200");
		echo json_encode($response);
		
	}catch(Exception $e){
		$response->status = 'error';
		$response->errorMessage = $e->getMessage();
		header("HTTP/1.1 404");
		echo json_encode($response);

	}

 }else{
 		$response->status = $_COOKIE;
		header("HTTP/1.1 404");
		echo json_encode($response);	
 }
?>