<?php
	include '../db_connection.php';
	include '../slugify.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
		$cookie=$_COOKIE['adminPass'];
		$check=actionAuth($cookie,'editArticles');	
		$response = new stdClass();
	
		if($check===true){

	if (isset($_POST['title'])) {
		$id = $_POST['id'];
		$filename = "";
    	$tempname = "";  
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$content = mysqli_real_escape_string($conn, $_POST['content']);
		$status = mysqli_real_escape_string($conn, $_POST['status']);
		$category = mysqli_real_escape_string($conn, $_POST['category']);
		$arrayString=  explode("-", $category );
		$categorySlug = $arrayString['0'];
		$categoryId =$arrayString['1'];
		$authorId =mysqli_real_escape_string($conn, $_POST['author']);
		$date = new DateTime;
		$day = date_format($date, 'd');
		$month = date_format($date, 'm');
		$year = date_format($date, 'y');
		$slugged=slugify($title);
		$slug = $slugged;
		$response = new stdClass();

		$user="SELECT * FROM article WHERE id =$id";
		$rest = mysqli_query($conn, $user);
		$userTrue=mysqli_fetch_assoc($rest);

		if ($_FILES["img_link"]['name'] !== '') {
			$image = $userTrue['image'];
			$arrayString=  explode("media/", $image );
			$img_name = $arrayString['1'];
			$delete_path = "../media/" . $img_name;

			$filename = $_FILES["img_link"]['name'];
			$tempname = $_FILES['img_link']['tmp_name'];
			$folder = "../media/" .time(). '-'.$filename;
			$folder2 = time().'-'.$filename; 
    	    $image_link='http://localhost/ototech_api/ototech_api/media/'.$folder2;

			$sql = "UPDATE article SET
			title ='$title',
			categorySlug = '$categorySlug',
			categoryId = '$categoryId',
			authorId = '$authorId',
			image = '$image_link',
			slug = '$slug',
			content = '$content',
			status = '$status'
			WHERE id=$id";
			move_uploaded_file($tempname, $folder);
            unlink($delete_path);
            
			$res = mysqli_query($conn, $sql);
			if ($res == true) {
				$response->status = "success";
				header("HTTP/1.1 200");
				echo json_encode($response);
			}else{
				$response->status = "error";
				header("HTTP/1.1 404");
				echo json_encode($response);
			}



		}else{
			$sql = "UPDATE article SET
			title ='$title',
			categorySlug = '$categorySlug',
			categoryId = '$categoryId',
			authorId = '$authorId',
			slug = '$slug',
			content = '$content',
			status = '$status'
			 WHERE id=$id";
			$res = mysqli_query($conn, $sql);
			if ($res == true) {
				$response->status = "success";
				header("HTTP/1.1 200");
				echo json_encode($response);
			}else{
				$response->status = "error";
				header("HTTP/1.1 404");
				echo json_encode($response);
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
