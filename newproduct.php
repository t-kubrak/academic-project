<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if(!isset($_SESSION['userID'])){
  header('Location: /');
  exit();
}

require_once 'db_conn.php';
require_once "Functions.php";

extract($_POST);

$addProductError = "";
$productName = isset($productName) ? pre_test_input($productName) : null;
$description = isset($description) ? pre_test_input($description) : null;
$filledForm = $productName && $description;
$errorUpload = "";

if(isset($submitProduct)) {
  if(!$filledForm){
    $addProductError = "Please fill all of the product form fields";
  }else {
      // Image upload //
      for ($j = 0; $j < count($_FILES['txtUpload']['tmp_name']); $j++) {
        if ($_FILES['txtUpload']['error'][$j] == 0) {

          define("ORIGINAL_IMAGE_DESTINATION", "./originals");
          define("IMAGE_DESTINATION", "./images");
          define("IMAGE_MAX_WIDTH", 800);
          define("IMAGE_MAX_HEIGHT", 600);
          define("THUMB_DESTINATION", "./thumbnails");
          define("THUMB_MAX_WIDTH", 300);
          define("THUMB_MAX_HEIGHT", 200);

          $productImage = "";
          $fileName = "";
          $ext = "";
          $supportedImageTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
          $destination = './originals';
          if (!file_exists($destination)) {
            mkdir($destination);
          }

          $fileTempPath = $_FILES['txtUpload']['tmp_name'][$j];
          $filePath = $destination."/".$_FILES['txtUpload']['name'][$j];
          $destinationPath = $destination."/".$_FILES['txtUpload']['name'][$j];

          $pathInfo = pathinfo($filePath);
          $dir = $pathInfo['dirname'];
          $fileName = $pathInfo['filename'];
          $ext = $pathInfo['extension'];

          $i="";
          while (file_exists($filePath)) {
            $i++;
            $filePath = $dir."/".$fileName."_".$i.".".$ext;
          }

          move_uploaded_file($fileTempPath, $filePath);
          $imageDetails = getimagesize($filePath);

          if ($imageDetails && in_array($imageDetails[2], $supportedImageTypes)) {
            $imagePath = resamplePicture($filePath, IMAGE_DESTINATION, IMAGE_MAX_WIDTH, IMAGE_MAX_HEIGHT);
            $thumbnailPath = resamplePicture($filePath, THUMB_DESTINATION, THUMB_MAX_WIDTH, THUMB_MAX_HEIGHT);
            $productImage = $imagePath;
            unlink($filePath);
          } else {
                $errorUpload = "Uploaded file is not a supported type";
                //unlink($filePath);
          }
        } elseif ($_FILES['txtUpload']['error'][$j]  == 1) {
              $errorUpload = "$fileName is too large";
              $productImage = "img/gift.png";
        } elseif ($_FILES['txtUpload']['error'][$j]  == 4) {
              $errorUpload = "No upload file specified";
              $productImage = "img/gift.png";
        } else {
              $errorUpload = "Error happened while uploading the file. Try again later.";
              $productImage = "img/gift.png";
        }
      }
      if(isset($destination)){
        rmdir($destination);
      }
  }

    $date = date("Y-m-d");
    $insertProduct = "INSERT INTO products (productName, manufacturer, description, userID, imageURL, pDateAdded) VALUES(?, ?, ?, ?, ?, ?)";
    $preparedProductInsert = mysqli_prepare($conn, $insertProduct);
    mysqli_stmt_bind_param($preparedProductInsert, 'sssiss', $productName, $madeBy, $description, $_SESSION['userID'], $productImage, $date);

    if (!mysqli_stmt_execute($preparedProductInsert)) {
      die("The system is not available, try again later");
    }else {
        $last_id = mysqli_insert_id($conn);
        addPoints($_SESSION['userID'], $conn);
		$storeId = "";
        if($stores > 0) {
			//then must have selected a store that already exists
			$storeId = $stores; //ID from select
		} else {
			//then get the info from new store
			$store = $store2;
			$storeURL = $storeURL;
			$storeImage = $storeIMG;
			if ($storeImage == "") {
				$storeImage = "img/seller.png";
			}
			$insertStore = "INSERT INTO stores (storeName, storeURL, thumbnail) VALUES ('$store', '$storeURL', '$storeImage')";
			mysqli_query($conn, $insertStore);
			$storeId = mysqli_insert_id($conn);
		}
		//$whereToBuy = pre_test_input($whereToBuy);
        //$parsedStoreUrl = parse_url($whereToBuy);
        //$store =  $parsedStoreUrl['host'];
        $insertProductUrl = "INSERT INTO storelist (productID, storeID, productURL) VALUES ($last_id, $storeId, '$whereToBuy')";
        mysqli_query($conn, $insertProductUrl);

        foreach($categories as $catval)
        {
          $insertCat = "INSERT INTO categorylist (categoryID, productID) VALUES('$catval', '$last_id')";
          mysqli_query($conn, $insertCat);
        }

        if(count($ages) > 0)
        {
          foreach($ages as $ageval)
          {
            $insertAges = "INSERT INTO agelist (ageID, productID) VALUES ('$ageval', '$last_id')";
            mysqli_query($conn, $insertAges);
          }
        }

        if(count($genders) > 0)
        {
          foreach($genders as $genderval)
          {
            $insertGenders = "INSERT INTO genderlist (genderID, productID) VALUES ('$genderval', '$last_id')";
            mysqli_query($conn, $insertGenders);
          }
        }

        $conn->close();
        header("Location: product.php?pid=".$last_id);
        exit();
    }
}

