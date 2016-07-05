<?php
include_once "header.php";
$title = "Gift Goals";
$productQuery = "SELECT productID, productName, imageURL FROM products LIMIT 9";
$productResult = mysqli_query($conn, $productQuery);

$ageQuery = "SELECT * FROM ages";
$ageQueryResult = mysqli_query($conn, $ageQuery);

$genderQuery = "SELECT * FROM genders";
$genderQueryResult = mysqli_query($conn, $genderQuery);

$categoriesQuery = "SELECT * FROM categories order by catName";
$categoriesQueryResult = mysqli_query($conn, $categoriesQuery);
?>
<div class"row">
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="col-md-2" id="searchLimiters">
		<p>Search limiters</p>
		<p>Age</p>
			<?php
				while($age = mysqli_fetch_assoc($ageQueryResult)){
					echo "<label><input type='checkbox' name='ages[]' value='$age[ageID]'> $age[ageText]</label><br>";
				}
			?>
		<p>Gender</p>
			<?php
			while($gender = mysqli_fetch_assoc($genderQueryResult)){
				echo "<label><input type='checkbox' name='genders[]' value='$gender[genderID]'> $gender[genderText]</label><br>";
			}
			?>
		<p>Category</p>
			<?php
			while($category = mysqli_fetch_assoc($categoriesQueryResult)){
				echo "<label><input type='checkbox' name='categories[]' value='$category[catID]'> $category[catName]</label><br>";
			}
			?>
	</div>
	<div class="col-md-10"><hr>

		<div class="row">
<?php
if($productResult){
	$i = 0;
	while($product = mysqli_fetch_array($productResult)){
		if($i++%3 == 0){
			echo "</div><div class=\"row\">";
		}
		$spaceGap = ($i < 4 ? "" : " image-tile-gap");
	print <<<Product

				<div class="col-md-4$spaceGap">

						<div class="row">
							<div class="col-md-12">
								<a href="product.php?pid={$product['productID']}"><img src="{$product['imageURL']}" class="img-responsive center-block thumbnail"></a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<p><a href="product.php?pid={$product['productID']}">{$product['productName']}</a></p>
							</div>
						</div>
					</a>
				</div>
Product;
	}
}
?>
		</div>
	</div>
</div>
<?php include_once("footer.php"); ?>