<?php
	$servername = "localhost";
	$username   = "root";
	$password   = "root";
	$database   = "recipeasy";

	$conn = mysqli_connect($servername, $username, $password, $database);

	$sql = "CREATE DATABASE recipeasy" ;
	$conn->query($sql);

	$sql = "
		CREATE TABLE user(
			user_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50) NOT NULL,
			password VARCHAR(100) NOT NULL
		)
	";
?>