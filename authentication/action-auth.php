 <?php
	require_once '../vendor/autoload.php';
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	$JWT_SECRET = "secure_coding";


	function actionAuth($cookie, $priviledgeKey){
	$conn = mysqli_connect("localhost", "root","", "ototechblog");

	  try{

		$JWT_SECRET = "secure_coding";
		$decodeJWT = JWT::decode($cookie,new Key($JWT_SECRET, 'HS256'));
		$email = $decodeJWT->data;

		$sql = "SELECT * FROM staff WHERE email = '$email' AND status='active'";
		$res = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($res);

		if (mysqli_num_rows($res)==1) {

			if ($priviledgeKey=='addStaffs'&&$user['full_name']!=='admin') {
				return 'not Permitted';
			}else if ($priviledgeKey=='editStaffs'&&$user['full_name']!=='admin') {
				return 'not Permitted';
			}else if ($priviledgeKey=='deleteStaffs'&&$user['full_name']!=='admin') {
				return 'not Permitted';
			}else if($priviledgeKey==='logout'){
				return true;
			}else{

				$red=array_filter(json_decode($user['priveledges'],true),function($item) use ($priviledgeKey){
					return ($item['value']==$priviledgeKey);
				});

				if($red){
					return true;
				}else{
				    return 'not Permitted';	
				}
				
			}

		}else{
			return false;
		}
		
		}catch(Exception $e){
			return false;
		}
		
	}
 ?>