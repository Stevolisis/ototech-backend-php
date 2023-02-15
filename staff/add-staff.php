<?php
	include '../db_connection.php';
	require_once '../vendor/autoload.php';
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	$JWT_SECRET = 'secure_coding';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
	    $cookie=$_COOKIE['adminPass'];
	    $check=actionAuth($cookie,'addStaffs');	
	    $response = new stdClass();

	    if($check===true){

	if (isset($_POST['full_name'])) {

		$filename = $_FILES["img_link"]["name"];
    	$tempname = $_FILES["img_link"]["tmp_name"];  
		$folder = "../media/" .time(). '-'.$filename;
		$folder2 = time().'-'.$filename; 
    	$image_link='http://localhost/ototech_api/ototech_api/media/'.$folder2;
		$full_name = $_POST['full_name'];
		$email = $_POST['email'];
		$position =  mysqli_real_escape_string($conn, $_POST['position']);
		$description =  mysqli_real_escape_string($conn, $_POST['description']);
		$priveledges = mysqli_real_escape_string($conn, $_POST['priveledges']);
		$password = md5( mysqli_real_escape_string($conn, $_POST['password']));
		$whatsapp =  mysqli_real_escape_string($conn, $_POST['whatsapp']);
		$dribble =  mysqli_real_escape_string($conn, $_POST['dribble']);
		$github =  mysqli_real_escape_string($conn, $_POST['github']);
		$linkedin =  mysqli_real_escape_string($conn, $_POST['linkedin']);
		$twitter =  mysqli_real_escape_string($conn, $_POST['twitter']);
		$instagram =  mysqli_real_escape_string($conn, $_POST['instagram']);
		$status =  mysqli_real_escape_string($conn, $_POST['status']);
		$date = new DateTime;
		$day =	date_format($date, 'd');
		$month =	date_format($date, 'm');
		$year =	date_format($date, 'Y');
		$response = new stdClass();


        if($full_name==='admin'){

		$sql = "SELECT * FROM staff WHERE full_name = '$full_name'";
		$res = mysqli_query($conn, $sql);

		if(mysqli_num_rows($res) > 0){
		$response->status = "Admin Already Exist";
		header('HTTP/1.1 202');
		echo json_encode($response);
		}else{

		$sql2 = "INSERT INTO staff SET
		full_name ='$full_name',
		email = '$email',
		position = '$position',
		description = '$description',
		priveledges = '$priveledges',
		password = '$password',
		whatsapp = '$whatsapp',
		dribble = '$dribble',
		github = '$github',
		linkedin ='$linkedin',
		twitter = '$twitter',
		instagram = '$instagram',
		status = '$status',
		image = '$image_link',
		day = '$day',
		month ='$month',
		year = '$year'";	


		$res2 = mysqli_query($conn, $sql2);

		
		if (move_uploaded_file($tempname, $folder)) {
		if ($res2 == true) {

		$iat=time();

		$payload = array(
		'iss' => 'http://localhost',
		'iat' =>  $iat,
		'nbf' => $iat,
		'exp' => $iat+ 60*60,
		'aud' => 'http://localhost:3000',
		'data'=> $email,   
		);
		$jwt=JWT::encode($payload, $JWT_SECRET,'HS256');

	   setcookie('tryCookie', $jwt, time() + (86400 * 30), "/",'',true,true);

		$response->token = $jwt;
		$response->status = "success";
		header('HTTP/1.1 200');
		echo json_encode($response);

		}else{

		$response->status = "error";
		header('HTTP/1.1 404');
		echo json_encode($response);

		}

		}

        }





        }else{


		$sql2 = "INSERT INTO staff SET
		full_name ='$full_name',
		email = '$email',
		position = '$position',
		description = '$description',
		priveledges = '$priveledges',
		password = '$password',
		whatsapp = '$whatsapp',
		dribble = '$dribble',
		github = '$github',
		linkedin ='$linkedin',
		twitter = '$twitter',
		instagram = '$instagram',
		status = '$status',
		image = '$image_link',
		day = '$day',
		month ='$month',
		year = '$year'";	

		
		$res2 = mysqli_query($conn, $sql2);

		
		if (move_uploaded_file($tempname, $folder)) {
		if ($res2 == true) {

		$iat=time();

		$payload = array(
		'iss' => 'http://localhost',
		'iat' =>  $iat,
		'nbf' => $iat,
		'exp' => $iat+ 60*60,
		'aud' => 'http://localhost:3000',
		'data'=> $email,   
		);
		$jwt=JWT::encode($payload, $JWT_SECRET,'HS256');

	   setcookie('tryCookie', $jwt, time() + (86400 * 30), "/",'',true,true);

		$response->token = $jwt;
		$response->status = "success";
		header('HTTP/1.1 200');
		echo json_encode($response);

		}else{

		$response->status = "error";
		header('HTTP/1.1 404');
		echo json_encode($response);

		}

		}

    }
	}


	}else if($check==='not Permitted'){
	    	$response->status = "not Permitted";
			header('HTTP/1.1 200');
			echo json_encode($response);
	    }else{
	    	$response->status = "Invalid User";
			header('HTTP/1.1 200');
			echo json_encode($response);	
	    }

	}else{
	    $response = new stdClass();
    	$response->status = "no Cookie";
		header('HTTP/1.1 200');
		echo json_encode($response);
	}



?>