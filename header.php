<!DOCTYPE html>
<html>
<head>
<title><?php echo htmlentities($title);?></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- Main custom CSS -->
<link rel="stylesheet" href="style.css">

<!-- Google font -->
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- jQueryUI library -->
<!--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
-->
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- Facebook login -->
<script src='fb-login/login-helper.js'></script>

<!--<script>
$(function() {
	$( "#searchq" ).autocomplete({
		source: 'prodsearch.php'
	});
});
</script>
-->

</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><img src="img/logo.png"></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<form action="/results.php" method="post" class="navbar-form" role="search">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="searchq" name="searchquery" maxlength="88" placeholder="Search for gifts - or leave blank to see all gifts" value="<?php if(isset($_POST['searchquery']) && $_POST['searchquery'] != "") { $searchquery = preg_replace('#[^a-z 0-9?!@.\-]#i', '', $_POST['searchquery']); echo $searchquery;} ?>">
                            
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<?php
						require_once 'db_conn.php';
						if (session_status() == PHP_SESSION_NONE) {
							session_start();
						}

						if(!isset($_SESSION['userID'])) {
							echo "<li><a href=\"#\" data-toggle=\"modal\" data-target=\"#loginModal\">Login / My Account</a></li>";
						} else {
							$User = $conn->query("SELECT * FROM users WHERE userID=" . $_SESSION['userID'])->fetch_assoc();
							$adminPanel = ($User['role'] == '0' ? "" : "\n\t\t\t\t\t\t\t\t\t\t<li><a href=\"/admin.php\">Admin Panel</a></li>\n\t\t\t\t\t\t\t\t\t\t<li role=\"separator\" class=\"divider\"></li>");
							
							print <<<END
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$_SESSION['userName']}<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="/profile.php">Profile</a></li>
										<li><a href="/wishlist.php?id={$_SESSION['userID']}">Wishlist</a></li>
										<li><a href="/newproduct.php">Add new product</a></li>
										<li role="separator" class="divider"></li>$adminPanel
										<li><a href="/action.php?do=logout">Logout</a></li>
									</ul>
								</li>
END;
						}

						$loginError = '';
						if(isset($_REQUEST['login'])){
							if($_REQUEST['login'] === "error") {
								$loginError = "Username or password is not correct";
								print <<<Modal
								<script>
									$(function() {
										$('#loginModal').modal('show');
									});
								</script>
Modal;
							}
						}
					?>
				</ul>
			</div>
		</div>
	</nav>
	<?php
		if(isset($_SESSION['userID'])) {
print <<<END
	<div class="row" style="margin-top: -20px; box-shadow: 0px 0px 10px #000;">
		<div class="col-md-12">
			<div class="bg-primary">
				<ul class="list-inline text-center" style="margin-bottom: 0px; padding: 5px 5px;">
					<li><a href="/newproduct.php" style="color: white;">Add a Product</a></li>
					<li>|</li>
					<li><a href="#" style="color: white;">Review a Product</a></li>
					<li>|</li>
					<li><a href="/newest.php" style="color: white;">Recently Added Products</a></li>
					<li>|</li>
					<li><a href="/wishlist.php?id={$_SESSION['userID']}" style="color: white;">See My Wishlist</a></li>
				</ul>
			</div>
		</div>
	</div>
END;
		} else {
print <<<END
	<div class="row" style="margin-top: -20px; box-shadow: 0px 0px 10px #000;">
		<div class="col-md-12">
			<div class="bg-primary">
				<ul class="list-inline text-center" style="margin-bottom: 0px; padding: 5px 5px;">
					<li><a href="/newest.php" style="color: white;">Recently Added Products</a></li>
					<li>| |</li>
					<li><a href="#" data-toggle="modal" data-target="#loginModal" style="color: white;"> Login To: Add a Gift | Review a Gift | Add Gifts to Your Wishlist</a></li>
				</ul>
			</div>
		</div>
	</div>
END;
		}
	?>
	<div class="container">
		<!-- Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Log in to Giftgoals or <a href="registration.php">Register</a> </h4>
					</div>
					<div class="modal-body">
						<form action="<?php echo htmlspecialchars("action.php?do=login"); ?>" method="post">
							<div class="form-group">
								<div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" onlogin="checkLoginState()"></div>
								<!--<button type="button" id="fb_login" class="btn btn-primary btn-lg btn-block"></button>-->
							</div>
							<hr>
							<div class="form-group">
								<input type="email" class="form-control" name="inputEmail" placeholder="Email" required="required">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="inputPassword" placeholder="Password" required="required">
							</div>
							<p class='text-danger'><?php echo $loginError ?></p>
							<button type="submit" name="loginBtn" class="btn btn-primary btn-lg btn-block">Log in</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php require_once "Functions.php"; ?>