$title = "Gift Goals - New Product";
include_once "header.php";
?>
<style type="text/css">
.categories {
	border-right: thick solid #AED0D2;
	border-left: thick solid #AED0D2;
	border-bottom: thick solid #AED0D2;
	
}
.categories th {
	background-color: #1f8bbf;
	color: white;
	border-top:: thick solid #AED0D2;
	font-size: 1.2em;
}
.wtb {
	text-align:center;
}
#nStore {
	text-align:center;
}
#addStore {
	display:none;
}
</style>
<script language="JavaScript">
function setVis(id) {
	//if(document.getElementById('nStore').value=='Hide Add link to new store'){
	//document.getElementById('linkbtn').value = 'Show Add link to new store';
	//document.getElementById(id).style.display = 'none';
	//}else{
	//document.getElementById('linkbtn').value = 'Hide Add link to new store';
	document.getElementById(id).style.display = 'inherit';
	document.getElementById("selStore").style.display = 'none';
	document.getElementById("nsName").setAttribute("required", "");
	document.getElementById("nsURL").setAttribute("required", "");
	document.getElementById("nsIMG").setAttribute("required", "");
	//}
}
</script>
<h2 class="text-center">Add new product</h2>
  <p class="text-center">Please fill in the form to add new product</p>
      <div class="row">
        <form class="form-horizontal" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post" enctype="multipart/form-data">
          <div class="col-sm-5 col-sm-offset-1">
            <div class="form-group">
              <label for="pname" class="col-sm-3 control-label">Product Name</label>
              <div class="col-sm-9">
                <input id="pName" type="text" class="form-control" name="productName" placeholder="Product name" required="required" autofocus />
              </div>
            </div>
            <div class="form-group">
              <label for="madeBy" class="col-sm-3 control-label">Made By</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="madeBy" placeholder="Made by" autofocus />
              </div>
            </div>
            <div class="form-group">
              <label for="description" class="col-sm-3 control-label">Description</label>
              <div class="col-sm-9">
                <textarea name="description" class="form-control"  rows="5" required placeholder="Description."></textarea>
                <p class='text-danger'><?php echo $addProductError ?></p>
              </div>
            </div>
            <div class="wtb"><h3>Where to Buy</h3></div>
            <div class="form-group"  id="selStore">
              <label for="stores" class="col-sm-3 control-label">Store With Product</label>
              <div class="col-sm-9">
                <select name="stores" id="stores" class="form-control">
                <option value="-1">Select a store</option>
                <?php
				$storelist = "";
				$newstorequery = "SELECT stores.storeName, stores.storeID FROM stores order by storeName";
					$newstores = $conn->query($newstorequery);
					if ($newstores->num_rows > 0) {
						while($row = $newstores->fetch_assoc())
						{
							$storelist .= "<option value='$row[storeID]'>$row[storeName]</option>";
						}
						echo $storelist;
					}
				?>
                </select>
                <h4 class="wtb">OR</h4><input name="nStore" type="button" id="nStore" value="I Don't See The Store I Want - Add New Store" class="btn btn-primary" onClick="setVis('addStore')">
              </div>
            </div>
            <div class="form-group"  id="addStore">
              <label for="store2" class="col-sm-3 control-label">Store With Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="store2"  placeholder="Store Name" autofocus id="nsName"/>
                <input type="text" class="form-control" name="storeURL" placeholder="Store URL" autofocus id="nsURL"/>
                <input type="text" class="form-control" name="storeIMG" placeholder="URL to Store Logo" autofocus id="nsIMG"/>
              </div>
            </div>

            <div class="form-group">
              <label for="whereToBuy" class="col-sm-3 control-label">Link to Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="whereToBuy" required="required" placeholder="Where to Buy" autofocus />
              </div>
            </div>            <div class="form-group">
              <div class="col-sm-offset-6 col-sm-6">
                <button type="submit" name="submitProduct" class="btn btn-default">Add Product</button>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <p>Upload picture (accepted picture types: JPEG, GIF, PNG)</p>
              <input type="file" name="txtUpload[]" multiple size="5" accept=".jpg, .gif, .png"/>
            <p class='error'><?php echo  $errorUpload ?></p>
          </div>
          <div class="col-sm-5">
            <table width="500">
              <tr valign="top"><td>
                  <table width='170' class="categories"><tr><th>Categories</th></tr>
                    <?php
                    $catquery = "select * from categories order by catName";

                    $cats = $conn->query($catquery);
                    while($row = $cats->fetch_assoc())
                    {
                      print <<<Mark
      <tr>
        <td><label>
          <input type='checkbox' name='categories[]' value='$row[catID]'>
          $row[catName]</label></td>
      </tr>
Mark;
                    }
                    ?>
                  </table>
                </td><td>
                  <table width='150' class="categories"><tr><th>Ages</th></tr>
                    <?php
                    $agequery = "select * from ages order by ageID";

                    $ages = $conn->query($agequery);
                    while($row = $ages->fetch_assoc())
                    {
                      print <<<Mark
      <tr>
        <td><label>
          <input type='checkbox' name='ages[]' value='$row[ageID]'>
          $row[ageText]</label></td>
      </tr>
Mark;
                    }
                    ?>    </table>
                </td>
                <td>
                  <table width='150' class="categories"><tr><th>Genders</th></tr>
                    <?php
                    $genderquery = "select * from genders order by genderText";

                    $genders = $conn->query($genderquery);
                    while($row = $genders->fetch_assoc())
                    {
                      print <<<Mark
      <tr>
        <td><label>
          <input type='checkbox' name='genders[]' value='$row[genderID]'>
          $row[genderText]</label></td>
      </tr>
Mark;
                    }
                    ?>    </table>
              </tr>
            </table>
          </div>
        </form>
      </div>
<?php include_once "footer.php"; ?>