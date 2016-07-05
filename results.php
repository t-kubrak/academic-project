<?php
$title = "Gift Goals - Search Results";
include_once "header.php";
$total_rows = 0;
$searchquery = "";
$sqlSearch = "";
$ageQuery = "SELECT * FROM ages";
$ageQueryResult = mysqli_query($conn, $ageQuery);
$inCategories = "";
$sqlcount = "";
$genderQuery = "SELECT * FROM genders";
$genderQueryResult = mysqli_query($conn, $genderQuery);

$categoriesQuery = "SELECT * FROM categories order by catName";
$categoriesQueryResult = mysqli_query($conn, $categoriesQuery);
if(isset($_POST['searchquery']) || isset($_GET['searchquery'])){
	$searchquery = preg_replace('#[^a-z 0-9?!@.\-]#i', '', $_POST['searchquery']);
	$numPrPage = preg_replace('#[^0-9]#', '', $_POST['numPerPage']);
		$words = explode(" ",$searchquery);
		$arrLength = count($words);
		$sqlSearch = "";
		for($i = 0; $i < $arrLength; $i++)
		{
			$sqlSearch .= "productName LIKE '%".$words[$i]."%'";
			if($arrLength > 1 && $i < ($arrLength - 1))
			{
				$sqlSearch .= " OR ";
			}
		}
		$ages = explode(" ",$agesPosted);

		$agesSelected = preg_replace('#[^0-9]#', '', $_POST['ages']);
		$agesLength = count($agesSelected);
		$ageSearch = "";
		$test2 = "";
		for ($y = 0; $y < $agesLength; $y++) {
			$ageSearch .= "ageID LIKE ".$agesSelected[$y]; 
			$test2 .= $agesSelected[$y];
			if($agesLength > 1 && $y < ($agesLength - 1))
			{
				$ageSearch .= " OR ";
				$test2 .= " ";
			}			
		}
		$genderSelected = preg_replace('#[^0-9]#', '', $_POST['genders']);
		$genderLength = count($genderSelected);
		$genderSearch = "";
		$gen = "";
		for ($y = 0; $y < $genderLength; $y++) {
			$genderSearch .= "genderID LIKE ".$genderSelected[$y];
			$gen .= $genderSelected[$y];
			if($genderLength > 1 && $y < ($genderLength -1)) {
				$genderSearch .= " OR ";
				$gen .= " ";
			}
		}
		
		$catSelected = preg_replace('#[^0-9]#', '', $_POST['categories']);
		//$catSelected = $_GET['catID'];
		if ($catSelected == "") {
			$catSelected = preg_replace('#[^0-9]#', '', $_GET['catID']);
		}
		$catLength = count($catSelected);
		$catSearch = "";
		$cat = "";
		for ($y = 0; $y < $catLength; $y++) {
			$catSearch .= "categoryID LIKE ".$catSelected[$y];
			$cat .= $catSelected[$y];
			if($catLength > 1 && $y < ($catLength -1)) {
				$catSearch .= " OR ";
				$cat .= " ";
			}
		}
		
	$sqlcount = "SELECT DISTINCT products.productID FROM products ";
	if (isset($_POST['categories']) || isset($_GET['catID'])) {
		$sqlcount .= "join categorylist on products.productID = categorylist.productID ";
	}
	if (isset($_POST['ages'])) {
		$sqlcount .= "join agelist on products.productID = agelist.productID ";
	}
	if (isset($_POST['genders'])) {
		$sqlcount .= "join genderlist on products.productID = genderlist.productID ";
	}
	$sqlcount .= "WHERE (".$sqlSearch;
	if(isset($_POST['ages'])) {
		$sqlcount .=") AND (".$ageSearch;
	}
	if(isset($_POST['genders'])) {
		$sqlcount .= ") AND (".$genderSearch;
	}
	if(isset($_POST['categories']) || isset($_GET['catID'])) {
		$sqlcount .= ") AND (".$catSearch;
	}
	$sqlcount .=") AND numReports < 3";
		$sqlResults = $conn->query($sqlcount);
		$total_rows = $sqlResults->num_rows;
	if(isset($_POST['numPerPage'])) {
		$rpp = preg_replace('#[^0-9]#', '', $_POST['numPerPage']);
	} else {
		$rpp = 12;
	}
	$last = ceil($total_rows/$rpp);
	if($last < 1){
		$last = 1;
	}
}
?>
<script>
function onSelectChange() {
	document.getElementById("search").submit();
}
</script>
<div class"row"><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="search">
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="col-md-2 col-sm-2 col-xs-4" id="searchLimiters">
		<p>Search limiters<br>
		  <input name="submit" type="submit" class="btn btn-default" id="submit" value="Apply Filters" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" formmethod="POST"><input type="hidden">
		</p>
		<p>Category</p>
			<?php
			while($category = mysqli_fetch_assoc($categoriesQueryResult)){
				echo "<label><input type='checkbox' name='categories[]' value='$category[catID]'";
				if(in_array("$category[catID]", $catSelected)) {
					echo "checked";
					$inCategories .= "$category[catName] ";
				}
				echo "> $category[catName]</label><br>";
			}
			?>        
		<p>Age</p>
			<?php
				while($age = mysqli_fetch_assoc($ageQueryResult)){
					echo "<label><input type='checkbox' class='ages' name='ages[]' value='$age[ageID]'";
					if (in_array("$age[ageID]", $agesSelected)) {
						echo "checked";
					}
					echo "> $age[ageText]</label><br>";
				}
			?> <input name="ageList" type="hidden" id="ageList">
		<p>Gender</p>
			<?php
			while($gender = mysqli_fetch_assoc($genderQueryResult)){
				echo "<label><input type='checkbox' name='genders[]' value='$gender[genderID]'";
				if (in_array("$gender[genderID]", $genderSelected)) {
					echo "checked";
				}
				echo "> $gender[genderText]</label><br>";
			}
			?>
        <div><br><input name="submit" type="submit" class="btn btn-default" id="submit" value="Apply Filters" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" formmethod="POST"><br><br></div>
	</div>
