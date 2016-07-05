<style type="text/css">
#linkbtn {
	width: 100px;
	white-space: normal;
}
.pid {
	display:none;
}
.main {
    background: #aaa url(../images/bg.jpg) no-repeat;
    width: 800px;
    height: 600px;
    margin: 50px auto;
}
.panel {
    background-color: #444;
    height: 34px;
    padding: 10px;
}
.panel a#login_pop, .panel a#store_pop {
    border: 2px solid #aaa;
    color: #fff;
    display: block;
    float: right;
    margin-right: 10px;
    padding: 5px 10px;
    text-decoration: none;
    text-shadow: 1px 1px #000;

    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    -ms-border-radius: 10px;
    -o-border-radius: 10px;
    border-radius: 10px;
}
a#login_pop:hover, a#join_pop:hover {
    border-color: #eee;
}
.overlay {
    background-color: rgba(0, 0, 0, 0.6);
    bottom: 0;
    cursor: default;
    left: 0;
    opacity: 0;
    position: fixed;
    right: 0;
    top: 0;
    visibility: hidden;
    z-index: 1;

    -webkit-transition: opacity .5s;
    -moz-transition: opacity .5s;
    -ms-transition: opacity .5s;
    -o-transition: opacity .5s;
    transition: opacity .5s;
}
.overlay:target {
    visibility: visible;
    opacity: 1;
}
.popup {
    background-color: #fff;
    border: 3px solid #fff;
    display: inline-block;
    left: 50%;
    opacity: 0;
    padding: 15px;
    position: fixed;
    text-align: justify;
    top: 40%;
    visibility: hidden;
    z-index: 10;

    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);

    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    -ms-border-radius: 10px;
    -o-border-radius: 10px;
    border-radius: 10px;

    -webkit-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
    -moz-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
    -ms-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
    -o-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
    box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;

    -webkit-transition: opacity .5s, top .5s;
    -moz-transition: opacity .5s, top .5s;
    -ms-transition: opacity .5s, top .5s;
    -o-transition: opacity .5s, top .5s;
    transition: opacity .5s, top .5s;
}
.overlay:target+.popup {
    top: 50%;
    opacity: 1;
    visibility: visible;
}
.close {
    background-color: rgba(0, 0, 0, 0.9);
    height: 30px;
    line-height: 30px;
    position: absolute;
    right: 0;
    text-align: center;
    text-decoration: none;
    top: -15px;
    width: 30px;

    -webkit-border-radius: 15px;
    -moz-border-radius: 15px;
    -ms-border-radius: 15px;
    -o-border-radius: 15px;
    border-radius: 15px;
}
.close:before {
    color: rgba(255, 255, 255, 0.9);
    content: "X";
    font-size: 24px;
    text-shadow: 0 -1px rgba(0, 0, 0, 0.9);
}
.close:hover {
    background-color: rgba(64, 128, 128, 1);
}
.popup p, .popup div {
    margin-bottom: 10px;
}
.popup label {
    display: inline-block;
    text-align: left;
    width: 120px;
}
.popup input[type="text"], .popup input[type="password"] {
    border: 1px solid;
    border-color: #999 #ccc #ccc;
    margin: 0;
    padding: 2px;

    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -ms-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 2px;
}
.popup input[type="text"]:hover, .popup input[type="password"]:hover {
    border-color: #555 #888 #888;
}

</style>
<script language="JavaScript">
function setVis(id) {
	var id2 = "btn"+id;
	if(document.getElementById(id2).value=='-'){
	document.getElementById(id2).value = '+';
	document.getElementById(id).style.display = 'none';
	}else{
	document.getElementById(id2).value = '-';
	document.getElementById(id).style.display = 'table-row';
	}
}

</script>
<?php
$title = "Gift Goals - Admin Panel";

include_once("header.php");

