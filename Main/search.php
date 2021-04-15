<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");
	
	$bar = new Template("elements/searchBar.tpl");
	$bar->set("cuisine", file_get_contents("elements/form-cuisine.tpl"));
	$bar->set("meal", file_get_contents("elements/form-meal.tpl"));
	$bar->set("diet", file_get_contents("elements/form-diet.tpl"));
	$bar->set("intolerances", file_get_contents("elements/form-intolerances.tpl"));
	
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

	$page = new Template("elements/page-search.tpl");
	$page->set("searchBar", $bar->output());
	$page->set("searchResults", $grid->output());
	
	$content = $page->output();

	$layout = new Template("index.tpl");
	$layout->set("title", "Search");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	echo($layout->output());
?>	