<!--	<div class="col-md-10">
  Search For:
  <input class="form-control" name="searchquery" type="text" id="searchInput" value="<?php if(isset($_POST['searchquery']) && $_POST['searchquery'] != "") { echo $searchquery;} ?>" size="44" maxlength="88" >
  <input type="submit" class="btn btn-default" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" formmethod="POST">
  <br>
                <hr>
	</div>-->
    <input name="searchquery" type="hidden" id="searchquery" value="<?php { echo $searchquery;} ?>">
<table id="resultsInfoTable" width="75%" border="0" align="center" cellpadding="5" cellspacing="5">
  <tbody>
    <tr>
      <td width="33%" valign="top"><div id="search_results"></div></td>
      <td width="34%" align="center" valign="middle"><div id="pagination_controls"></div></td>
      <td align="center"><label for="numPerPage"># / page</label>
      	<select class="form-control" name="numPerPage" id="numPerPage" onchange="onSelectChange()">
          <option value="12" <?php if ($numPrPage == "12") { echo "selected";} ?>>12</option>
          <option value="24" <?php if ($numPrPage == "24") { echo "selected";} ?>>24</option>
          <option value="36" <?php if ($numPrPage == "36") { echo "selected";} ?>>36</option>
          <option value="48" <?php if ($numPrPage == "48") { echo "selected";} ?>>48</option>
          <option value="60" <?php if ($numPrPage == "60") { echo "selected";} ?>>60</option>
        </select>
        <input type="submit" class="btn btn-default" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" formmethod="POST" value="Set">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</form>
<div id="results_box" class="col-md-10"></div>
<div id="pagination_controls2" style="text-align:center"></div>
</div>
</div>

</div>
<script>
function request_page(pn){
var rpp = <?php echo $rpp; ?>; // results per page
var last = <?php echo $last; ?>; // last page number
var total_rows = <?php echo $total_rows; ?>;
var text_search = "<?php echo $searchquery; ?>";
	var results_box = document.getElementById("results_box");
	var pagination_controls = document.getElementById("pagination_controls");
	results_box.innerHTML = "loading results ...";
	var hr = new XMLHttpRequest();
    hr.open("POST", "pagination_parser.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
			var dataArray = hr.responseText.split("||");
			var total_rows = dataArray.length;
			var html_output = "";
		    for(i = 0; i < dataArray.length - 1; i++){
				var itemArray = dataArray[i].split("|");
				/*if(i %3 == 0){
					html_output += "</div><div class='row'>";
				}*/
				//var spaceGap = (i < 4 ? "" : " image-tile-gap");
				html_output += "<div class='col-md-4 col-sm-5 col-xs-7'><div class='row'><div class='col-md-12 foundProduct'><a href='product.php?pid="+ itemArray[0] +"'><img src='"+ itemArray[2] +"' class='img-responsive'></div></div><div class='row'><div class='col-md-12 text-center'><div class='col-md-offset-1 col-md-10 productNameWrapper'><p class='productName'>"+ itemArray[1] +"</a></p></div></div></div></div>";
			}
			results_box.innerHTML = html_output;
	    }
    }
    hr.send("rpp="+rpp+"&last="+last+"&pn="+pn+"&q=<?php echo $searchquery; ?>&ages=<?php echo $test2; ?>&genders=<?php echo $gen; ?>&cat=<?php echo $cat; ?>");
	// Change the pagination controls
	var paginationCtrls = "";
	var searchResults = "";
	searchResults += total_rows+' Results for \"'+ text_search +'\" <?php if($inCategories != "") { echo "in category \"".$inCategories."\""; }?><br>';
    // Only if there is more than 1 page worth of results give the user pagination controls
    if(last != 1){
		if (pn > 1) {
			paginationCtrls += '<button class="btn btn-default" onclick="request_page('+(pn-1)+')">&lt;</button>';
    	}
		paginationCtrls += ' &nbsp; &nbsp; <b>Page '+pn+' of '+last+'</b> &nbsp; &nbsp; ';
    	if (pn != last) {
        	paginationCtrls += '<button class="btn btn-default" onclick="request_page('+(pn+1)+')">&gt;</button>';
		}
    }
	pagination_controls.innerHTML = paginationCtrls;
	pagination_controls2.innerHTML = paginationCtrls;
	search_results.innerHTML = searchResults;
}
</script>
<script> request_page(1); </script>
<?php include_once("footer.php"); ?>