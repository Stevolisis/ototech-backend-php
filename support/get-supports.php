<?php
 include '../db_connection.php';
 $response= new stdClass();
 $sql = "SELECT * FROM support";
 $res = mysqli_query($conn, $sql);
 $count = mysqli_num_rows($res);

 if ($count>0) {
 	 $row = mysqli_fetch_assoc($res);
 	 $response->status = "success";
 	 $response->data = $row;
 	 header('HTTP/1.1 200');
 	 echo json_encode($response);

 }else{
 	$response->status = "no Data";
 	header('HTTP/1.1 200');
 	echo json_encode($response);
 }
?>