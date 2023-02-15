<?php
	include '../db_connection.php';
	include '../slugify.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
		$cookie=$_COOKIE['adminPass'];
		$check=actionAuth($cookie,'addArticles');	
		$response = new stdClass();
	
		if($check===true){
	if (isset($_POST['title'])) {
		$filename = $_FILES["img_link"]["name"];
    	$tempname = $_FILES["img_link"]["tmp_name"];  
		$folder = "../media/" .time(). '-'.$filename;
		$folder2 = time().'-'.$filename; 
    	$image_link='http://localhost/ototech_api/ototech_api/media/'.$folder2;
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$content = mysqli_real_escape_string($conn, $_POST['content']);
		$status = mysqli_real_escape_string($conn, $_POST['status']);
		$date = new DateTime;
		$day = date_format($date, 'd');
		$month = date_format($date, 'm');
		$year = date_format($date, 'Y');
		$slugged=slugify($title);
		$slug = $slugged;
		$category = mysqli_real_escape_string($conn, $_POST['category']);
		$arrayString=  explode("-", $category );
		$categorySlug = $arrayString['0'];
		$categoryId =$arrayString['1'];
		$authorId =mysqli_real_escape_string($conn, $_POST['author']);
		$sql = "INSERT INTO article SET
		title =' $title',
		categorySlug = '$categorySlug',
		categoryId = '$categoryId',
		authorId = '$authorId',
		image = '$image_link',
		slug = '$slug',
		content = '$content',
		status = '$status',
		day = '$day',
		month = '$month',
		year = '$year'";
		
		$res = mysqli_query($conn, $sql);
		if (move_uploaded_file($tempname, $folder)) {
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
