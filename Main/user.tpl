<html>
<head>
	<title>[@title]</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/temp-login.css">
</head>
<body>
	<!--HEADER -->
	<div id="page_container">
 		<header>
 			<h1>RecipEasy</h1>
 		</header>

 		<!--NAV BAR -->
 		<div class="navbar">
			<a href="index.php">Home</a>
			<a href="search.php">Search</a>
			<a href="db_search.php">DB Search</a>
			<a href="upload.php">Upload</a>
			<div class="dropdown-img">
				<img src="img/account.png" alt="account">
				<div class="downbtn">
					[@user]
				</div>
			</div>
		</div>
	<main>
		[@content]
		<br>
		<a href="signUp.php">Sign Up</a>
		<br>
		<a href="resetPassword.php">Reset Password</a>
		<br>
		<a href="index.php">Return to Main Page</a>
		<br>
	</main>

		<div class="footer">
 			<div class="contact_us">
 				<h3 style="color:white;">Contact Us:</h3>
 				<p>Automated Email: recipeasyreply@gmail.com</p>
 			</div>
			 <a href='https://pngtree.com/free-backgrounds'>free background photos from pngtree.com</a>

 		</div>
	</div>
</body>
</html>
