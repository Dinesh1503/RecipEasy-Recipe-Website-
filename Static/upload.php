<?php require_once("config.php"); ?>
<?php require_once("recipeForm.php"); ?>

<!DOCTYPE html>
<html>
<head>
<title>RecipeE</title>

<link rel="stylesheet" type="text/css" href="css/upload.css">
<link rel="stylesheet" type="text/css" href="css/base_style.css">

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
		 		<a href="search.html">Search</a>
		 		|
		 		<a href="filt_page.html">Filter</a>
				|
		 		<a href="upload.php">Upload</a>
		 	</div>
 		</nav>		

<!-- MAIN AREA -->
		 <main>
			<h1 >Upload Your Own Recipes!</h1>

			<div class="column">

			<?php
			    
			    $form = new RecipeForm();
			    echo $form->createUploadForm();
			    
			?>

		</div>

		</main>
<!-- FOOTER -->
 		<footer>
 		</footer>

</body>