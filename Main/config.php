<?php
$localSQL = true;
	if ($localSQL) {
		$servername = "localhost";
		$username   = "root";
		$password   = "root";
		if (SAM == true) {
			$password = "";
		}
		$database   = "recipeasy";
	} else {
		$servername = "dbhost.cs.man.ac.uk";
		$username   = "e95562sp";
		$password   = "STORED_recipes+";
		$database   = "2020_comp10120_y14";
	}

	$conn = mysqli_connect($servername, $username, $password, $database);

	$sql = "CREATE DATABASE IF NOT EXISTS recipeasy" ;
	$conn->query($sql);

	$sql = "USE $database";
	$conn->query($sql);

	$sql = "
		CREATE TABLE User(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50) NOT NULL,
			password VARCHAR(128) NOT NULL
		)
	";
	$conn->query($sql);

	$sql = "
		CREATE TABLE Ingredient(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(128) NOT NULL,
			image TEXT,
			extended_ingredient_id INT(8) REFERENCES ExtendedIngredient(id)
		)
	";
	$conn->query($sql);

	$sql = "
		CREATE TABLE ExtendedIngredient(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name TEXT NOT NULL,
			amount FLOAT(8) NOT NULL,
			original TEXT NOT NULL,
			unit VARCHAR(16) NOT NULL,
			recipe_id INT(8) REFERENCES Recipe(id)
		)
	";
	$conn->query($sql);

	$sql = "
		CREATE TABLE Recipe(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(256) NOT NULL,
			cuisine_type VARCHAR(128) NOT NULL,
			image_url TEXT NOT NULL,
			image_type VARCHAR(12) NOT NULL,
			number_of_servings INT(6) NOT NULL,
			ready_in_minutes INT(6) NOT NULL,
			license TEXT,
			source_name VARCHAR(128),
			source_site_url TEXT,
			aggregate_lies INT(6),
			health_score INT(6),
			price_per_serving FLOAT(6),
			cheap TINYINT(1),
			dairy_free TINYINT(1),
			gluten_free TINYINT(1),
			ketogenic TINYINT(1),
			sustainable TINYINT(1),
			vegan TINYINT(1),
			vegetarian TINYINT(1),
			very_healthy TINYINT(1),
			very_popular TINYINT(1),
			calories FLOAT(5) NOT NULL,
			description TEXT NOT NULL,
			user_id INT(8) REFERENCES User(id)
		)
	";
	$conn->query($sql);

	$sql = "
		CREATE TABLE FavRecipes (
  			id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  			favRecipeId int(11) NOT NULL,
  			favBy int(11) NOT NULL
		)";

	$conn->query($sql);

	$sql = 
		"CREATE TABLE MealPlan (
		  mealTime varchar(256) NOT NULL,
		  id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		  recipe_id int(11) NOT NULL,
		  user_id int(11) NOT NULL,
		  mealDate varchar(256) NOT NULL
	)";

	$conn->query($sql);
?>