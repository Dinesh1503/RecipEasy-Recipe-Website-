<html>
<head>
	<title>RecipEasy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/base_style.css">
</head>
<body>
	<!--HEADER -->
 		<header>
 			<h1>RecipEasy</h1>
 				<div id="login_container">
 					<?php
						session_start();
						session_regenerate_id();
						if(isset($_SESSION['user']))      // if there is no valid session
						{
						    echo("<a href='#.php'><b>".$_SESSION['user']."</b></a>");
						    echo("<a href='logout.php' class ='login'>Logout</a>");
						}
						else{
							echo("<a href='../UserLogin/userLogin.php' class='login'>Login</a>
				 				  <a href='../UserLogin/signUp.php'>Register</a>");
						}
					?>
				 </div>
 		</header>

 		<!--NAV BAR -->
 		<nav>
 			<div id="nav_container">
 				<a href="index.php">Main Page</a>
		 		|
		 		<a href="search.php">Search</a>
		 		|
		 		<a href="filt_page.php">Filter</a>
				|
		 		<a href="upload.php">Upload</a>
		 	</div>
 		</nav>

 		<!-- MAIN AREA -->
 		<main>
 			<div style="width: 60%; margin-left: 20%; text-align: center;">
 				<h1 style="margin: 0px; padding-top: 30px;">Welcome to RecipEasy</h1>
 				<h2>To use our website please click on of the options in the menu above</h2>
 				<img src="main_page.jpeg" style="width: 60%">
 			</div>
 		</main>

 		<!-- FOOTER -->
 		<footer>
 		</footer>
</body>
</html>