if($_REQUEST['action'] == "users") {
	foreach($_REQUEST['checked'] as $key => $value) {
		$conn->query("UPDATE users SET userName='{$_REQUEST['username'][$key]}', email='{$_REQUEST['facebookid'][$key]}', password='{$_REQUEST['password'][$key]}', points={$_REQUEST['points'][$key]}, role={$_REQUEST['role'][$key]} WHERE userID={$key}");
	}
} else if($_REQUEST['action'] == "allproducts") {
	foreach($_REQUEST['checked'] as $key => $value) {
		$conn->query("UPDATE products SET productName='{$_REQUEST['productName'][$key]}', description='" . pre_test_input($_REQUEST['description'][$key]) . "', imageURL='{$_REQUEST['imageURL'][$key]}' WHERE productID={$key}");
	}
} else if($_REQUEST['action'] == "reportedreviews") {
	foreach($_REQUEST['checked'] as $key => $value) {
		$conn->query("DELETE FROM reportreview WHERE ID={$key}");
		
		if($_REQUEST['subaction'] == "Delete") {
			$conn->query("DELETE FROM reviews WHERE reviewID={$_REQUEST['reviewID'][$key]}");
		}
	}
} else if($_REQUEST['action'] == "reportedproducts") {
	foreach($_REQUEST['checked'] as $key => $value) {
		$conn->query("DELETE FROM reportproduct WHERE ID={$key}");
		
		if($_REQUEST['subaction'] == "Delete") {
			$conn->query("DELETE FROM products WHERE productID={$_REQUEST['productID'][$key]}");
		}
	}
} else if($_REQUEST['action'] == "allstores") {
	foreach($_REQUEST['checked'] as $key => $value) {
		$conn->query("UPDATE stores SET storeName='{$_REQUEST['storeName'][$key]}', storeURL='{$_REQUEST['storeURL'][$key]}', thumbnail='{$_REQUEST['thumbnail'][$key]}' WHERE storeID={$key}");
	}
} else if($_REQUEST['action'] == "categories") {
	foreach($_REQUEST['checked'] as $key => $value) {
		$conn->query("UPDATE categories SET catName='{$_REQUEST['catName'][$key]}' WHERE catID={$key}");
	}
} else if($_REQUEST['action'] == "addStore") {
	$name = $_REQUEST['sName'];
	$url = $_REQUEST['sURL'];
	$thumb = $_REQUEST['thumbURL'];
	$conn->query("INSERT INTO stores (storeName, storeURL, thumbnail) VALUES ('$name', '$url', '$thumb')");
} else if($_REQUEST['action'] == "addCat") {
	$name = $_REQUEST['ncatName'];
	$conn->query("INSERT INTO categories (catName) VALUES ('$name')");
}
?>

