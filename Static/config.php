<?php
    $localSQL = false;
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

	$conn = mysqli_connect($servername, $username, $password, $database);
?>
