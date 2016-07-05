<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$title = "Gift Goals - Wishlist";

$uId = isset($_SESSION['userID']) ? $_SESSION['userID'] : "";

if(!isset($_GET['id'])) {
	header("Location: /");
}

include_once "header.php";
require_once 'db_conn.php';
$notice = "";

if(isset($_POST["deleteSelectedWishes"])) {

    if(!isset($_POST["selectedWishes"])) {

        $notice = "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                  Please, select at least one item to delete.</div>";
    }else{
        foreach($_POST["selectedWishes"] as $key => $value){
            $deleteWishlistQuery = "DELETE FROM wishlist WHERE productID={$_POST["selectedWishes"][$key]} AND userID='".$uId."'";
            if($deleteWishlistResult = mysqli_query($conn, $deleteWishlistQuery));
            if($deleteWishlistResult == false){
                die("The system is not available. Please try again later.");
            }
        }
        if($deleteWishlistResult == true) {
            $notice = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                  Selected wishes have been deleted.</div>";
        }
    }
}

if(isset($_POST["updateSelectedWishes"])) {
    if(!isset($_POST["selectedWishes"])) {
        $notice = "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                  Please, select at least one item to update.</div>";
    }else{
        foreach($_POST["selectedWishes"] as $key=>$value) {
            $updateWishlistQuery = "UPDATE wishlist SET notes='{$_POST["notes"][$key]}'
                                    WHERE productID={$_POST["selectedWishes"][$key]} AND userID='".$uId."'";
            $updateWishlistResult = mysqli_query($conn, $updateWishlistQuery);
            if($updateWishlistResult == false){
                die("The system is not available. Please try again later.");
                break;
            }
        }
        if($updateWishlistResult == true) {
            $notice = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                  Selected wishes have been updated.</div>";
        }
    }
}

$wishlistQuery = "SELECT wishlist.notes, wishlist.productID, products.productName, products.imageURL
                  FROM wishlist INNER JOIN products
                  ON wishlist.productID = products.productID AND wishlist.userID='".$_GET['id']."'";
$wishlistResult = mysqli_query($conn, $wishlistQuery);

$usernameQuery = "SELECT userName
                  FROM users
                  WHERE userID='".$_GET['id']."'";
$usernameResult = mysqli_query($conn, $usernameQuery);

if(mysqli_num_rows($usernameResult) == 0){
    header("Location: /");
} else {
    $usernameResult = mysqli_fetch_array($usernameResult);
}
?>

<div class="container">
    <h2 class="text-center"><?php echo $usernameResult["userName"]; ?>'s Wishlist</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $uId; ?>" method="post">

        <?php
        if(mysqli_num_rows($wishlistResult) == 0){
            if($_GET['id'] == $uId){
                echo "<p class='text-center'>You haven't added any products to your wishlist yet.</p>";
            } else {
                echo "<p class='text-center'>This user hasn't added any products to  wishlist yet.</p>";
            }
        } else {
            if($uId == $_GET['id']){
                print <<<WishButtons
                    <div id="wishlistButtons">
                        <button type="submit" name="updateSelectedWishes" class="btn btn-primary">Update Items</button>
                        <button type="submit" name="deleteSelectedWishes" class="btn btn-warning ">Delete Items</button>
                    </div>
WishButtons;
            }
            echo "<div class=\"col-sm-8 col-sm-offset-2\">";
            echo $notice;

            while($wishlist = mysqli_fetch_assoc($wishlistResult)) {
                $productImage = ($wishlist["imageURL"] != "") ? $wishlist["imageURL"] :  "http://placehold.it/300x200";
                $chooseWish = $uId != $_GET['id'] ? "" : "<input type=\"checkbox\" name=\"selectedWishes[{$wishlist["productID"]}]\"/*name=\"checked[{$User['userID']}]\" value=\"{$wishlist["productID"]}\"*/>";
                $userNote = $uId != $_GET['id'] ?
                    "<p name=\"notes[]\" rows=\"2\">{$wishlist["notes"]}</p>"
                    : "<textarea class=\"form-control\" name=\"notes[{$wishlist["productID"]}] rows=\"2\">{$wishlist["notes"]}</textarea>";

                print <<<Wishlist
                    <ul class="list-group">
                      <li class="list-group-item">
                          <div class="row">
                              <div class="col-sm-3">
                                $chooseWish
                                <p class="text-center"><a href="product.php?pid={$wishlist["productID"]}"><img id="wishImage" src="$productImage"></a></p>
                              </div>
                              <div class="col-sm-8">
                                <p class="lead"><a href="product.php?pid={$wishlist["productID"]}">{$wishlist["productName"]}</a></p>
                                $userNote
                              </div>
                          </div>
                      </li>
                    </ul>
Wishlist;
            }
        }
        ?>
        </div>
    </form>
</div>
<?php include_once "footer.php"; ?>