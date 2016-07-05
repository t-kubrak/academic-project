<style type="text/css">
#linkbtn {
	width: 100px;
	white-space: normal;
}
#aStore {
	display:none;
	}
</style>
<script language="JavaScript">
function setVis(id) {
	if(document.getElementById('linkbtn').value=='Hide Add link to new store'){
	document.getElementById('linkbtn').value = 'Show Add link to new store';
	document.getElementById(id).style.display = 'none';
	}else{
	document.getElementById('linkbtn').value = 'Hide Add link to new store';
	document.getElementById(id).style.display = 'inline';
	}
}

</script>
<?php
if (!isset($_GET['pid'])){
	header('Location: /');
	exit();
}

$title = "Gift Goals - Product";

include_once "header.php";
include_once "Functions.php";

$userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$_SESSION["pid"] = $_GET['pid'];
$pid = $_GET['pid'];
$productQuery = "SELECT productName, description, imageURL FROM products WHERE productID=?";

$preparedProductSelect = mysqli_prepare($conn, $productQuery);
mysqli_stmt_bind_param($preparedProductSelect, 'i', $pid);
mysqli_stmt_execute($preparedProductSelect);
mysqli_stmt_store_result($preparedProductSelect);

if(mysqli_stmt_num_rows($preparedProductSelect)<1){
	header('Location: /');
	exit();
}

mysqli_stmt_bind_result($preparedProductSelect, $productName, $productDescription, $productImage);
mysqli_stmt_fetch($preparedProductSelect);
mysqli_stmt_close($preparedProductSelect);

if($userId == null){
	$reviewQuery = "SELECT reviews.reviewID, reviews.reviewTxt, reviews.reviewRating, reviews.ownProd, users.userName, users.points, users.image FROM reviews
				INNER JOIN users ON reviews.userID = users.userID AND reviews.productID={$_GET['pid']}";
	$reviewResult = mysqli_query($conn, $reviewQuery);
	$reviewsNumber = mysqli_num_rows($reviewResult);
} else {
	$reviewQuery = "SELECT productReviews.reviewTxt, productReviews.reviewID, productReviews.reviewRating, productReviews.ownProd,
	productReviews.userName, productReviews.points, productReviews.image, reviewRate.userID, reviewRate.helpful
	FROM (SELECT reviews.reviewTxt, reviews.reviewID, reviews.reviewRating, reviews.ownProd,
	users.userName, users.points, users.image FROM users
	INNER JOIN reviews ON users.userID=reviews.userID
	AND reviews.productID={$_GET['pid']}) AS productReviews LEFT JOIN
	(SELECT * FROM reviewrating WHERE reviewrating.userID=$userId)
	AS reviewRate ON productReviews.reviewID=reviewRate.reviewID";

	$reviewResult = mysqli_query($conn, $reviewQuery);
	$reviewsNumber = mysqli_num_rows($reviewResult);

	$reportedReviewQuery  = "SELECT reportedReviewID FROM reportreview WHERE reportinguserID={$_SESSION['userID']}";
	$reportedReviewResult = mysqli_query($conn, $reportedReviewQuery);
	$numberOfReportedReviews = 0;
	if($reportedReviewResult){
		$numberOfReportedReviews = mysqli_num_rows($reportedReviewResult);
		if($numberOfReportedReviews > 0){
			while($reportedReview = mysqli_fetch_array($reportedReviewResult)){
				$reportedReviews[] = $reportedReview['reportedReviewID'];
			}
		}
	}
}

$productImage = ($productImage != "") ? $productImage :  "/img/gift.png";

$ages = "";
$agesQuery = "SELECT ages.ageText FROM ages INNER JOIN agelist INNER JOIN products ON ages.ageID=agelist.ageID AND agelist.productID = products.productID AND agelist.productID=$pid";
$agesResult = mysqli_query($conn, $agesQuery);

if (mysqli_num_rows($agesResult) > 0) {
	while($age = mysqli_fetch_assoc($agesResult)) {
		$ages .= "{$age['ageText']}, ";
	}
	$ages = rtrim($ages, ", ");
}

$genders = "";
$gendersQuery = "SELECT genders.genderText FROM genders INNER JOIN genderlist INNER JOIN products ON genders.genderID = genderlist.genderID AND genderlist.productID=products.productID AND products.productID=$pid";
$gendersResult = mysqli_query($conn, $gendersQuery);

