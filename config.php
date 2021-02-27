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

	$sql = "CREATE DATABASE recipeasy" ;
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
		CREATE TABLE Food(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(128) NOT NULL
		)
	";
	$conn->query($sql);

	$sql = "
		CREATE TABLE Ingredient(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(128) NOT NULL,
			quantity FLOAT(8) NOT NULL,
			weight FLOAT(8) NOT NULL,
			category VARCHAR(128) NOT NULL,
			recipe_id INT(8) REFERENCES Recipe(id),
			food_id INT(8) REFERENCES Food(id),
			CONSTRAINT ingredient_food UNIQUE(food_id)
		)
	";
	$conn->query($sql);

	$sql = "
		CREATE TABLE Recipe(
			id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(256) NOT NULL,
			cuisine_type VARCHAR(128) NOT NULL,
			image_url TEXT NOT NULL,
			original_site_url TEXT NOT NULL,
			number_of_servings INT(6) NOT NULL,
			calories FLOAT(5) NOT NULL,
			total_weight FLOAT(8) NOT NULL,
			total_nutrients TEXT NOT NULL,
			total_daily TEXT NOT NULL,
			diet_labels TEXT NOT NULL,
			health_labels TEXT NOT NULL,
			description TEXT NOT NULL,
			user_id INT(8) REFERENCES User(id)
		)
	";
	$conn->query($sql);

?>
