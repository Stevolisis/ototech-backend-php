<?php
	include '../db_connection.php';
	$response = new stdClass();
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
	    $cookie=$_COOKIE['adminPass'];
	    $check=actionAuth($cookie,'editSupportSystem');	
	    $response = new stdClass();

	    if($check===true){

	if (isset($_POST['phone_number'])) {
		$tel = mysqli_real_escape_string($conn, $_POST['phone_number']);
		$gmail = mysqli_real_escape_string($conn, $_POST['gmail']);
		$linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
		$whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
		$facebook =mysqli_real_escape_string($conn,$_POST['facebook']);
		$google_chat = mysqli_real_escape_string($conn, $_POST['google_chat']);
		
		$sql = "SELECT * FROM support";
		$res = mysqli_query($conn, $sql);
		// $count = mysqli_num_rows($res);

		if (mysqli_num_rows($res) > 0) {
			# code...
			$sql = "UPDATE support SET
			 phone_number = '$tel',
			 gmail ='$gmail',
			 linkedin = '$linkedin',
			 whatsapp = '$whatsapp',
			 facebook = '$facebook',
			 google_chat = '$google_chat'";
			 $res = mysqli_query($conn, $sql);

			 if ($res == true) {
			 	$response->status = 'success';
			 	header('HTTP/1.1 200');
			 	echo json_encode($response);
			 }

		}else{
			$sql = "INSERT support SET
			 phone_number = '$tel',
			 gmail ='$gmail',
			 linkedin = '$linkedin',
			 whatsapp = '$whatsapp',
			 facebook = '$facebook',
			 google_chat = '$google_chat'";
			 $res = mysqli_query($conn, $sql);
			 if ($res == true) {
			 	$response->status = "success";
			 	header('HTTP/1.1 200');
			 	echo json_encode($response);
			 }
		}
	
	}else{
		$response->status = "error";
		header('HTTP/1.1 200');
		echo json_encode($response);
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