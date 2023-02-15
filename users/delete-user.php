<?php
	include '../db_connection.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
	    $cookie=$_COOKIE['adminPass'];
	    $check=actionAuth($cookie,'deleteUsers');	
	    $response = new stdClass();

	    if($check===true){

	$id =(int)$_POST['id'];
	$sql = "DELETE FROM users WHERE id=$id";
	$res = mysqli_query($conn, $sql);
	$response = new stdClass();
	if ($res == true) {
		$response->status = "success";
		$response->id = $id;
    	header('HTTP/1.1 200');
    	echo json_encode($response);
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