if (mysqli_num_rows($gendersResult) > 0) {
	while($gender = mysqli_fetch_assoc($gendersResult)) {
		$genders .= "{$gender['genderText']}, ";
	}
	$genders = rtrim($genders, ", ");
}

$categories = "";
$categoriesQuery = "SELECT categories.catName FROM categories INNER JOIN categorylist INNER JOIN products ON categories.catID=categorylist.categoryID AND categorylist.productID = products.productID AND products.productID=$pid";
$categoriesResult = mysqli_query($conn, $categoriesQuery);

if (mysqli_num_rows($categoriesResult) > 0) {
	while($category = mysqli_fetch_assoc($categoriesResult)) {
		$categories .= "{$category['catName']}, ";
	}
	$categories = rtrim($categories, ", ");
}

$storesWithProduct = "";
$myquery = "select storelist.productURL, stores.storeName, stores.storeURL, stores.thumbnail from storelist join stores on storelist.storeID = stores.storeID where productID=$pid order by rand()";
$stores = $conn->query($myquery);

if ($stores->num_rows > 0) {
	$i = 0;
	$storesWithProduct .= "<table width='100%'><tbody><tr><td><table cellspacing='3' cellpadding='3'>";
	$storesWithProduct .= "<tr>";
    while($row = $stores->fetch_assoc())
	{
		$storesWithProduct .= "<td width='60px' height='50px'><a href='$row[productURL]' target='_blank'><img src='$row[thumbnail]' alt='$row[storeName]' title='$row[storeName]' width='50'/></a></td>";
		$i++;		
		if ($i % 4 == 0)
		{
			$storesWithProduct .= "</tr><tr>";
		}		
    }
	$storesWithProduct .= "<tr></table></td><td align='center'>";
	if(isset($_SESSION['userID'])){
		$storesWithProduct .= "<input type='button' class=\"btn btn-primary\" title='New' value='Show Add link to new store' width='50' id='linkbtn' onClick=\"setVis('aStore')\">";
	}
	$storesWithProduct .= "</td></tr></tbody></table>";
	
}

	$storelist = "";
	$newstorequery = "SELECT stores.storeName, stores.storeID FROM stores where not EXISTS (select storelist.storeID from storelist where stores.storeID = storelist.storeID and storelist.productID = $pid) order by storeName";
		$newstores = $conn->query($newstorequery);
		if ($newstores->num_rows > 0) {
			while($row = $newstores->fetch_assoc())
			{
				$storelist .= "<option value='$row[storeID]'>$row[storeName]</option>";
			}
		}
	$productDescription = stripcslashes($productDescription);
	$productDescription = htmlspecialchars_decode($productDescription, ENT_QUOTES);	
print <<<Product
    <h2 class="text-center">$productName</h2>
        <div class="row" id="productDetails">
            <div class="col-sm-5 col-sm-offset-1">
                <table class="table table-hover">
                    <tr>
                        <td>Age range</td>
                        <td width="75%">$ages</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td width="75%">$genders</td>
                    </tr>
                    <tr>
                        <td>Categories</td>
                        <td width="75%">$categories</td>
                    </tr>
                     <tr>
                        <td>Where to buy</td>
                        <td width="75%">$storesWithProduct</td>
                    </tr>
                </table>
				<div id="aStore">
					<form action="giftgoals_psAdd.php" method="post" id="form1">
					<label for="add">Store:</label>
					<select id="add" name="add">
					<option value="0">Select a store</option>
					$storelist
					<input name="pid" type="hidden" id="pid" value="$pid">
					<br>
					<label for="prodURL">url to product at selected store: <span class="required">*</span></label>
					<input name="prodURL" type="text" required="required" id="prodURL" placeholder="http://" value="" size="50" />
					<br><input type="submit" value="Add This Link For Store" id="submit" class="btn btn-primary" />
					</form>
				</div>
				<p class="description">$productDescription</p>
            </div>
            <div class="col-sm-4 col-sm-offset-2">
				<div><img id="productImage" src="$productImage" alt="Product image"></div>
Product;

