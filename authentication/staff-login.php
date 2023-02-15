<?php
	include '../db_connection.php';
	require_once '../vendor/autoload.php';
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	$JWT_SECRET = "secure_coding";
	$response = new stdClass();

	if (isset($_POST['email'])) {
		# code...
		$email =mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));
		$sql = "SELECT * FROM staff WHERE email = '$email' AND password = '$password' AND status='active'";
		$res = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($res);

		if ($count==1) {
			$iat = time();
			$payload = array(
			'iss' => 'http://localhost',
			'iat' => $iat,
			'nbf' => $iat,
			'exp' => $iat + 720,
			'aud' => 'http://localhost:3000',
			'data' => $email
			);
			$jwt = JWT::encode($payload, $JWT_SECRET, 'HS256');
			// setcookie('adminPass', $jwt, time() + (720), "/",'',true,true);
			setcookie('adminPass', $jwt, ['samesite' => 'None',
            'domain'=>null,
            'secure' => true,
            'httponly'=>true,
            'expires'=>time()+60*60*24*30, 'path'=>'/']);

			$response->token = $jwt;
			$response->email = $email;
			$response->password = $password;
			$response->status = 'success';
			header('HTTP/1.1 200');
			echo json_encode($response);

			}else{
			$response->email = $email;
			$response->password = $password;
				$response->status = 'Invalid Credentials2';
				header('HTTP/1.1 200');
				echo json_encode($response);
			}

		
	}

?>