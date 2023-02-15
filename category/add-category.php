<?php
	include '../db_connection.php';
	include '../slugify.php';
	include '../authentication/action-auth.php';

	if (isset($_COOKIE['adminPass'])) {
		$cookie=$_COOKIE['adminPass'];
		$check=actionAuth($cookie,'addCategories');	
		$response = new stdClass();
	
		if($check===true){

if (isset($_POST['name'])) {
	$filename = $_FILES["img_link"]["name"];
    $tempname = $_FILES["img_link"]["tmp_name"];  
	$folder = "../media/" .time(). '-'.$filename;
	$folder2 = time().'-'.$filename; 
    $image_link='http://localhost/ototech_api/ototech_api/media/'.$folder2;

	$category = mysqli_real_escape_string($conn, $_POST['name']);
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	$icon = mysqli_real_escape_string($conn, $_POST['icon']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$date =  new DateTime;
	$day = date_format($date, 'd');
	$month = date_format($date, 'm');
	$year = date_format($date, 'Y');

	$slugged=slugify($category);
	$slug=$slugged;


	$response = new stdClass();
	$sql = "INSERT INTO category SET
	name = '$category',
	description = '$description',
	slug = '$slug',
	image = '$image_link',
	day = '$day',
	month = '$month',
	icon = '$icon',
	status = '$status',
	year = '$year'";
	$res = mysqli_query($conn, $sql);



	if (move_uploaded_file($tempname, $folder)) {
		if ($res == true) {
		$response->status = "success";
		header('HTTP/1.1 200');
		echo json_encode($response);
		}else{
		$response->status = "error";
		header('HTTP/1.1 404');
		echo json_encode($response);
		}


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