if(isset($_SESSION['userID'])){
	$selectWishQuery = "SELECT * FROM wishlist WHERE userID={$_SESSION['userID']} AND productID={$pid}";
	$wishResult = mysqli_query($conn, $selectWishQuery);
	if(mysqli_num_rows($wishResult)>0){
		echo "<span class=\"glyphicon glyphicon-bookmark\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"This product is in your wishlist\"></span>";
	}else{
		echo "<form action=\"action.php?do=addToWishlist\" method=\"post\">
				<button id=\"addWish\" class=\"btn btn-primary\" name=\"addToWishlist\" type=\"submit\">Add to my Wishlist</button>
		      </form>";
	}

	$added = isset($_GET['added']) ? $_GET['added'] : null;
	if($added === "true"){
		echo "<div class=\"alert alert-success alert-dismissible\" id='addWishResult' role=\"alert\">
		  		<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		  			Product has been added to <a href=\"wishlist.php?id={$_SESSION['userID']}\" class=\"alert-link\">wishlist</a>
			  </div>";
	}
}

echo "<span class=\"glyphicon glyphicon-flag\" id='reportProduct' data-productId=\"{$pid}\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Mark product as inappropriate\"></span>";
?>
	</div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-1">

		</div>
		<div class="col-sm-4 col-sm-offset-1">
            </div>
        </div>

	<div class="row" id="reviewTabs">
		<ul class="nav nav-tabs col-sm-10 col-sm-offset-1" role="tablist">
			<li role="presentation" class="active"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
			<li role="presentation"><a href="#addReview" aria-controls="addReview" role="tab" data-toggle="tab">Add Review</a></li>
		</ul>
	</div>
	<div class="row">
		<div class="tab-content ">
			<div role="tabpanel" class="tab-pane fade in active" id="reviews">

				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<!--<div class="col-sm-3 col-sm-offset-4">-->
									<?php
										if($reviewsNumber != 0) {
											$totalRating = 0;
											$averageRating = 0;
											while ($review = mysqli_fetch_assoc($reviewResult)) {
												$totalRating += $review["reviewRating"];
												$userReviews[] = $review;
											}
											$averageRating  = $totalRating/$reviewsNumber;

											$giftRating = "";
											for ($i=1; $i<=$averageRating; $i++){
												$giftRating.="<span class=\"glyphicon glyphicon-gift \"></span>&nbsp;&nbsp;";
											}
											echo "<p class=\"text-center\" id=\"averageRating\">Average Rating: $giftRating </p>";
										}
									?>

									<!--</div>-->
									<!--<div class="col-sm-3 col-sm-offset-2">
										<p>Average Price Rating: </p>
									</div>-->
								</div>
							</div>
							<div class="panel-body">
								<?php
									if($reviewsNumber == 0){
										echo "This product hasn't been reviewed yet. Be first to review this product!";
									}else{
										foreach($userReviews as $review) {
											$ownWant = ($review["ownProd"] == 1) ? "<span class=\"glyphicon glyphicon-certificate\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Owner\"></span>"
																					: "<span class=\"glyphicon glyphicon-heart\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Wants this product\"></span>";
											$liked = "";
											$liked = "<span class=\"glyphicon glyphicon-thumbs-up\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Yes\"></span>".
												"<span class=\"glyphicon glyphicon-thumbs-down\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"No\"></span>";

											$report = "";
											$report = "<span class=\"glyphicon glyphicon-flag pull-right\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Mark as inappropriate\"></span>";
											
											$reviewTxt = stripcslashes($review["reviewTxt"]);

											if($userId == null){
														print <<<Reviews
														<div class="well">
															<div class="container-fluid">
																<div class="row">
																	<div class="col-sm-3">
																	<div class="userCommentImage"><img src="{$review["image"]}"></div>
																	<span>{$review["userName"]}</span>
																	<span class="userPoints" data-reviewId="{$review["reviewID"]}">({$review["points"]})</span>
																	<p id="helpful">Is review helpful?
																		$liked
																	</p>
																</div>
																<div class="col-sm-9">
																	$report
																	<p class="userReviewRating">{$review["reviewRating"]}/5 $ownWant</p>
																	<p class="description">$reviewTxt</p>
																</div>
																</div>
															</div>
														</div>
Reviews;
											} else {
												$liked = "<span class=\"glyphicon glyphicon-thumbs-up\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Yes\"></span>".
													"<span class=\"glyphicon glyphicon-thumbs-down\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"No\"></span>";
												if($review["userID"] == $_SESSION['userID']){
													if($review["helpful"] == '1'){
														$liked = "<span class=\"glyphicon glyphicon-thumbs-up clicked\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Yes\"></span>"
															."<span class=\"glyphicon glyphicon-thumbs-down\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"No\"></span>";
													} else if ($review["helpful"] == '0') {
														$liked = "<span class=\"glyphicon glyphicon-thumbs-up\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Yes\"></span>".
															"<span class=\"glyphicon glyphicon-thumbs-down clicked\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"No\"></span>";
													} else {
														$liked = "<span class=\"glyphicon glyphicon-thumbs-up\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Yes\"></span>".
															"<span class=\"glyphicon glyphicon-thumbs-down\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"No\"></span>";
													}
												}

												$report = "";
												$report = "<span class=\"glyphicon glyphicon-flag pull-right\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Mark as inappropriate\"></span>";
												if($numberOfReportedReviews>0){
													foreach($reportedReviews as $myReportedReview){
														if($myReportedReview == $review["reviewID"]) {
															$report = "<span class=\"glyphicon glyphicon-flag pull-right clicked\" data-reviewId=\"{$review['reviewID']}\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Mark as inappropriate\"></span>";
															break;
														}
													}
												}

												print <<<Reviews
													<div class="well">
														<div class="container-fluid">
															<div class="row">
																<div class="col-sm-3">
																	<div class="userCommentImage"><img src="{$review["image"]}"></div>
																	<span>{$review["userName"]}</span>
																	<span class="userPoints" data-reviewId="{$review["reviewID"]}">({$review["points"]})</span>
																	<p id="helpful">Is review helpful?
																		$liked
																	</p>
																</div>
																<div class="col-sm-9">
																	$report
																	<p class="userReviewRating">{$review["reviewRating"]}/5 $ownWant</p>
																	<p class="description">$reviewTxt</p>
																</div>
															</div>
														</div>
													</div>
Reviews;
											}


										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="addReview">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="well">
						<div class="row">
							<div class="col-sm-2">
								<?php
								$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
								if($userID != null){
									$userImageQuery = "SELECT * FROM users WHERE userID='{$_SESSION['userID']}'";
									$userImageResult = mysqli_query($conn, $userImageQuery);

									while($imageResult = mysqli_fetch_assoc($userImageResult)){
										echo "<div><div class=\"userCommentImage\"><img src=\"{$imageResult['image']}\"></div>
												<p>{$_SESSION['userName']}</p></div>";
									}
								}
								$conn->close();
								?>
							</div>
							<div class="col-sm-7">
								<form action="action.php?do=addReview" method="post">
									<div class="form-group">
										<p>Are you an owner of this product?</p>
										<label class="radio-inline">
											<input type="radio" name="ownWant" class="radio_item" id="inlineRadio1" value="1" checked="checked">
											 <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>I own it</label>
										<label class="radio-inline">
											<input type="radio" name="ownWant" class="radio_item" id="inlineRadio2" value="0">
											<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>I want it</label>
									</div>

									<div class="form-group">
										<p>Please, rate this product</p>
										<label class="radio-inline gifts">
											<input type="radio" name="rating" class="radio_item gift" id="inlineRadio1" value="1">
											<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
										</label>
										<label class="radio-inline gifts">
											<input type="radio" name="rating" class="radio_item gift" id="inlineRadio2" value="2">
											<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
										</label>
										<label class="radio-inline gifts">
											<input type="radio" name="rating" class="radio_item gift" id="inlineRadio3" value="3">
											<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
										</label>
										<label class="radio-inline gifts">
											<input type="radio" name="rating" class="radio_item gift" id="inlineRadio4" value="4" checked="checked">
											<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
										</label>
										<label class="radio-inline gifts">
											<input type="radio" name="rating" class="radio_item gift" id="inlineRadio5" value="5">
											<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
										</label>
									</div>

									<div class="form-group">
										<textarea name="userReview" class="form-control" rows="5" required placeholder="Review"></textarea>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-6">
											<?php
												if($userID != null){
													echo "<button type=\"submit\" name=\"submitReview\" class=\"btn btn-default\">Add Review</button>";
												} else {
													echo "<p>Please login to review this product</p>";
												}
											?>

										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();

		function like(reviewId, handleData) {
			$.ajax({
				url:"action.php?do=like",
				method: "POST",
				data: { rId : reviewId },
				dataType: "text"	,
				success:function(data) {
					handleData(data);
				}
			});
		}

		function disLike(reviewId, handleData) {
			$.ajax({
				url:"action.php?do=dislike",
				method: "POST",
				data: { rId : reviewId },
				dataType: "text"	,
				success:function(data) {
					handleData(data);
				}
			});
		}

		$('.glyphicon-thumbs-up').click(function(){
			var reviewId = $(this).data("reviewid");
			like(reviewId, function(output){
				if(output == "login"){
					alert("Please login to like this review");
				} else {
					$(".glyphicon-thumbs-up[data-reviewid='" + reviewId + "']").toggleClass("clicked");
					if($(".glyphicon-thumbs-down[data-reviewid='" + reviewId + "']").hasClass("clicked")){
						$(".glyphicon-thumbs-down[data-reviewid='" + reviewId + "']").toggleClass("clicked");
					}
					var reviewAndUserId = output.split(",");
					$(".userPoints[data-reviewid='" + reviewAndUserId[0] + "']").text("(" + reviewAndUserId[1] + ")");
				}
			});
		});

		$('.glyphicon-thumbs-down').click(function(){
			var reviewId = $(this).data("reviewid");
			disLike(reviewId, function(output){
				if(output == "login"){
					alert("Please login to dislike this review");
				} else {
					$(".glyphicon-thumbs-down[data-reviewid='" + reviewId + "']").toggleClass("clicked");
					if($(".glyphicon-thumbs-up[data-reviewid='" + reviewId + "']").hasClass("clicked")){
						$(".glyphicon-thumbs-up[data-reviewid='" + reviewId + "']").toggleClass("clicked");
					}
					var reviewAndUserId = output.split(",");
					$(".userPoints[data-reviewid='" + reviewAndUserId[0] + "']").text("(" + reviewAndUserId[1] + ")");
				}
			});
		});

		$('.glyphicon-flag').click(function(){
			var thisFlag = $(this);
			var reviewId = $(this).data("reviewid");
			var productId = $(this).data("productid");
			
			if(thisFlag.attr("id") == "reportProduct") {
				if($(".glyphicon-flag[data-productid='" + productId + "']").hasClass("clicked") == false) {
					var isMarked = confirm("Are you sure you want to mark this product as inappropriate?");
					if(isMarked) {
						$.post( "action.php?do=reportProduct&productID=" + productId, function(data) {
							if(data == "login"){
								alert("Please login to report this product");
								return;
							}
							thisFlag.toggleClass("clicked");
						});
					}
				} else {
					$.post( "action.php?do=reportProduct&productID=" + productId, function() {
						thisFlag.toggleClass("clicked");
					});
				}
			} else {
				if($(".glyphicon-flag[data-reviewid='" + reviewId + "']").hasClass("clicked") == false) {
					var isMarked = confirm("Are you sure you want to mark this review as inappropriate?");
					if(isMarked) {
						$.post( "action.php?do=reportReview&reviewID=" + reviewId, function(data) {
							if(data == "login"){
								alert("Please login to report this review");
								return;
							}
							thisFlag.toggleClass("clicked");
						});
					}
				} else {
					$.post( "action.php?do=reportReview&reviewID=" + reviewId, function() {
						thisFlag.toggleClass("clicked");
					});
				}
			}
		});

		function evaluateReview(){
			var giftsRadio = $(".gift");
			var giftsSpan = $(".radio-inline > .glyphicon-gift");

			for(var i = 0; i<giftsRadio.length; i++){
				giftsSpan[i].style.opacity = "1";
				if (giftsRadio[i].checked == true){
					++i;
					for(var j = i; j<giftsRadio.length; j++){
						giftsSpan[j].style.opacity = "0.5";
					}
					break;
				}
			}
		}

		$(".gift").click(function(){
			evaluateReview();
		});

		$(".radio-inline > .glyphicon-gift").hover(function(){
			var giftsRadio = $(".gift");
			var giftsSpan = $(".radio-inline > .glyphicon-gift");
			for(var i = 0; i<giftsRadio.length; i++){
				giftsSpan[i].style.opacity = "0.3";
			}
			$(this).css("opacity", "1");
		}, function(){
			evaluateReview();
		});

		evaluateReview();

		$(".well").hover(function(){
			var review = $(this);
			review.find('.glyphicon-thumbs-up, .glyphicon-thumbs-down, .glyphicon-flag').css("opacity", "1");
		}, function(){
			var review = $(this);
			review.find('.glyphicon-thumbs-up, .glyphicon-thumbs-down, .glyphicon-flag').css("opacity", "0.5");
		})
	})
</script>
<?php include_once "footer.php"; ?>