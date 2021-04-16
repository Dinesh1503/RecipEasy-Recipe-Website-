<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");

	$bar = new Template("elements/searchIngredientBar.tpl");

	if (isset($_SESSION)) {
		$user = getUserDB();

		$usePref = 1;
		if (isset($user["use_fridge"])) {
			$usePref = $user["use_fridge"];
		}

		if ($usePref == 1) {
			$bar->set("UsePreferences", "checked");
		}

	}

	$bar->set("cuisine", file_get_contents("elements/form-cuisine.tpl"));
	$bar->set("meal", file_get_contents("elements/form-meal.tpl"));


	$grid = new Template("elements/resultsGrid.tpl");

	if (array_key_exists("searchBtn", $_GET)) {
		$URL = getSearchIngredient();
		console_log($URL);
		$json_string = makeCURL($URL);
			// parse JSON into useable objects
		$json = json_decode($json_string);
		console_log("$json_string");

		$results = "";


		if (count($json) != 0) {
			for ($i = 0; $i < count($json); $i++) {
				$recipe = $json[$i];

				$result = new Template("elements/searchResult.tpl");
				$result->set("link", "recipe.php/?recipe_id=$recipe->id");
				$result->set("title", "$recipe->title");
				$result->set("img", "$recipe->image");
				$results = $results . $result->output();
			}
			$grid->set("results", $results);
		} else {
			$grid->set("results", "No results found.");
		}


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
