<?php
// Make the script run only if there is a page number posted to this script
$sql = "";
$sqlSearch = "";
if(isset($_POST['pn'])){
	$rpp = preg_replace('#[^0-9]#', '', $_POST['rpp']);
	$last = preg_replace('#[^0-9]#', '', $_POST['last']);
	$pn = preg_replace('#[^0-9]#', '', $_POST['pn']);
	$search_txt = preg_replace('#[^a-z 0-9?!@.\-]#i', '', $_POST['q']);
	$agesPosted = $_POST['ages'];
	$gendersPosted = $_POST['genders'];
	$catPosted = $_POST['cat'];
	
		$words = explode(" ",$search_txt);
		$arrLength = count($words);
		
		for($i = 0; $i < $arrLength; $i++)
		{
			$sqlSearch .= "products.productName LIKE '%".$words[$i]."%'";
			if($arrLength > 1 && $i < ($arrLength - 1))
			{
				$sqlSearch .= " OR ";
			}
		}
		$ages = explode(" ",$agesPosted);
		$agesLength = count($ages);
		$ageSearch = "";
		if ($agesLength > 0) {
			for ($y = 0; $y < $agesLength; $y++) {
				$ageSearch .= "ageID LIKE ".$ages[$y]; 
				if($agesLength > 1 && $y < ($agesLength - 1))
				{
					$ageSearch .= " OR ";
				}			
			}
		}
		$genders = explode(" ",$gendersPosted);
		$genLength = count($genders);
		$genSearch = "";
		if ($genLength > 0) {
			for ($y = 0; $y < $genLength; $y++) {
				$genSearch .= "genderID LIKE ".$genders[$y]; 
				if($genLength > 1 && $y < ($genLength - 1))
				{
					$genSearch .= " OR ";
				}			
			}
		}
		$cats = explode(" ",$catPosted);
		$catLength = count($cats);
		$catSearch = "";
		for ($y = 0; $y < $catLength; $y++) {
			$catSearch .= "categoryID LIKE ".$cats[$y]; 
			if($catLength > 1 && $y < ($catLength - 1))
			{
				$catSearch .= " OR ";
			}			
		}
	// This makes sure the page number isn't below 1, or more than our $last page
	if ($pn < 1) { 
    	$pn = 1; 
	} else if ($pn > $last) { 
    	$pn = $last; 
	}
	// Connect to our database here
	include_once("db_conn.php");
	// This sets the range of rows to query for the chosen $pn
	$limit = 'LIMIT ' .($pn - 1) * $rpp .',' .$rpp;
	// This is your query again, it is for grabbing just one page worth of rows by applying $limit
	$sqlCommand = "select DISTINCT products.productID as productID, products.productName as productName, products.imageURL as imageURL 
	from products 
	join categorylist on products.productID = categorylist.productID 
	join genderlist on products.productID = genderlist.productID
	join agelist on products.productID = agelist.productID
	WHERE ($sqlSearch)";
	if(isset($_POST['ages'])) {
		$sqlCommand .= " AND (".$ageSearch.")";
	}
	$sqlCommand .= "AND `numReports` < 3 $limit";
	$sql = "SELECT DISTINCT products.productID, productName, imageURL FROM products ";
	if(isset($_POST['cat']) && $_POST['cat'] != "") {
		$sql .= "join categorylist on products.productID = categorylist.productID ";
	}
	if(isset($_POST['ages']) && $_POST['ages'] != "") {
		$sql .= "join agelist on products.productID = agelist.productID ";
	}
	if(isset($_POST['genders']) && $_POST['genders'] != "") {
		$sql .= "join genderlist on products.productID = genderlist.productID ";
	}
	$sql .= "WHERE (".$sqlSearch.")";
	if(isset($_POST['ages']) && $_POST['ages'] != "") {
		$sql .= " AND (".$ageSearch.") ";
	}
	if(isset($_POST['genders']) && $_POST['genders'] != "") {
		$sql .= " AND (".$genSearch.")";
	}
	if(isset($_POST['cat']) && $_POST['cat'] != "") {
		$sql .= " AND (".$catSearch.")";
	}
	$sql .= " AND numReports < 3 ORDER BY productName ASC $limit";
	$query = mysqli_query($conn, $sql);
	$dataString = '';
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
		$id = $row["productID"];
		$productname = $row["productName"];
		$image = $row["imageURL"];
		$dataString .= $id.'|'.$productname.'|'.$image.'||';
	}
	// Close your database connection
    mysqli_close($conn);
	// Echo the results back to Ajax
	echo $dataString;
	exit();
}
?>