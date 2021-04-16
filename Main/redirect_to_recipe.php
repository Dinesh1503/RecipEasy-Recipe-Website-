<?php
	session_start();
	$_SESSION['recipe_id'] = strval($_GET["recipe_id"]);
	header("Location: ../recipe.php");
?>