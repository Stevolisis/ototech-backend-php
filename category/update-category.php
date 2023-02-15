<?php
	include '../db_connection.php';
	include '../authentication/action-auth.php';

if (isset($_COOKIE['adminPass'])) {
	$cookie=$_COOKIE['adminPass'];
	$check=actionAuth($cookie,'editCategories');	
	$response = new stdClass();

	if($check===true){

	if (isset($_POST['name'])) {
		$id = $_POST['id'];
		$category = $_POST['name'];
		$description = $_POST['description'];
		$icon = $_POST['icon'];
		$status = $_POST['status'];
        $folder="";
        $tempname="";
        $sql=new stdClass();
		$user="SELECT * FROM category WHERE id =$id";
		$rest = mysqli_query($conn, $user);
		$userTrue=mysqli_fetch_assoc($rest);

	if($_FILES["img_link"]['name']!==''){
		$image = $userTrue['image'];
		$arrayString=  explode("media/", $image );
		$img_name = $arrayString['1'];
		$delete_path = "../media/" . $img_name;
		$filename = $_FILES["img_link"]["name"];
   		$tempname = $_FILES["img_link"]["tmp_name"];  
		$folder = "../media/" .time(). '-'.$filename;
		$folder2 = time().'-'.$filename; 
    	$image_link='http://localhost/ototech_api/ototech_api/media/'.$folder2;	

    	$sql = "UPDATE category SET
		name = '$category',
		description = '$description',
		image = '$image_link',
		icon = '$icon',
		status = '$status' WHERE id = $id";

	    move_uploaded_file($tempname, $folder); 
		unlink($delete_path);
		}else{

		$sql = "UPDATE category SET
		name = '$category',
		description = '$description',
		icon = '$icon',
		status = '$status' WHERE id = $id";

		}
		
		$response = new stdClass();
		$res = mysqli_query($conn, $sql);

		if ($res == true) {
			$response->status = "success";
    		header('HTTP/1.1 200');
    		echo json_encode($response);
		}else{
			$response->status = "error";
    		header('HTTP/1.1 404');
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