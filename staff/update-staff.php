<?php
	include '../db_connection.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
	    $cookie=$_COOKIE['adminPass'];
	    $check=actionAuth($cookie,'editStaffs');	
	    $response = new stdClass();

	    if($check===true){
		$id = $_POST['id'];
		$full_name = $_POST['full_name'];
		$email = $_POST['email'];
		$position =  mysqli_real_escape_string($conn, $_POST['position']);
		$description =  mysqli_real_escape_string($conn, $_POST['description']);
		$priveledges = mysqli_real_escape_string($conn, $_POST['priveledges']);
		$whatsapp =  mysqli_real_escape_string($conn, $_POST['whatsapp']);
		$dribble =  mysqli_real_escape_string($conn, $_POST['dribble']);
		$github =  mysqli_real_escape_string($conn, $_POST['github']);
		$linkedin =  mysqli_real_escape_string($conn, $_POST['linkedin']);
		$twitter =  mysqli_real_escape_string($conn, $_POST['twitter']);
		$instagram =  mysqli_real_escape_string($conn, $_POST['instagram']);
		$status =  mysqli_real_escape_string($conn, $_POST['status']);
		$folder="";
	    $tempname="";
	    $sql=new stdClass();
		$user="SELECT * FROM staff WHERE id =$id";
		$rest = mysqli_query($conn, $user);
		$userTrue=mysqli_fetch_assoc($rest);

	     if ($_FILES["img_link"]['name'] !== '') {
			$image = $userTrue['image'];
			$arrayString=  explode("media/", $image );
			$img_name = $arrayString['1'];
			$delete_path = "../media/" . $img_name;
			$filename = $_FILES["img_link"]["name"];
			$tempname = $_FILES["img_link"]["tmp_name"];  
			$folder = "../media/" .time(). '-'.$filename;
			$folder2 = time().'-'.$filename; 
	    	$image_link='http://localhost/ototech_api/ototech_api/media/'.$folder2;

	    	$sql = "UPDATE staff SET
			full_name ='$full_name',
			email = '$email',
			position = '$position',
			description = '$description',
			priveledges = '$priveledges',
			whatsapp = '$whatsapp',
			dribble = '$dribble',
			github = '$github',
			linkedin ='$linkedin',
			twitter = '$twitter',
			instagram = '$instagram',
			status = '$status',
			image = '$image_link' WHERE id=$id";
			move_uploaded_file($tempname, $folder); 
			unlink($delete_path);
	     }else{
	     	$sql = "UPDATE staff SET
			full_name ='$full_name',
			email = '$email',
			position = '$position',
			description = '$description',
			priveledges = '$priveledges',
			whatsapp = '$whatsapp',
			dribble = '$dribble',
			github = '$github',
			linkedin ='$linkedin',
			twitter = '$twitter',
			instagram = '$instagram',
			status = '$status' WHERE id=$id";

	     }

		$res = mysqli_query($conn, $sql);

		if ($res == true) {
			$response->status = "success";
			$response->actionAuth2= $check;
			$response->actionAuth= $cookie;
			header('HTTP/1.1 200');
			echo json_encode($response);
		}else{
			$response->status = "error";
			header('HTTP/1.1 404');
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