<?php
	include '../db_connection.php';
	$response = new stdClass;
	

	if (isset($_POST['pageId'])) {
	$page_link = mysqli_real_escape_string($conn, $_POST['page_link']);
	$pageId = mysqli_real_escape_string($conn, $_POST['pageId']);
	$date = new DateTime;
	$day = date_format($date, 'd');
	$month = date_format($date, 'm');
	$year = date_format($date, 'Y');

	$sql ="INSERT INTO likes SET 
	page_link ='$page_link',
    pageId = '$pageId',
    day = '$day',
    month ='$month',
    year = '$year'";

    $res = mysqli_query($conn, $sql);

    if ($res==true) {
        $response->status = 'success';
        header('HTTP/1.1 200');
        echo json_encode($response);
    }else{

    }

	}else{
    	$response->status = 'error';
        header('HTTP/1.1 200');
        echo json_encode($response);		
	}

?>