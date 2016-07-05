<?php
function pre_test_input($data) {
	$data = trim($data); //remove blank spaces
	$data = addslashes($data); //add \'s
	$data = htmlentities($data); //protect against html
	return $data;
}

function connectToDatabase()
{
	$link = mysqli_connect('localhost', '', '', '');
	if (!$link)
	{
		echo mysqli_connect_error();
		die("Error occured while processing your request, please try again later.");
	}
	return $link;
}

function validateName($name)
{
	if ($name == ""){
		return "Name can not be blank";
	}else{
		return "";
	}
}

function validatePassword($password)
{
	$upperCaseRegex = "/[A-Z]/";
	$lowerCaseRegex = "/[a-z]/";
	$numericRegex = "/[0-9]/";

	if ($password == ""){
		return "Password can not be blank";
	}elseif (strlen($password) < 8){
		return "Password must be at least 8 characters long";
	}elseif(!preg_match($upperCaseRegex, $password)){
		return "Password must have at least one upper case letter";
	}elseif(!preg_match($lowerCaseRegex, $password)){
		return "Password must have at least one lower case letter";
	}elseif(!preg_match($numericRegex, $password)){
		return "Password must have at least one numeric character";
	}else{
		return "";
	}
}
function validatePassword2($password, $password2)
{
	if ($password2 == ""){
		return "Re-Enter Password can not be blank.";
	}elseif ($password != $password2){
		return "Passwords do not match.";
	}else{
		return "";
	}
}

function resamplePicture($filePath, $destinationPath, $maxWidth, $maxHeight)
{
	if (!file_exists($destinationPath)) {
		mkdir($destinationPath);
	}

	$imageDetails = getimagesize($filePath);
	$originalResource = null;

	if ($imageDetails[2] == IMAGETYPE_JPEG) {
		$originalResource = imagecreatefromjpeg($filePath);
	} elseif ($imageDetails[2] == IMAGETYPE_PNG) {
		$originalResource = imagecreatefrompng($filePath);
	} elseif ($imageDetails[2] == IMAGETYPE_GIF) {
		$originalResource = imagecreatefromgif($filePath);
	}

	$widthRatio = $imageDetails[0] / $maxWidth;
	$heightRatio = $imageDetails[1] / $maxHeight;
	$ratio = max($widthRatio, $heightRatio);

	$newWidth = $imageDetails[0] / $ratio;
	$newHeight = $imageDetails[1] / $ratio;

	$newImage = imagecreatetruecolor($newWidth, $newHeight);
	$success = imagecopyresampled($newImage, $originalResource, 0, 0, 0, 0, $newWidth, $newHeight, $imageDetails[0], $imageDetails[1]);

	if (!$success) {
		imagedestroy($newImage);
		imagedestroy($originalResource);
		return "";
	}

	$pathInfo = pathinfo($filePath);
	$newFilePath = $destinationPath."/".$pathInfo['filename'];

	if ($imageDetails[2] == IMAGETYPE_JPEG){
		$newFilePath .= ".jpg";
		$success = imagejpeg($newImage, $newFilePath, 100);
	} elseif ($imageDetails[2] == IMAGETYPE_PNG) {
		$newFilePath .= ".png";
		$success = imagepng($newImage, $newFilePath, 0);
	} elseif ($imageDetails[2] == IMAGETYPE_GIF) {
		$newFilePath .= ".gif";
		$success = imagegif($newImage, $newFilePath);
	}

	imagedestroy($newImage);
	imagedestroy($originalResource);

	if (!$success) {
		return "";
	} else {
		return $newFilePath;
	}
}

function addPoints($userId, $conn){
	$updatePointsQuery = "UPDATE users SET points = points + 1 WHERE userID=$userId";
	return mysqli_query($conn, $updatePointsQuery);
}