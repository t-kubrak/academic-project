<?php
require_once 'db_conn.php';
require_once 'Functions.php';

if(!isset($_GET['do'])) {
    exit;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if($_GET['do'] === "logout") {
    session_unset();
    session_destroy();
    header("Location: /");
    exit();
}elseif($_GET['do'] === "login") {
    $inputEmail = $_POST['inputEmail'];
    $inputPassword = $_POST['inputPassword'];
    $salt = '$2a$09$jLSvGh1mFkVIoQXzn5gYs7$';
    $digest = crypt($inputPassword, $salt);

    $userQuery = "SELECT userID, userName FROM users WHERE email=? AND password=?";

    $preparedUserSelect = mysqli_prepare($conn, $userQuery);
    mysqli_stmt_bind_param($preparedUserSelect, 'ss', $inputEmail, $digest);
    mysqli_stmt_execute($preparedUserSelect);
    mysqli_stmt_store_result($preparedUserSelect);

    if(mysqli_stmt_num_rows($preparedUserSelect)!=0){
        mysqli_stmt_bind_result($preparedUserSelect, $userID, $userName);
        mysqli_stmt_fetch($preparedUserSelect);
        mysqli_stmt_close($preparedUserSelect);
        $_SESSION['userID'] = $userID;
        $_SESSION['userName'] = $userName;
        header("Location: index.php");
    } else {
        header("Location: index.php?login=error");
    }
} elseif($_GET['do'] === "addReview") {
    extract($_POST);
    $userReview = isset($userReview) ? pre_test_input($userReview) : null;
    $rating = isset($rating) ? $rating : null;
    $ownWant = isset($ownWant) ? $ownWant : null;
    $date = date("Y-m-d");

    $insertReviewQuery = "INSERT INTO reviews (userID, reviewTxt, reviewRating, productID, rDateAdded, ownProd) VALUES (?,?,?,?,?,?)";
    $preparedInsertReview = mysqli_prepare($conn, $insertReviewQuery);
    mysqli_stmt_bind_param($preparedInsertReview, 'isiisi', $_SESSION['userID'], $userReview, $rating, $_SESSION['pid'], $date, $ownWant);

    if (!mysqli_stmt_execute($preparedInsertReview)) {
        die("The system is not available, try again later");
    }else {
        //$last_id = mysqli_insert_id($conn);
        addPoints($_SESSION['userID'], $conn);
        mysqli_stmt_close($preparedInsertReview);
        $conn->close();
        header("Location: product.php?pid=".$_SESSION["pid"]);
        exit();
    }
} elseif($_GET['do'] === "addToWishlist") {
    $date = date("Y-m-d");
    $notes = "";

    $insertWishQuery = "INSERT INTO wishlist (userID, productID, notes, wDateAdded) VALUES (?,?,?,?)";
    $preparedInsertWish = mysqli_prepare($conn, $insertWishQuery);
    mysqli_stmt_bind_param($preparedInsertWish, 'iiss', $_SESSION['userID'], $_SESSION["pid"], $notes, $date);

    if (!mysqli_stmt_execute($preparedInsertWish)) {
        die("The system is not available, try again later");
    }else {
        mysqli_stmt_close($preparedInsertWish);
        $conn->close();
        header("Location: product.php?pid=".$_SESSION["pid"]."&added=true");
        exit();
    }
} elseif($_REQUEST['do'] === "reportProduct") {
    $date = date("Y-m-d");
    if(!isset($_SESSION['userID'])){
        echo "login";
    } else {
        $reportedProductQuery = "SELECT * FROM reportproduct WHERE productID={$_REQUEST["productID"]} AND userID={$_SESSION['userID']}";
        $reportedProductResult = mysqli_query($conn, $reportedProductQuery);
        if(mysqli_num_rows($reportedProductResult) == 0) {
            $insertProductQuery = "INSERT INTO reportproduct (productID, userID, pReportDate) VALUES (?,?,?)";
            $preparedInsertProduct = mysqli_prepare($conn, $insertProductQuery);
            mysqli_stmt_bind_param($preparedInsertProduct, 'iis', $_REQUEST["productID"], $_SESSION['userID'], $date);

            if (!mysqli_stmt_execute($preparedInsertProduct)) {
                die("The system is not available, try again later");
            } else {
                mysqli_stmt_close($preparedInsertProduct);
                $conn->close();
                echo "User ID: " . $_SESSION['userID'] . "\Product ID: " . $_REQUEST["productID"] . "\nDate: " . $date;
                exit();
            }
        } else {
            $deleteReportProductQuery = "DELETE FROM reportproduct WHERE productID={$_REQUEST["productID"]} AND userID={$_SESSION['userID']}";
            if (!mysqli_query($conn, $deleteReportProductQuery)) {
                die("The system is not available, try again later");
            } else {
                $conn->close();
                exit();
            }
        }
    }
} elseif($_REQUEST['do'] === "reportReview") {
    $date = date("Y-m-d");
    if(!isset($_SESSION['userID'])){
        echo "login";
    } else {
        $reportedReviewQuery = "SELECT * FROM reportreview WHERE reportinguserID={$_SESSION['userID']} AND reportedReviewID={$_REQUEST["reviewID"]}";
        $reportedReviewResult = mysqli_query($conn, $reportedReviewQuery);
        if(mysqli_num_rows($reportedReviewResult) == 0) {
            $insertReportQuery = "INSERT INTO reportreview (reportedReviewID, reportinguserID, rReportDate) VALUES (?,?,?)";
            $preparedInsertReport = mysqli_prepare($conn, $insertReportQuery);
            mysqli_stmt_bind_param($preparedInsertReport, 'iis', $_REQUEST["reviewID"], $_SESSION['userID'], $date);

            if (!mysqli_stmt_execute($preparedInsertReport)) {
                die("The system is not available, try again later");
            } else {
                mysqli_stmt_close($preparedInsertReport);
                $conn->close();
                echo "User ID: " . $_SESSION['userID'] . "\nReview ID: " . $_REQUEST["reviewID"] . "\nDate: " . $date;
                exit();
            }
        } else {
            $deleteReportReviewQuery = "DELETE FROM reportreview WHERE reportinguserID={$_SESSION['userID']} AND reportedReviewID={$_REQUEST["reviewID"]}";
            if (!mysqli_query($conn, $deleteReportReviewQuery)) {
                die("The system is not available, try again later");
            } else {
                $conn->close();
                exit();
            }
        }
    }

} elseif ($_GET['do'] === "like") {
    $reviewId = isset($_POST['rId']) ? $_POST['rId'] : null;
    if(!isset($_SESSION['userID'])){
        echo "login";
    } else {
        if($reviewId != null){
            $reviewRatingQuery = "SELECT * FROM reviewrating WHERE userID={$_SESSION['userID']} AND reviewID=$reviewId";
            $reviewRatingResult = mysqli_query($conn, $reviewRatingQuery);
            if(mysqli_num_rows($reviewRatingResult) == 0){
                $increaseRatingQuery = "INSERT INTO reviewrating VALUES ($reviewId,{$_SESSION['userID']},1)";
                if(mysqli_query($conn, $increaseRatingQuery)) {
                    $addPointForReview = "UPDATE users SET points = points + 1 WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                    if(mysqli_query($conn, $addPointForReview)) {
                        $userPointsQuery = "SELECT points FROM users WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                        $userPointsResult = mysqli_query($conn, $userPointsQuery);
                        $userPoints = mysqli_fetch_array($userPointsResult);
                        echo "$reviewId,{$userPoints['points']}";
                    }
                }
            } else {
                $reviewRating = mysqli_fetch_assoc($reviewRatingResult);
                if($reviewRating['helpful'] == 0){
                    $updateRatingQuery = "UPDATE reviewrating SET helpful = 1 WHERE userID={$_SESSION['userID']} AND reviewID=$reviewId";
                    if(mysqli_query($conn, $updateRatingQuery)){
                        $addPointForReview = "UPDATE users SET points = points + 1 WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                        if(mysqli_query($conn, $addPointForReview)) {
                            $userPointsQuery = "SELECT points FROM users WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                            $userPointsResult = mysqli_query($conn, $userPointsQuery);
                            $userPoints = mysqli_fetch_array($userPointsResult);
                            echo "$reviewId,{$userPoints['points']}";
                        }
                    }
                } else {
                    $deleteReviewRating = "DELETE FROM reviewrating WHERE reviewID={$reviewId} AND userID={$_SESSION['userID']}";
                    if(mysqli_query($conn, $deleteReviewRating)){
                        $removePointForReview = "UPDATE users SET points = points - 1 WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                        if(mysqli_query($conn, $removePointForReview)) {
                            $userPointsQuery = "SELECT points FROM users WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                            $userPointsResult = mysqli_query($conn, $userPointsQuery);
                            $userPoints = mysqli_fetch_array($userPointsResult);
                            echo "$reviewId,{$userPoints['points']}";
                        }
                    }
                }
            }
        }
    }
} elseif ($_GET['do'] === "dislike") {
    $reviewId = isset($_POST['rId']) ? $_POST['rId'] : null;
    if(!isset($_SESSION['userID'])){
        echo "login";
    } else {
        if($reviewId != null){
            $reviewRatingQuery = "SELECT * FROM reviewrating WHERE userID={$_SESSION['userID']} AND reviewID=$reviewId";
            $reviewRatingResult = mysqli_query($conn, $reviewRatingQuery);
            if(mysqli_num_rows($reviewRatingResult) == 0){
                $increaseRatingQuery = "INSERT INTO reviewrating VALUES ($reviewId,{$_SESSION['userID']},0)";
                if(mysqli_query($conn, $increaseRatingQuery)) {
                    $userPointsQuery = "SELECT points FROM users WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                    $userPointsResult = mysqli_query($conn, $userPointsQuery);
                    $userPoints = mysqli_fetch_array($userPointsResult);
                    echo "$reviewId,{$userPoints['points']}";
                }
            } else {
                $reviewRating = mysqli_fetch_assoc($reviewRatingResult);
                if($reviewRating['helpful'] == 1){
                    $updateRatingQuery = "UPDATE reviewrating SET helpful = 0 WHERE userID={$_SESSION['userID']} AND reviewID=$reviewId";
                    if(mysqli_query($conn, $updateRatingQuery)){
                        $addPointForReview = "UPDATE users SET points = points - 1 WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                        if(mysqli_query($conn, $addPointForReview)) {
                            $userPointsQuery = "SELECT points FROM users WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                            $userPointsResult = mysqli_query($conn, $userPointsQuery);
                            $userPoints = mysqli_fetch_array($userPointsResult);
                            echo "$reviewId,{$userPoints['points']}";
                        }
                    }
                } else {
                    $deleteReviewRating = "DELETE FROM reviewrating WHERE reviewID={$reviewId} AND userID={$_SESSION['userID']}";
                    if(mysqli_query($conn, $deleteReviewRating)){
                        $userPointsQuery = "SELECT points FROM users WHERE userID=(SELECT userID FROM reviews WHERE reviewID = $reviewId)";
                        $userPointsResult = mysqli_query($conn, $userPointsQuery);
                        $userPoints = mysqli_fetch_array($userPointsResult);
                        echo "$reviewId,{$userPoints['points']}";
                    }
                }

            }
        }
    }
}