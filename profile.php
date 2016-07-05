<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

if($userID == null){
    header('Location: index.php');
    exit();
}
$title = "Profile Page - Gift Goals";

include_once "header.php";
require_once 'db_conn.php';

$userQuery = "SELECT email, userName, points FROM users WHERE userID='$userID'";
$result = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($result);

$wishlistQuery = "SELECT * FROM products JOIN wishlist ON products.productID = wishlist.productID
				  WHERE wishlist.userID = {$_SESSION["userID"]} AND numReports <4 ORDER BY 'wDateAdded' DESC LIMIT 6";
$wishlist = $conn->query($wishlistQuery);

$viewedProductsQuery = "Select * FROM products JOIN reviews ON products.productID = reviews.productID 
						WHERE reviews.userID = {$_SESSION["userID"]} AND reviews.numReports < 4 ORDER BY 'rDateAdded' DESC LIMIT 6";
$viewedProducts = $conn->query($viewedProductsQuery);

// @TODO Change image links to database stored links
$fb_user = isset($_SESSION['fb_user']) ? $_SESSION['fb_user'] : null;
$fbu = $fb_user != null ? json_decode($fb_user) : null;

$img = isset($_SESSION['fb_user']) ?
    "<img src=\"//graph.facebook.com/$fbu->id/picture?height=300&width=300\" class=\"img-responsive img-thumbnail\" />"
    : "<img src=\"/img/user.png\" class=\"img-responsive img-thumbnail\" />";

print <<<Mark

    <div class="row">
        <div class="col-sm-12">
            <h2>$user[userName]</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            $img
        </div>
        <div class="col-sm-8">
            <table class="table table-responsive table-hover">
                <tr>
                    <td>Birth year</td>
                    <td></td>
                </tr>
Mark;
			if(!$fb_user) {
print <<<Mark
                <tr>
                    <td>Email</td>
                    <td>$user[email]</td>
                </tr>
Mark;
			}
print <<<Mark
                <tr>
                    <td>Gender</td>
                    <td></td>
                </tr>
				<tr>
					<td>Points</td>
					<td>$user[points]</td>
				</tr>
            </table>
			<h2 class="h3">Recent wishlist products</h2>
			<div class="row">
Mark;
			if($wishlist->num_rows > 0) {
				while($row = $wishlist->fetch_assoc()) {
print <<<Mark
				<div class="col-md-2">
					<a href="/product.php?pid={$row["productID"]}"><img src="{$row["imageURL"]}" class="center-block img-responsive img-thumbnail"></a>
				</div>
Mark;
				}
			} else {
print <<<Mark
				<div class="col-md-12">
					<p>You have no wishlist items</p>
				</div>
Mark;
			}
print <<<Mark
			</div>
			<h2 class="h3">Recently reviewed products</h2>
			<div class="row">
Mark;
			if($viewedProducts->num_rows > 0) {
				while($row = $viewedProducts->fetch_assoc()) {
print <<<Mark
				<div class="col-md-2">
					<a href="/product.php?pid={$row["productID"]}"><img src="{$row["imageURL"]}" class="center-block img-responsive img-thumbnail"></a>
				</div>
Mark;
				}
			} else {
print <<<Mark
				<div class="col-md-12">
					<p>You have not reviewed any products</p>
				</div>
Mark;
			}
print <<<Mark
			</div>
        </div>
    </div>

Mark;

include_once "footer.php";
?>