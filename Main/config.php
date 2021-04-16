<?php
	const localSQL = true;
	const SAM = false;

	$conn = getConnSQL();

	$sql = 
		"CREATE TABLE User(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50) NOT NULL,
			password VARCHAR(128) NOT NULL,
			intls SET('Dairy','Egg','Gluten','Grain','Peanut','Seafood','Sesame','Shellfish', 'Soy','Sulfite','Tree Nut','Wheat'),
			diets SET('Gluten Free', 'Ketogenic', 'Vegetarian','Lacto-Vegetarian', 'Ovo-Vegetarian', 'Vegan', 'Pescetarian', 'Paleo', 'Primal', 'Whole30')
		)
	";
	$conn->query($sql);

	$sql = 
		"CREATE TABLE Recipe(
			recipe_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(256) NOT NULL,
			cuisine_type VARCHAR(128) NOT NULL,
			meal_type VARCHAR(128) NOT NULL,
			image_url TEXT NOT NULL,
			number_of_servings INT NOT NULL,
			ready_in_minutes INT NOT NULL,
			instructions TEXT NOT NULL,
			intls SET('Dairy','Egg','Gluten','Grain','Peanut','Seafood','Sesame','Shellfish', 'Soy','Sulfite','Tree Nut','Wheat'),
			diets SET('Gluten Free', 'Ketogenic', 'Vegetarian','Lacto-Vegetarian', 'Ovo-Vegetarian', 'Vegan', 'Pescetarian', 'Paleo', 'Primal', 'Whole30'),
			user_id INT NOT NULL REFERENCES User(id)
		)
	";
	$conn->query($sql);
	

	$sql = 
	"CREATE TABLE Ingredients(
		ingr_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		recipe_id INT REFERENCES Recipe(id),
		ingr_name VARCHAR(64) NOT NULL,
		ingr_amount FLOAT(8) NOT NULL,
		ingr_unit VARCHAR(16) NOT NULL
	)";
	$conn->query($sql);

	$sql = 
		"CREATE TABLE Fridge(
			fridge_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_id INT NOT NULL REFERENCES User(id),
			ingredient VARCHAR	(30) NOT NULL
		)
	";
	$conn->query($sql);

	$sql = 
		"CREATE TABLE FavRecipes (
  			fav_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  			fav_recipe_id INT NOT NULL,
  			fav_by INT NOT NULL
		)";
	$conn->query($sql);

	$sql = 
		"CREATE TABLE MealPlan (
		  meal_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
		  recipe_id INT NOT NULL REFERENCES Recipe(recipe_id),
		  user_id INT NOT NULL REFERENCES User(id),
		  meal_time varchar(256) NOT NULL,
		  meal_date varchar(256) NOT NULL
	)";
	$conn->query($sql);

	function getConnSQL() {
		if (localSQL) {
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
			$password   = "5+recipes";
			$database   = "e95562sp";
		}
		
		$conn = mysqli_connect($servername, $username, $password);
		$sql = "CREATE DATABASE IF NOT EXISTS $database";
		$conn->query($sql);
		$sql = "USE $database";
		$conn->query($sql);
		return mysqli_connect($servername, $username, $password, $database);
	}

	function getDatabase() {
		if (localSQL) {
			return "recipeasy";
		} else {
			return "e95562sp";
		}
	}

?>