<div class"row"><br>
	<div class="col-md-12">
		<!-- Nav Tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#users" aria-controls="home" role="tab" data-toggle="tab">Users</a></li>
			<li role="presentation"><a href="#allproducts" aria-controls="profile" role="tab" data-toggle="tab">Products</a></li>
			<li role="presentation"><a href="#reportedreviews" aria-controls="messages" role="tab" data-toggle="tab">Reported Reviews</a></li>
			<li role="presentation"><a href="#reportedproducts" aria-controls="settings" role="tab" data-toggle="tab">Reported Products</a></li>
            <li role="presentation"><a href="#categories" aria-controls="categories" role="tab" data-toggle="tab">Categories</a></li>
            <li role="presentation"><a href="#stores" aria-controls="stores" role="tab" data-toggle="tab">Stores</a></li>
		</ul>
		
		<!-- Tab Panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="users">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr class="bg-primary">
								<th></th>
								<th>Username</th>
								<th>Password</th>
								<th>Facebook ID</th>
								<th>Points</th>
								<th>Role</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$usersQuery = "SELECT * FROM users";
							$Users = $conn->query($usersQuery);
							
							while($User = $Users->fetch_assoc()) {
								$roleSelection = ($User['role'] == 0 ? "" : " selected");
print <<<END
							<tr>
								<td class="bg-primary"><input type="checkbox" class="form-control text-center" name="checked[{$User['userID']}]" style="width: 15px;"></td>
								<td><input type="text" class="form-control" name="username[{$User['userID']}]" value="{$User['userName']}"></td>
								<td><input type="text" class="form-control" name="password[{$User['userID']}]" value="{$User['password']}"></td>
								<td><input type="text" class="form-control" name="facebookid[{$User['userID']}]" value="{$User['email']}"></td>
								<td><input type="text" class="form-control" name="points[{$User['userID']}]" value="{$User['points']}"></td>
								<td>
									<select class="form-control" name="role[{$User['userID']}]">
										<option value="0">User</option>
										<option value="1"$roleSelection>Admin</option>
									</select>
								</td>
							</tr>
END;
							}
						?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-2">
							<input type="hidden" name="action" value="users">
							<input type="submit" class="form-control btn btn-primary">
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="allproducts">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr class="bg-primary">
								<th></th>
								<th>Name</th>
								<th>Description</th>
								<th>Image URL</th>
                                <th>Stores</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$productsQuery = "SELECT * FROM products";
							
							$Products = $conn->query($productsQuery);
							$output = "";
							while($Product = $Products->fetch_assoc()) {
							$storesQuery = "SELECT productID, productURL, thumbnail, storeName, storeURL, stores.storeID FROM storelist join stores on storelist.storeID = stores.storeID WHERE productID = ".$Product['productID']." ORDER BY storeName";	
							$output .= "<tr><td class='bg-primary''>";
							$output .= "<input type='checkbox' class='form-control text-center' name='checked[{$Product['productID']}]' style='width: 15px;'></td>";
							$output .= "<td><input type='text' class='form-control' name='productName[{$Product['productID']}]' value='{$Product['productName']}'></td>";
							$output .= "<td><textarea class='form-control' name='description[{$Product['productID']}]'>{$Product['description']}</textarea></td>";
							$output .= "<td><input type='text' class='form-control' name='imageURL[{$Product['productID']}]' value='{$Product['imageURL']}'></td>";
							$output .= "<td><input type='button' id='btnpid".$Product['productID']."' class=\"form-control btn btn-primary\" width='20px' value='+' onClick=\"setVis('pid".$Product['productID']."')\"></td>";
							$output .= "</tr>";
							$storesLinks = $conn->query($storesQuery);
							if(count($storesLinks) > 0) {
								$output .= "<tr id='pid".$Product['productID']."' class='pid'><td class='bg-primary''></td><td colspan=\"4\"><table width='100%'><thead><tr class='bg-primary'><th>Store</th><th>Product Link</th></tr></thead><tr>";
								while($links = $storesLinks->fetch_assoc()) {
									$output .= "<td><input type='text' class='form-control' name='ptoreName[{$links['storeName']}]' value='{$links['storeName']}' disabled></td><td><input type='text' class='form-control' name='productURL[{$links['productURL']}]' value='{$links['productURL']}' size='100'></td></tr>";
								}
								$output .= "</td></table></tr>";
							}
							}
							echo $output;
							//<td><input type='text' class='form-control' name='thumbnail[{$links['thumbnail']}]' value='{$links['thumbnail']}'></td>
						?>
                        
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-2">
                        
							<input type="hidden" name="action" value="allproducts">
							<input type="submit" class="form-control btn btn-primary">
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="reportedreviews">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr class="bg-primary">
								<th></th>
								<th>Username</th>
								<th>Review Text</th>
								<th>Product</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$reviewsQuery = "SELECT * FROM reportreview reported, reviews review, users user, products product WHERE reported.reportedReviewID = review.reviewID AND review.userID = user.userID AND review.productID = product.productID";
							$Reviews = $conn->query($reviewsQuery);
							
							while($Review = $Reviews->fetch_assoc()) {
print <<<END
							<tr>
								<td class="bg-primary">
									<input type="checkbox" class="form-control text-center" name="checked[{$Review['ID']}]" style="width: 15px;">
									<input type="hidden" name="reviewID[{$Review['ID']}]" value="{$Review['reviewID']}">
								</td>
								<td>{$Review['userName']}</td>
								<td>{$Review['reviewTxt']}</td>
								<td><a href="/product.php?pid={$Review['productID']}">{$Review['productName']}</a></td>
							</tr>
END;
							}
						?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-2">
							<input type="hidden" name="action" value="reportedreviews">
							<input type="submit" class="form-control btn btn-primary" name="subaction" value="Delete">
						</div>
						<div class="col-md-2">
							<input type="submit" class="form-control btn btn-primary" name="subaction" value="Allow">
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="reportedproducts">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr class="bg-primary">
								<th></th>
								<th>Product Name</th>
								<th>Description</th>
								<th>Added By</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$productsQuery = "SELECT * FROM reportproduct reported, users user, products product WHERE reported.productID = product.productID AND product.userID = user.userID";
							$Products = $conn->query($productsQuery);
							
							while($Product = $Products->fetch_assoc()) {
print <<<END
							<tr>
								<td class="bg-primary">
									<input type="checkbox" class="form-control text-center" name="checked[{$Product['ID']}]" style="width: 15px;">
									<input type="hidden" name="productID[{$Product['ID']}]" value="{$Product['productID']}">
								</td>
								<td><a href="/product.php?pid={$Product['productID']}">{$Product['productName']}</a></td>
								<td>{$Product['description']}</td>
								<td>{$Product['userName']}</td>
							</tr>
END;
							}
						?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-2">
							<input type="hidden" name="action" value="reportedproducts">
							<input type="submit" class="form-control btn btn-primary" name="subaction" value="Delete">
						</div>
						<div class="col-md-2">
							<input type="submit" class="form-control btn btn-primary" name="subaction" value="Allow">
						</div>
					</div>
				</form>
			</div>
            <div role="tabpanel" class="tab-pane" id="categories">
            	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr class="bg-primary">
								<th></th>
								<th>Category Name</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$catQuery = "SELECT * FROM categories order by catName ASC";
							$cat = $conn->query($catQuery);
							
							while($c = $cat->fetch_assoc()) {
print <<<END
							<tr>
								<td class="bg-primary">
									<input type="checkbox" class="form-control text-center" name="checked[{$c['catID']}]" style="width: 15px;">
									<input type="hidden" name="catID[{$c['catID']}]" value="{$c['catID']}">
								</td>
								<td><input type="text" class="form-control" name="catName[{$c['catID']}]" value="{$c['catName']}" size="50"></td>
							</tr>
END;
							}
						?>
						</tbody>
					</table>
					<div class="row">
                      <div class="col-md-2">
                          <input type="hidden" name="action" value="categories">
                          <input type="submit" class="form-control btn btn-primary">
                      </div>
                          <div class="col-md-2">
                          <a href="#cat_form" id="cat_pop"><input type="button" value="Add Category" class="form-control btn btn-primary"/></a>
					</div>
					</div>
               </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="stores">
            	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr class="bg-primary">
								<th></th>
								<th>Store Name</th>
								<th>Store URL</th>
								<th>Store Image</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$stQuery = "SELECT * FROM stores order by storeName ASC";
							$st = $conn->query($stQuery);
							
							while($s = $st->fetch_assoc()) {
print <<<END
							<tr>
								<td class="bg-primary">
									<input type="checkbox" class="form-control text-center" name="checked[{$s['storeID']}]" style="width: 15px;">
									<input type="hidden" name="storeID[{$s['storeID']}]" value="{$s['storeID']}">
								</td>
								<td><input type="text" class="form-control" name="storeName[{$s['storeID']}]" value="{$s['storeName']}" size="50"></td>
								<td><input type="text" class="form-control" name="storeURL[{$s['storeID']}]" value="{$s['storeURL']}" size="100"></td>
								<td><input type="text" class="form-control" name="thumbnail[{$s['storeID']}]" value="{$s['thumbnail']}" size="100"></td>
							</tr>
END;
							}
						?>
						</tbody>
					</table>
					<div class="row">
					 <div class="col-md-2">
						<input type="hidden" name="action" value="allstores">
                        <input type="submit" class="form-control btn btn-primary">
					</div>
                    <div class="col-md-2">
                          <a href="#store_form" id="store_pop"><input type="button" value="Add Store" class="form-control btn btn-primary"/></a>
					</div>
					</div>
               </form>
          </div>
		</div>
	</div>
