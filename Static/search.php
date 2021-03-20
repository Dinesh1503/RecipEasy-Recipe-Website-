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
 					<?php
						session_start();
						session_regenerate_id();
						if(isset($_SESSION['user']))      // if there is no valid session
						{
						    echo("<div><b>".$_SESSION['user']."</b></div>");
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
 			<div class="search-container">
 				<form action="db_search.php" method="GET">
 				<h2>
					<b>Search :</b><input type="text" name="query" />
				</h2>
				<input type="submit" value="Search" />
			</form>
 			</div>
 		</main>

 		<!-- FOOTER -->
 		<footer>
 		</footer>
</body>
</html>