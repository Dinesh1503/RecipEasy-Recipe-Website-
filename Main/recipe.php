
<?php
	session_start();
	session_regenerate_id();
	require_once("main.php");

    $recipe_id = strval($_GET["recipe_id"]);
    
	// only if not exist, call api
	$content = show_recipe($recipe_id);

	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	
	echo($layout->output());
?>	

