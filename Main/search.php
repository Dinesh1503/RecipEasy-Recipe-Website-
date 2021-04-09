<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");
	
	$content = file_get_contents("elements/searchBar.html");
	$grid = new Template("elements/resultsGrid.tpl");

	if (array_key_exists("searchBtn", $_GET)) {
		$URL = getSearch();
		console_log($URL);
		$json_string = makeCURL($URL);	
			// parse JSON into useable objects
		$json = json_decode($json_string);
		console_log("$json_string");
		
		$results = "";
		$db_results = db_search();
		if (count($db_results) != 0) {
			for ($i = 0; $i < count($db_results); $i++) {
				$db_recipe = $db_results[$i];
				$result = new Template("elements/searchResult.tpl");
				$result->set("link", $db_recipe->link);
				$result->set("title", $db_recipe->title);
				$result->set("img", $db_recipe->image);
				$results = $results . $result->output();

				$elements = db_search();
			}
		}

		if ($json->totalResults != 0) {
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

				$result = new Template("elements/searchResult.tpl");
				$result->set("link", "recipe.php/?recipe_id=$recipe->id");
				$result->set("title", "$recipe->title");
				$result->set("img", "$recipe->image");
				$results = $results . $result->output();

				$elements = db_search();
			}
		}
		
		$grid->set("results", $results);
	}

	$layout = new Template("index.tpl");
	$layout->set("title", "Search");
	$layout->set("user", getUserElements());
	$layout->set("content", $content . $grid->output());
	echo($layout->output());
?>	