<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
require_once '../vendor/autoload.php';
require_once '../db_conn.php';

$fb = new Facebook\Facebook([
	'app_id' => '767562826713610',
	'app_secret' => 'a7e0edba4bd8647e41e7ec11da066e12',
	'default_graph_version' => 'v2.2',
]);

$helper = $fb->getJavaScriptHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if (! isset($accessToken)) {
	echo 'No cookie set or no OAuth data could be obtained from cookie.';
	header('Location: /');
	exit;
}else{
	$_SESSION['fb_access_token'] = (string) $accessToken;

	try {
		$response = $fb->get('/me?fields=id,name,age_range,picture,email,gender,link', $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$user = $response->getGraphUser();

	$_SESSION['fb_user'] = (string) $user;
	$fbu = $user != null ? json_decode((string)$user) : null;

	$userId = null;
	//$email = $fbu->email;
	$userQuery = "SELECT userID, userName FROM users WHERE email='$fbu->id'";
	$result = mysqli_query($conn, $userQuery);

	if(mysqli_num_rows($result)==0){
		$insertUser = "INSERT INTO users ( email, userName, password, birth, uDateAdded, image, gender) VALUES(?, ?, ?, ?, ?, ?, ?)";
		$preparedUserInsert = mysqli_prepare($conn, $insertUser);

		$date = date("Y-m-d");
		$image = "//graph.facebook.com/{$fbu->id}/picture?height=150&width=150";

		//Generating random pass
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$password = implode($pass);

		//Generating random salt
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 22);
		$salt = '$2a$09$'.$randomString.'$';

		$hashedPassword = crypt($password, $salt);

		$birth = 1901;

		mysqli_stmt_bind_param($preparedUserInsert, 'sssisss', $fbu->id, $fbu->name, $hashedPassword, $birth, $date, $image, $fbu->gender);

		if (!mysqli_stmt_execute($preparedUserInsert)) {
			//var_dump($fbu);
			//echo $email."<br>".$fbu->name."<br>".$password."<br>".$birth."<br>".$date."<br>".$image."<br>".$fbu->gender."<br>";
			die("The system is not available, try again later");
		}else{
			$userId = mysqli_insert_id($conn);
		}
	}else{
		$user = mysqli_fetch_assoc($result);
		$userId = $user['userID'];
	}

	error_reporting(E_ALL);

	$_SESSION['userID'] = $userId;
	$_SESSION['userName'] = $fbu->name;

	mysqli_close($conn);

	// User is logged in! We can redirect them to another page.
	header('Location: /');
	exit();
}
?>
