<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");
	
	$content = file_get_contents("elements/searchBar.html");
	$grid = "";
	if (array_key_exists("searchBtn", $_GET)) {
		$URL = getSearch();
		console_log($URL);
		$json_string = makeCURL($URL);	
			// parse JSON into useable objects
		$json = json_decode($json_string);
		console_log("$json_string");
		$grid = "<div class=\"searchResults\" ><div class=\"results-grid\">";
		if ($json->totalResults == 0) {
			$grid = $grid . "<a>No Results.</a>";
			echo("NONE");
		}
		$recipes = $json->results;
		for ($i = 0; $i < count($recipes); $i++) {
			$recipe = $recipes[$i];
			/*
			<ul>
				<li>Calories: $recipe->calories</li>
				<li>Carbs: $recipe->carbs</li>
				<li>Fat: $recipe->fat</li>
				<li>Protein: $recipe->protein</li>		
			<ul>
			Some basic information should be displayed in the grid item
			Can't get from search rn and dont got time
			Please sort out
			*/
			$grid = $grid . "
			<div class=\"result\">
				<a href=$recipe->spoonacularSourceUrl>
				<h2>$recipe->title</h2>
				<img src=$recipe->image style=\'width:20%; height:auto;\'></img>
				</a>
			</div>";
		}
		$grid = $grid . "</grid></div>";
	}

	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("user", getUserElements());
	$layout->set("content", $content . $grid);

	echo($layout->output());
?>	