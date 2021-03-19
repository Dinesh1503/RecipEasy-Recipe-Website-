<html>
<head>
	<title>RecipEasy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/base_style.css">
	<link rel="stylesheet" type="text/css" href="css/db_search.css">
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
 			<?php

 				$localSQL = true;
				if ($localSQL) {
					$servername = "localhost";
					$username   = "root";
					$password   = "root";
					$database   = "recipeasy";
				} else {
					$servername = "dbhost.cs.man.ac.uk";
					$username   = "e95562sp";
					$password   = "STORED_recipes+";
					$database   = "2020_comp10120_y14";
				}

				$conn = mysqli_connect($servername, $username, $password);

				$sql = "USE $database";
				$conn->query($sql);

 				$query = $_GET['query']; 

 				$recipe_check_query = "SELECT * FROM Recipe WHERE (`title` LIKE '%".$query."%')";
        		$result = mysqli_query($conn, $recipe_check_query);
	        	while($recipe = mysqli_fetch_assoc($result)){
	        		$recipe_id = $recipe['id'];
	        		$title = $recipe['title'];
	        		$cuisine_type = $recipe['cuisine_type'];
	        		$image_url = $recipe['image_url'];
	        		$number_of_servings = $recipe['number_of_servings'];
	        		$ready_in_minutes = $recipe['ready_in_minutes'];
	        		$description = $recipe['description'];
	        		$calories = $recipe['calories'];

	       			$ingredients_check_query = "SELECT * FROM ExtendedIngredient WHERE recipe_id=$recipe_id";
	       			$ingr_result = mysqli_query($conn, $ingredients_check_query);

	        		echo("<h1>".$title."</h1>");
	        		echo("<div id='image_container'><img src='".$image_url."'></div>");
	        		echo("<div id='info_container'><b>Ingredients:</b>");
	        		while($ingredient = mysqli_fetch_assoc($ingr_result)){
	        			echo("<p>".$ingredient['name']."</p>");
	        		}
	        		echo("<p><b>Number of servings: </b>".$number_of_servings."</p>
	        		<p><b>Ready in minutes: </b>".$ready_in_minutes."</p>
	        		<p><b>Calories: </b>".$calories."</p>
	        		<p><b>Instructions: </b></br>".$description."</p></div>");
	  			}
 			?>
 		</main>

 		<!-- FOOTER -->
 		<footer>
 		</footer>
</body>
</html>