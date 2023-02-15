<?php
	include '../db_connection.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
	    $cookie=$_COOKIE['adminPass'];
	    $check=actionAuth($cookie,'editUsers');	
	    $response = new stdClass();

	    if($check===true){

	if (isset($_POST['full_name'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$fullname = mysqli_real_escape_string($conn, $_POST['full_name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$response = new stdClass();

	$sql = "UPDATE users SET 
	full_name = '$fullname',
	email = '$email' WHERE id=$id";
	$res = mysqli_query($conn, $sql);

	if ($res==true) {
		$response->status = "success";
		header("HTTP/1.1 200");
		echo json_encode($response);
	}else{
		$response->status = "error";
		header("HTTP/1.1 404");
		echo json_encode($response);
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