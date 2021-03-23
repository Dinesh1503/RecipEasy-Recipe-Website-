<?php	
	session_start();
	session_regenerate_id();
	require_once("main.php");

	$recipe_id = $_GET["recipe_id"];
	
	$URL = "https://api.spoonacular.com/recipes/" . $recipe_id. "/information" . "?" . API_KEY;
	$json_string = makeCURL($URL);
	$recipe = json_decode($json_string);

	$content = show_recipe($recipe);
	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	
	echo($layout->output());


?>