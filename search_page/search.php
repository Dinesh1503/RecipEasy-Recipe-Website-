<html>
<head>
	<title>RecipEasy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/base_style.css">
	<link rel="stylesheet" type="text/css" href="css/search.css">
</head>
<body>
	<!--HEADER -->
 		 <header>
      		<h1>RecipEasy</h1>
        	<div id="login_container">
          		<a href="../UserLogin/userLogin.php" class="login">Login</a>
				<a href="../UserLogin/signUp.php">Register</a>
         	</div>
    	</header>

 		<!--NAV BAR -->
 		<nav>
 			<div id="nav_container">
 				<a href="index.html">Main Page</a>
		 		|
		 		<a href="search.php">Search</a>
		 		|
		 		<a href="filt_page.html">Filter</a>
				|
		 		<a href="upload.php">Upload</a>
		 	</div>
 		</nav>

 		<!-- MAIN AREA -->
 		<main>
 			<div class="search-container">
                <?php include("search1.php"); ?>
 			</div>
 		</main>

 		<!-- FOOTER -->
 		<footer>
 		</footer>
</body>
</html>