</div>
        <a href="#y" class="overlay" id="cat_form"></a>
        <div class="popup">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="catAdd">
            <h2>Add Category</h2>
            <div>
                <label for="sName">Category Name</label>
                <input type="text" id="ncatName" value="" name="ncatName"/>
            </div>
            <input type="hidden" name="action" value="addCat" >
            <input type="submit" class="form-control btn btn-primary" form="catAdd" value="Add Category" />
        

            <a class="close" href="#close"></a></form>
        </div>
        
        
        <a href="#x" class="overlay" id="store_form"></a>
        <div class="popup">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="storeAdd">
            <h2>Add Store</h2>
            <div>
                <label for="sName">Store Name</label>
                <input type="text" id="sName" value="" name="sName"/>
            </div>
            <div>
                <label for="sURL">Store URL</label>
                <input type="text" id="sURL" value="" name="sURL"/>
            </div>
            <div>
                <label for="thumbURL">Store Image</label>
                <input type="text" id="thumbURL" value="" name="thumbURL"/>
            </div>
            <input type="hidden" name="action" value="addStore" >
            <input type="submit" class="form-control btn btn-primary" form="storeAdd" value="Add Store" />
        

            <a class="close" href="#close"></a></form>
        </div>
<?php include_once("footer.php");?>
