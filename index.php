<?php
require "header.php";
$title = "Gift Goals";
$productQuery = "SELECT productID, productName, imageURL FROM products order by Rand() LIMIT 12 ";
$productResult = mysqli_query($conn, $productQuery);
?>
<div class"row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<hr>
			</div>
		</div>
		<div class="row">
<?php
if($productResult){
	$i = 0;
	while($product = mysqli_fetch_array($productResult)){

	print <<<Product

				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
						<div class="row">
							<div class="col-md-12">
								<a href="product.php?pid={$product['productID']}"><img src="{$product['imageURL']}" class="img-responsive"></a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-offset-2 col-md-8 productNameWrapper">
								<p class="productName"><a href="product.php?pid={$product['productID']}">{$product['productName']}</a></p>
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
<script>
	$("#scores").load("header.php .navbar-right");
</script>
