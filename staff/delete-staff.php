<?php
	include '../db_connection.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
	    $cookie=$_COOKIE['adminPass'];
	    $check=actionAuth($cookie,'deleteStaffs');	
	    $response = new stdClass();

	    if($check===true){

			$id = $_POST['id'];
			$user = "SELECT * FROM staff WHERE id=$id";
			$res = mysqli_query($conn, $user);
			$rows = mysqli_fetch_assoc($res);
			$image = $rows['image'];
			$arrayString=  explode("media/", $image );
			$img_name = $arrayString['1'];
			$delete_path = "../media/" . $img_name;
			$response = new stdClass();
			
			if (unlink($delete_path)) {
				$sql = "DELETE FROM staff WHERE id=$id";
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