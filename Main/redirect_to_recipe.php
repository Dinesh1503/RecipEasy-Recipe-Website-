<?php
	session_start();
	$_SESSION['recipe_id'] = strval($_GET["db_id"]);
	header("Location: ../recipe.php");
?>