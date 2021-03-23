<html>
<head>
	<title>RecipEasy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/base.css">
</head>
<body>
	<!--HEADER -->
 		<header>
 			<h1>RecipEasy</h1>
 				
 		</header>

 		<!--NAV BAR -->
 		<nav>
			<div>
				<a href="index.php">Home</a>
			</div>
			|
			<div>
				<a href="search.php">Search</a>
			</div>
			|
			<div>
				<a href="upload.php">Upload</a>
			</div>
			
			<div class="dropdown-img">
				<img src="img/account.png" alt="account">
				<div class="downbtn">
					<?php
						session_start();
						session_regenerate_id();
						if(isset($_SESSION['user'])) {     // if there is no valid session
							echo("<a href='#.php'>" . $_SESSION['user'] . "</a>");
							echo("<a href=\"#\">Meal Planning</a>");
							echo("<a href=\"#\">Update your Own Menu</a>");
							echo("<a href='logout.php' class ='login'>Logout</a>");
						}
						else {
							echo("<a href='userLogin.php' class='login'>Login</a>");
							echo("<a href='signUp.php'>Register</a>");
						}
					?>
				</div>
			</div>
			
			<div class="dropdown-img">
				<img src="img/functions.png" alt="functions">
				<div class="downbtn">
					<!-- 
						<a href="#">Wish list</a>
						<a href="#">Diet Tracker</a>
					-->
				</div>
			</div>

 		</nav>

 		<!-- MAIN AREA -->
 		<main>
			[@content]
 		</main>

 		<!-- FOOTER -->
		<style>
			footer div * {
			}
			
			.contact-table {
				display:table;
			}

			.contact-table-row {
				display:table-row;
			}

			.contact-table-row * {
				display:table-cell;
				padding-left:3px;
				padding-right:3px;
			}
		</style>
 		<footer>
		 	<h3>Contact Us:</h3>
			<div class="contact-table">
				<div class="contact-table-row"> 
					<h5>Project Leader:</h5>
					<h5></h5>
					<h5>Project Members:</h5>
					<h5></h5>
					<h5>Project Tutor:</h5>
					<h5></h5>
				</div>
				<div class="contact-table-row"> 
					<p>Sam Pearson-Smith</p>
					<p>sam.pearson-smith@student.manchester.ac.uk</p>
					<p>Angel Kodjaivanov</p>
					<p>angel.kodjaivanov@student.manchester.ac.uk</p>
					<p>Xiaojun Zeng</p>
					<p>x.zeng@manchester.ac.uk</p>
				</div>
				<div class="contact-table-row"> 
					<p>Automated Email</p>
					<p>RecipEasyReply@gmail.com</p>
					<p>Dinesh Selvam</p>
					<p>dinesh.selvam@student.manchester.ac.uk</p>
					<p></p>
					<p></p>
				</div>
				<div class="contact-table-row"> 
					<p></p>
					<p></p>
					<p>Ethan Dawson</p>
					<p>ethan.dawson@student.manchester.ac.uk</p>
					<p></p>
					<p></p>
				</div>
				<div class="contact-table-row"> 
					<p></p>
					<p></p>
					<p>Jiachen Fan</p>
					<p>jiachen.fan@student.manchester.ac.uk</p>
					<p></p>
					<p></p>
				</div>
				<div class="contact-table-row"> 
					<p></p>
					<p></p>
					<p>Toby Ord</p>
					<p>toby.ord@student.manchester.ac.uk</p>
					<p></p>
					<p></p>
				</div>
				<div class="contact-table-row"> 
					<p></p>
					<p></p>
					<p>Yunyi Zhang</p>
					<p>yunyi.zhang@student.manchester.ac.uk</p>
					<p></p>
					<p></p>
				</div>

			</div>
		 	
 		</footer>
</body>
</html>