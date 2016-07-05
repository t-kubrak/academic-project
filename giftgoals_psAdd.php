<?php
include 'db_conn.php';

  	//true/false variable for completed form
  	$validForm = true; //start true, and flip false if any fail
	$errorMsg = "";
	
	// function to clean up data input
	function pre_test_input($data) {
		$data = trim($data); //remove blank spaces
		$data = stripslashes($data); //remove \'s
		$data = htmlspecialchars($data); //protect against html
		return $data;
	}
	
	//get the submitted data into variables
	//if(isset($_POST['submit'])){
		$sid=$_POST['add'];
		$pid=$_POST['pid'];
		$pURL=pre_test_input($_POST['prodURL']);
	//}
//echo"<p>store ".$sid."  pid ".$pid." url ".$pURL."</p>";

$insertStore = "INSERT INTO storelist (productID, storeID, productURL) VALUES('$pid', '$sid', '$pURL')";
mysqli_query($conn, $insertStore);

$conn->close();

header("Location: product.php?pid=".$pid); ?>
