<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$title = "Gift Goals - Registration";
require_once 'db_conn.php';
require_once 'Functions.php';
extract($_POST);
$signUpError = '';

if(isset($submit)){
    $_SESSION['inputEmail'] = isset($inputEmail) ? $inputEmail : null;
    $_SESSION['inputUsername'] = isset($inputUsername) ? $inputUsername : null;
    $inputPassword = isset($inputPassword) ? $inputPassword : "";
    $_SESSION['inputBirthYear'] = isset($inputBirthYear) ? $inputBirthYear : null;

    $signUpError = validatePassword($inputPassword);
    $filledForm = $_SESSION['inputEmail'] && $_SESSION['inputUsername'] && $inputPassword && $_SESSION['inputBirthYear'];

    if(!$filledForm){
        $signUpError = "Please fill in all of the registration form fields";
    }else{
        if($signUpError == "") {
            $inputPassword = crypt($inputPassword, '$2a$09$jLSvGh1mFkVIoQXzn5gYs7$');

            $emailQuery = "SELECT email FROM users WHERE email=?";
            $uerNameQuery = "SELECT userName FROM users WHERE userName=?";

            $preparedEmailSelect = mysqli_prepare($conn, $emailQuery);
            mysqli_stmt_bind_param($preparedEmailSelect, 's', $inputEmail);
            mysqli_stmt_execute($preparedEmailSelect);
            mysqli_stmt_store_result($preparedEmailSelect);
            $emailCounter = mysqli_stmt_num_rows($preparedEmailSelect);

            $preparedUserNameSelect = mysqli_prepare($conn, $uerNameQuery);
            mysqli_stmt_bind_param($preparedUserNameSelect, 's', $inputUsername);
            mysqli_stmt_execute($preparedUserNameSelect);
            mysqli_stmt_store_result($preparedUserNameSelect);
            $userNameCounter = mysqli_stmt_num_rows($preparedUserNameSelect);

            if($emailCounter != 0){
                $signUpError = "User with this email is already registered";
            }
            if($userNameCounter != 0){
                $signUpError = "This username is already taken";
            }
            if($emailCounter == 0 && $userNameCounter == 0){
                $insertUser = "INSERT INTO users ( email, userName, password, birth, uDateAdded, image) VALUES(?, ?, ?, ?, ?, ?)";
                $preparedUserInsert = mysqli_prepare($conn, $insertUser);
                $date = date("Y-m-d");
                $image = "img/user.png";
                mysqli_stmt_bind_param($preparedUserInsert, 'sssiss', $inputEmail, $inputUsername, $inputPassword, $inputBirthYear, $date, $image);

                if (!mysqli_stmt_execute($preparedUserInsert)) {
                    die("The system is not available, try again later");
                }else{
                    $uerIdQuery = "SELECT userID, userName FROM users WHERE email='$inputEmail'";
                    $idResult = mysqli_query($conn, $uerIdQuery);
                    $user = mysqli_fetch_assoc($idResult);
                    $_SESSION['userID'] = $user['userID'];
                    $_SESSION['userName'] = $user['userName'];
                }

                mysqli_close($conn);
                header('Location: index.php');
                exit();
            }
        }
    }
}

include_once "header.php";
?>

<div class="container">
    <h2 class="text-center">Account Registration</h2>
    <p class="text-center">Please create account using your email or sign up with Facebook</p>

    <div class="row">
        <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="col-sm-5 col-sm-offset-1">
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="inputEmail" class="form-control" placeholder="Email" required="required" value="<?php echo isset($_SESSION['inputEmail']) ? $_SESSION['inputEmail'] : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUsername" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" name="inputUsername" class="form-control" placeholder="Username" required="required" value="<?php echo isset($_SESSION['inputUsername']) ? $_SESSION['inputUsername'] : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" id="ps" name="inputPassword" class="form-control" placeholder="Password" required="required" data-trigger="focus" data-placement="right" data-container="body" data-content="Password must have at least one upper case letter, one lower case letter, one numeric character and must be at least 8 characters long." >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputBirthYear" class="col-sm-3 control-label">Birth Year</label>
                    <div class="col-sm-9">
                        <input type="number" name="inputBirthYear" class="form-control" placeholder="Birth Year" required="required" value="<?php echo isset($_SESSION['inputBirthYear']) ? $_SESSION['inputBirthYear'] : ''; ?>">
                        <p class='text-danger' id="signUpError"><?php echo $signUpError ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-6">
                        <button type="submit" name="submit" id="createAccount" class="btn btn-default">Create Account</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-1" id="registrationDivider">
            <div class="divider"></div>
            <p id="or">OR</p>
            <div class="divider"></div>
        </div>
        <div class="col-sm-3">
            <div id="social">
                <?php
                    if(!isset($_SESSION['fb_access_token'])){
                        //echo "<button type=\"button\" id=\"fb_signup\" onClick='checkLoginState()'></button> Sign in with Facebook";
                        echo "<div class=\"fb-login-button\" data-max-rows=\"1\" data-size=\"xlarge\" data-show-faces=\"false\" onlogin=\"checkLoginState()\"></div>";
                    }
                ?>
            </div>
<!--            <div id="social">
                <?php /*include_once "g-home.php"; */?>
            </div>-->
            <!--<div class="row"><button type="button" id="cancel" class="btn btn-default">Cancel</button></div>-->
        </div>
    </div>
</div>
<script>
    $('#ps').focus(function(){
        $('#ps').popover('show');
    });

    $('#ps').blur(function(){
        $('#ps').popover('hide');
    });
</script>
<?php include_once "footer.php"; ?>