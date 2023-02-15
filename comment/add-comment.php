
<?php
	include '../db_connection.php';
    require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$JWT_SECRET = "secure_coding";
$response = new stdCLass();


if (isset($_POST['full_name'])) {

$fullname = mysqli_real_escape_string($conn, $_POST['full_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$pageId = mysqli_real_escape_string($conn, $_POST['pageId']);
$comment = mysqli_real_escape_string($conn, $_POST['comment']);
$date = new DateTime;
$day = date_format($date, 'd');
$month = date_format($date, 'm');
$year = date_format($date, 'Y');

$check_user = "SELECT email FROM users WHERE email = '$email'";
$res = mysqli_query($conn, $check_user);
// $count = mysqli_num_rows($res);




if (mysqli_num_rows($res) > 0) {

    $sql2="SELECT * FROM users WHERE email='$email'";

    $res2 = mysqli_query($conn, $sql2);
    $userData = mysqli_fetch_assoc($res2);

    if(mysqli_num_rows($res2) > 0){
    $userId=$userData['id'];
    $sql3 = "INSERT INTO comments SET
    comment = '$comment',
    userId = '$userId',
    pageId = '$pageId',
    day = '$day',
    month ='$month',
    year = '$year'"; 
    }

    $res3 = mysqli_query($conn, $sql3);

    if ($res == true && $res3 == true) {
        $iat = time();
        $payload = array(
        'iss' => 'http://localhost',
        'iat' => $iat,
        'nbf' => $iat,
        'exp' => $iat + 60*60,
        'aud' => 'http://localhost:3000',
        'data' => $email
        );
        $jwt = JWT::encode($payload, $JWT_SECRET, 'HS256');
        setcookie('token', $jwt, time() + (86400*30), "/",'');
        $response->token = $pageId;
        $response->status = 'success';
        header('HTTP/1.1 200');
        echo json_encode($response);
    }else{
        $response->status = 'error';
        header('HTTP/1.1 404');
        echo json_encode($response);
    }
    
}else{

    $sql1 ="INSERT INTO users SET 
    full_name = '$fullname',
    email ='$email',
    status ='active',
    day = '$day',
    month ='$month',
    year = '$year'";

    $sql2="SELECT * FROM users WHERE email='$email'";

    $res1 = mysqli_query($conn, $sql1);
    $res2 = mysqli_query($conn, $sql2);
    $userData = mysqli_fetch_assoc($res2);

    if(mysqli_num_rows($res2) > 0){
    $userId=$userData['id'];
    $sql3 = "INSERT INTO comments SET
    comment = '$comment',
    userId = '$userId',
    pageId = '$pageId',
    day = '$day',
    month ='$month',
    year = '$year'"; 
    }

    $res3 = mysqli_query($conn, $sql3);

    if ($res1==true && $res3==true) {
        $iat = time();
        $payload = array(
        'iss' => 'http://localhost',
        'iat' => $iat,
        'nbf' => $iat,
        'exp' => $iat + 60*60,
        /////// 3000 not 300
        'aud' => 'http://localhost:3000',   
        'data' => $email
        );
        $jwt = JWT::encode($payload, $JWT_SECRET, 'HS256');
        setcookie('token', $jwt, time() + (86400*30), "/:3000",'');
        $response->token = $jwt;
        $response->status = 'success';
        header('HTTP/1.1 200');
        echo json_encode($response);

    }else{
        $response->status = 'error';
        header('HTTP/1.1 404');
        echo json_encode($response);
        echo $sql;
    }
}

}else{
$response->status = 'error Submit';
header('HTTP/1.1 404');
echo json_encode($response);
}
// try{
// 		$JWT_SECRET = "secure_coding";
// 		$cookie = $_COOKIE['token'];
// 		$decodeJWT = JWT::decode($cookie,new Key($JWT_SECRET, 'HS256'));
// 		$response->decodeJWT = $decodeJWT;
// 		// $decodeJWT->data = ;
// 		echo json_encode($response); 
    
// 	}catch(Exception $e){
// 		$response->status = $e->getMessage();
// 		header('HTTP/1.1 200');
// 			echo json_encode($response);

// 	}

?>